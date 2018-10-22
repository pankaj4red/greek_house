<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Events\Campaign\DecoratorAssigned;
use App\Events\Campaign\FulfillmentIssueSolved;
use App\Events\Campaign\SuppliesFixed;
use App\Http\Controllers\BlockController;
use App\Models\Campaign;
use App\Models\CampaignSupply;
use App\Models\CampaignSupplyEntry;
use Carbon\Carbon;
use Illuminate\Http\Request;
use mikehaertl\pdftk\Pdf;

class SendPrinterController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.send_printer');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        $defaultDueDate = $this->getCampaign()->flexible == 'no' ? date('m/d/Y', strtotime($this->getCampaign()->date)) : Carbon::parse('+ 10 weekdays')->format('m/d/Y');

        return $this->view('blocks.popup.send_printer', [
            'sizeTable'      => $this->getSizeTable($this->getCampaign()),
            'defaultDueDate' => $defaultDueDate,
            'print'          => false,
            'showCost'       => true,
        ]);
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $form = form($request)->withRules([
            'design_type'                   => 'required|in:screen,embroidery',
            'polybag_and_label'             => 'required|in:yes,no',
            'fulfillment_shipping_name'     => 'required|max:255',
            'fulfillment_shipping_phone'    => 'required|max:255',
            'fulfillment_shipping_line1'    => 'required|max:255',
            'fulfillment_shipping_line2'    => 'max:255',
            'fulfillment_shipping_city'     => 'required|max:255',
            'fulfillment_shipping_state'    => 'required|max:255',
            'fulfillment_shipping_zip_code' => 'required|digits:5',
            'garment_arrival_date'          => 'required|date',
            'sizes'                         => 'required',
            'printing_date'                 => 'required|date',
            'rush'                          => 'required|in:yes,no',
            'flexible'                      => 'required|in:yes,no',
            'date'                          => 'required',
            'days_in_transit'               => 'required|integer|min:1',
            'decorator_pocket'              => 'required|in:yes,no',
            'shipping_option'               => 'required|max:255',
            'speciality_inks'               => 'required|in:yes,no',
            'embellishment_names'           => 'required|in:yes,no',
            'embellishment_numbers'         => 'required|in:yes,no',
        ]);
        if (get_phone($request->get('fulfillment_shipping_phone')) == false) {
            $form->error('Shipping Phone needs 10 digits');
        }
        $form->validate();

        $supplyList = json_decode($request->get('sizes'));
        $handled = [];
        $firstDecorator = false;
        $differentDecorator = false;
        $badGarment = false;

        $supplies = $this->getCampaign()->supplies;

        foreach ($supplyList as $supplyEntry) {
            $allQuantityTable = 0;
            foreach ($supplyEntry->sizes as $size => $quantity) {
                $allQuantityTable += $quantity;
            }
            if ($supplyEntry->id != 0) {
                $found = false;
                foreach ($supplies as $campaignSupply) {
                    if ($campaignSupply->id == $supplyEntry->id) {
                        $found = true;
                        $handled[] = $supplyEntry->id;
                        $changed = false;
                        $supplySizesHandled = [];
                        foreach ($campaignSupply->entries as $entry) {
                            if (! in_array($entry->size->short, $supplySizesHandled) && isset($supplyEntry->sizes->{$entry->size->short}) && $entry->quantity != $supplyEntry->sizes->{$entry->size->short} && $supplyEntry->sizes->{$entry->size->short} > 0) {
                                $entry->update([
                                    'quantity' => $supplyEntry->sizes->{$entry->size->short},
                                ]);
                                $changed = true;
                                $supplySizesHandled[] = $entry->size->short;
                            } elseif (in_array($entry->size->short, $supplySizesHandled) || ! isset($supplyEntry->sizes->{$entry->size->short}) || ($entry->quantity != $supplyEntry->sizes->{$entry->size->short} && $supplyEntry->sizes->{$entry->size->short} == 0)) {
                                $entry->delete();
                                $changed = true;
                            }
                            $supplySizesHandled[] = $entry->size->short;
                        }
                        foreach ($supplyEntry->sizes as $size => $quantity) {
                            if ($quantity > 0 && ! in_array($size, $supplySizesHandled)) {
                                $price = $this->getCampaign()->quote_final + extra_size_charge($size);
                                campaign_supply_entry_repository()->create([
                                    'campaign_supply_id' => $campaignSupply->id,
                                    'quantity'           => $quantity,
                                    'garment_size_id'    => garment_size_repository()->findByShort($size)->id,
                                    'price'              => $price,
                                    'subtotal'           => $price * $quantity,
                                ]);
                                $changed = true;
                            }
                        }
                        if ($campaignSupply->supplier_id != $supplyEntry->supplier || $campaignSupply->eta != $supplyEntry->eta || $campaignSupply->quantity != $allQuantityTable || $campaignSupply->ship_from != $supplyEntry->ship_from || $campaignSupply->total != $supplyEntry->total) {
                            $changed = true;
                        }
                        if ($changed == true) {
                            $campaignSupply->update([
                                'product_color_id' => $supplyEntry->color,
                                'color_id'         => $supplyEntry->color,
                                'supplier_id'      => $supplyEntry->supplier,
                                'eta'              => $supplyEntry->eta,
                                'quantity'         => $allQuantityTable,
                                'ship_from'        => $supplyEntry->ship_from,
                                'total'            => $supplyEntry->total,
                            ]);
                        }
                    }
                }
                if ($found == false) {
                    form()->error('Order Form Outdated. Please try again.')->back();
                }
            } else {
                $campaignSupply = campaign_supply_repository()->create([
                    'campaign_id'      => $this->getCampaign()->id,
                    'supplier_id'      => $supplyEntry->supplier,
                    'product_color_id' => $this->getCampaign()->product_colors->first()->id,
                    'color_id'         => $this->getCampaign()->product_colors->first()->id,
                    'eta'              => $supplyEntry->eta,
                    'quantity'         => $allQuantityTable,
                    'ship_from'        => $supplyEntry->ship_from,
                    'total'            => $supplyEntry->total,
                ]);

                foreach ($supplyEntry->sizes as $size => $quantity) {
                    $price = $this->getCampaign()->quote_final + extra_size_charge($size);

                    campaign_supply_entry_repository()->create([
                        'campaign_supply_id' => $campaignSupply->id,
                        'quantity'           => $quantity,
                        'garment_size_id'    => garment_size_repository()->findByShort($size)->id,
                        'price'              => $price,
                        'subtotal'           => $price * $quantity,
                    ]);
                }
            }
        }

        /** @var CampaignSupply $supply */
        foreach ($supplies as $supply) {
            if (! in_array($supply->id, $handled)) {
                /** @var CampaignSupplyEntry $entry */
                foreach ($supply->entries as $entry) {
                    $entry->delete();
                }
                $supply->delete();
            }
        }

        $campaign = $this->getCampaign();
        $campaign->polybag_and_label = ($request->has('polybag_and_label') && $request->get('polybag_and_label') == 'yes') ? true : false;
        $campaign->fulfillment_shipping_name = $request->get('fulfillment_shipping_name');
        $campaign->fulfillment_shipping_phone = $request->get('fulfillment_shipping_phone');
        $campaign->fulfillment_shipping_line1 = $request->get('fulfillment_shipping_line1');
        $campaign->fulfillment_shipping_line2 = $request->get('fulfillment_shipping_line2');
        $campaign->fulfillment_shipping_city = $request->get('fulfillment_shipping_city');
        $campaign->fulfillment_shipping_state = $request->get('fulfillment_shipping_state');
        $campaign->fulfillment_shipping_zip_code = $request->get('fulfillment_shipping_zip_code');
        $campaign->fulfillment_shipping_country = $request->get('fulfillment_shipping_country') ?? 'usa';

        $campaign->fulfillment_notes = $request->get('fulfillment_notes');

        $campaign->address_line1 = $campaign->fulfillment_shipping_line1;
        $campaign->address_line2 = $campaign->fulfillment_shipping_line2;
        $campaign->address_city = $campaign->fulfillment_shipping_city;
        $campaign->address_state = $campaign->fulfillment_shipping_state;
        $campaign->address_zip_code = $campaign->fulfillment_shipping_zip_code;
        $campaign->address_country = $campaign->fulfillment_shipping_country;

        $changedState = false;
        if ($campaign->state == 'fulfillment_ready') {
            $campaign->state = 'fulfillment_validation';
            $changedState = true;
        }
        if ($campaign->state == 'fulfillment_validation' && ! $campaign->fulfillment_valid && $campaign->fulfillment_invalid_reason == 'Garment') {
            $campaign->fulfillment_valid = true;
            $campaign->fulfillment_invalid_reason = null;
            $campaign->fulfillment_invalid_text = null;

            success('Fulfillment Garment Issue marked as Solved');
            add_comment_fulfillment($id, 'Garment Issue marked as solved: Order Form Updated'."\r\n"."Please update the print date if it has changed", \Auth::user()->id);
            event(new FulfillmentIssueSolved($this->getCampaign()->id));
        }
        if ($campaign->decorator_id != $request->get('decorator')) {
            if ($campaign->decorator_id === null) {
                $firstDecorator = true;
            }
            $differentDecorator = true;
        }
        $campaign->decorator_id = $request->get('decorator');
        $campaign->garment_arrival_date = $request->get('garment_arrival_date') ? Carbon::parse($request->get('garment_arrival_date')) : null;
        $campaign->rush = $request->get('rush') == 'yes' ? true : false;
        $campaign->flexible = $request->get('flexible');
        $campaign->printing_date = $request->get('printing_date') ? Carbon::parse($request->get('printing_date')) : null;

        $campaign->due_at = $request->get('date') ? Carbon::parse($request->get('date')) : null;
        $campaign->date = $request->get('date') ? Carbon::parse($request->get('date')) : null;
        $campaign->days_in_transit = $request->get('days_in_transit');
        $campaign->decorator_pocket = $request->get('decorator_pocket');
        $campaign->shipping_option = $request->get('shipping_option');

        $campaign->artwork_request->update([
            'design_type'           => $request->get('design_type'),
            'speciality_inks'       => $request->get('speciality_inks'),
            'embellishment_names'   => $request->get('embellishment_names'),
            'embellishment_numbers' => $request->get('embellishment_numbers'),
        ]);

        if ($campaign->artwork) {
            $campaign->artwork->update([
                'design_type'           => $request->get('design_type'),
                'speciality_inks'       => $request->get('speciality_inks'),
                'embellishment_names'   => $request->get('embellishment_names'),
                'embellishment_numbers' => $request->get('embellishment_numbers'),
            ]);
        }

        $campaign->save();
        if ($changedState == true) {
            $form->success('Campaign Associated with Decorator');
        } else {
            $form->success('Order Form Updated');
        }
        if ($differentDecorator) {
            event(new DecoratorAssigned($this->getCampaign()->id, $request->get('decorator')));
        }
        if ($firstDecorator) {
            add_comment($campaign->id, 'Hey '.$campaign->user->first_name."\n".'Here is the order list for you:'."\n".'[url='.route('report::campaign_shipping_pdf', [$campaign->id]).']shipping_file_'.$campaign->id.'.pdf[/url]'."\n".$this->yourOrderWillArriveMessage($campaign)."\n".'If you have any additional questions or concerns, please let us know.'."\n".'Best,'."\n".'Greek House');
        }
        if ($badGarment) {
            event(new SuppliesFixed($this->getCampaign()->id));
        }

        return $form->back();
    }

    public function getReview($id)
    {
        $this->forceCanBeAccessed('review');

        return $this->view('blocks.popup.send_printer', [
            'sizeTable' => $this->getSizeTable($this->getCampaign()),
            'edit'      => false,
            'print'     => false,
            'showCost'  => $this->hasToken('show_cost'),
        ]);
    }

    public function getDownload($id)
    {
        $this->forceCanBeAccessed('download');

        $pdf = \PDF::loadView('blocks.popup.send_printer', [
            'campaign'  => $this->getCampaign(),
            'sizeTable' => $this->getSizeTable($this->getCampaign()),
            'edit'      => false,
            'print'     => true,
            'showCost'  => false,
        ]);
        $pdf->setOption('margin-top', 5);
        $pdf->setOption('margin-bottom', 0);
        $pdf->setOption('margin-left', 0);
        $pdf->setOption('margin-right', 0);
        $pdf->setOption('page-width', 2400);
        $pdf->setOption('viewport-size', 1200);
        $pdf->setOption('zoom', 0.5);
        $pdf->save(sys_get_temp_dir().DIRECTORY_SEPARATOR.'order_form_'.$this->getCampaign()->id.'.pdf', true);
        $mainPdf = new Pdf(sys_get_temp_dir().DIRECTORY_SEPARATOR.'order_form_'.$this->getCampaign()->id.'.pdf');

        $additionalPages = [];
        if ($this->getCampaign()->fulfillment_notes) {
            $pdf = \PDF::loadView('blocks.popup.send_printer_notes', [
                'notes' => $this->getCampaign()->fulfillment_notes,
            ]);

            $pdf->setOption('margin-top', 5);
            $pdf->setOption('margin-bottom', 5);
            $pdf->setOption('margin-left', 5);
            $pdf->setOption('margin-right', 5);
            $pdf->setOption('page-width', 2400);
            $pdf->setOption('viewport-size', 1200);
            $pdf->setOption('zoom', 0.5);
            $pdf->save(sys_get_temp_dir().DIRECTORY_SEPARATOR.'order_form_'.$this->getCampaign()->id.'_notes.pdf', true);
            $additionalPages[] = new Pdf(sys_get_temp_dir().DIRECTORY_SEPARATOR.'order_form_'.$this->getCampaign()->id.'_notes.pdf');
        }

        foreach ($this->getCampaign()->artwork_request->proofs as $proof) {
            $pdf = \PDF::loadView('blocks.popup.send_printer__proof', [
                'proofId' => $proof->file_id,
            ]);
            $pdf->setOption('margin-top', 5);
            $pdf->setOption('margin-bottom', 5);
            $pdf->setOption('margin-left', 5);
            $pdf->setOption('margin-right', 5);
            $pdf->setOption('page-width', 2400);
            $pdf->setOption('viewport-size', 1200);
            $pdf->setOption('zoom', 0.5);
            $pdf->save(sys_get_temp_dir().DIRECTORY_SEPARATOR.'order_form_'.$this->getCampaign()->id.'_'.$proof->id.'.pdf', true);
            $additionalPages[] = new Pdf(sys_get_temp_dir().DIRECTORY_SEPARATOR.'order_form_'.$this->getCampaign()->id.'_'.$proof->id.'.pdf');
        }
        //add packing slip
        $additionalPages[] = new Pdf(public_path('temp_pdf').$this->getPackingPage($id));
        //add shipping pdf
        $additionalPages[] = new Pdf(public_path('temp_pdf').$this->getShippingPage($id));

        $finalPdf = new Pdf(array_merge([$mainPdf], $additionalPages));
        $finalPdf->needAppearances();
        $finalPdf->send('Campaign #'.$this->getCampaign()->id.' - '.$this->getCampaign()->name.' - Order Form.pdf', false);

        return '';
    }

    private function needsExtendedTime($campaign)
    {
        return $campaign->speciality_inks == 'yes' || $campaign->embellishment_names == 'yes' || $campaign->embellishment_numbers == 'yes';
    }

    /**
     * @param Campaign $campaign
     * @return string
     */
    private function yourOrderWillArriveMessage($campaign)
    {
        if ($campaign->getCurrentArtwork()->design_type == 'screen') {
            if ($this->needsExtendedTime($campaign)) {
                return 'Your Order will arrive within 14 business days unless specified otherwise.';
            } else {
                return 'Your Order will arrive within 10 Business Days unless specified otherwise.';
            }
        }

        if ($campaign->getCurrentArtwork()->design_type == 'embroidery') {
            return 'Your Order will arrive within 13 business days unless specified otherwise.';
        }

        return '';
    }

    public function getShippingPage($id)
    {
        if (! \Auth::user()) {
            \App::abort(403, 'Access denied');
        }
        if (! \Auth::user()->hasCampaign($id) && ! \Auth::user()->isType(['admin', 'support', 'decorator'])) {
            \App::abort(403, 'Access denied');
        }
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            \App::abort(404, 'Not Found');
        }
        $orderGroups = [];
        foreach ($campaign->success_orders as $order) {
            foreach ($order->entries as $entry) {
                if (! isset($orderGroups[$order->contact_email.'#'.$entry->size->short])) {
                    $orderGroups[$order->contact_email.'#'.$entry->size->short] = [
                        'name'     => $order->contact_first_name.' '.$order->contact_last_name,
                        'size'     => $entry->size->short,
                        'quantity' => 0,
                    ];
                }
                $orderGroups[$order->contact_email.'#'.$entry->size->short]['quantity'] += $entry->quantity;
            }
        }
        $fields = ['Order Number and Name' => $campaign->id.' - '.$campaign->name];
        $files = [new Pdf(public_path('shipping_form.pdf'))];
        $index = 0;
        $orderGroupSorted = sortOrderGroups($orderGroups);
        foreach ($orderGroupSorted as $group) {
            $subIndex = (($index % 29) + 1);
            $fields['Name Row '.($subIndex >= 28 ? ($subIndex + 1) : $subIndex)] = $group['name'];
            $fields['SIZERow'.$subIndex] = $group['size'];
            $fields['QUANTITYRow'.$subIndex] = $group['quantity'];

            $index++;
            if ($index % 29 == 0 && $index < count($orderGroupSorted)) {
                $files[count($files) - 1]->fillForm($fields);
                $files[count($files) - 1]->flatten();
                $files[] = new Pdf(public_path('shipping_form.pdf'));
                $fields = ['Order Number and Name' => $campaign->id.' - '.$campaign->name];
            }
        }

        $files[count($files) - 1]->fillForm($fields);
        $files[count($files) - 1]->flatten();
        $finalPdf = new Pdf($files);
        $finalPdf->needAppearances();
        $pdfName = '/shipping_file_'.$campaign->id.'.pdf';
        if (! $finalPdf->saveAs(public_path('temp_pdf').$pdfName)) {
            throw new \Exception('Could not create PDF: '.$finalPdf->getError());
        }

        return $pdfName;
    }

    public function getPackingPage($id)
    {
        if (! \Auth::user()) {
            \App::abort(403, 'Access denied');
        }
        if (! \Auth::user()->hasCampaign($id) && ! \Auth::user()->isType(['admin', 'support', 'decorator'])) {
            \App::abort(403, 'Access denied');
        }
        $campaign = campaign_repository()->find($id);
        if ($campaign == null) {
            \App::abort(404, 'Not Found');
        }
        $fields = [];
        $toField = $campaign->getContactFullName();
        $toField .= ' '.$campaign->address_line1;
        if ($campaign->address_line2) {
            $toField .= ' '.$campaign->address_line2;
        }
        $toField .= ' '.$campaign->address_city.', '.$campaign->address_state;
        $toField .= ' '.$campaign->address_zip_code;
        $formField = 'Greek House';
        if ($campaign->decorator) {

            if ($campaign->decorator->address) {
                $formField .= ' '.$campaign->decorator->address->line1;
                if (! empty($campaign->decorator->address->line2)) {
                    $formField .= ' '.$campaign->decorator->address->line2;
                }
                $formField .= ' '.$campaign->decorator->address->city.' '.$campaign->decorator->address->state;
                $formField .= ' '.$campaign->decorator->address->zip_code;
            }
        }
        $fields['shipto'] = $toField;
        $fields['shipfrom'] = $formField;
        $fields['poname'] = $campaign->name;
        $fields['customername'] = $campaign->getContactFullName();

        $fields['ponumber'] = $campaign->id;
        $fields['shipvia'] = shipping_options()[$campaign->shipping_option];

        $orderGroups = [];
        if (count($campaign->success_orders) > 0) {
            foreach ($campaign->success_orders as $order) {
                foreach ($order->entries as $entry) {
                    if (! isset($orderGroups[$entry->product_color->product->style_number.$entry->product_color->name.'#'.$entry->size->short])) {
                        $orderGroups[$entry->product_color->product->style_number.$entry->product_color->name.'#'.$entry->size->short] = [
                            'style_number' => $entry->product_color->product->style_number,
                            'name'         => $entry->product_color->name.' '.$entry->product_color->product->name,
                            'size'         => $entry->size->short,
                            'quantity'     => 0,
                        ];
                    }
                    $orderGroups[$entry->product_color->product->style_number.$entry->product_color->name.'#'.$entry->size->short]['quantity'] += $entry->quantity;
                }
            }
        }
        if (count($campaign->supplies) > 0) {
            foreach ($campaign->supplies as $order) {
                foreach ($order->entries as $entry) {
                    if (isset($orderGroups[$order->product_color->product->style_number.$order->product_color->name.'#'.$entry->size->short])) {
                        $orderGroups[$order->product_color->product->style_number.$order->product_color->name.'#'.$entry->size->short]['quantity'] = 0;
                    }
                }
            }
            foreach ($campaign->supplies as $order) {
                foreach ($order->entries as $entry) {
                    if (! isset($orderGroups[$order->product_color->product->style_number.$order->product_color->name.'#'.$entry->size->short])) {
                        $orderGroups[$order->product_color->product->style_number.$order->product_color->name.'#'.$entry->size->short] = [
                            'style_number' => $order->product_color->product->style_number,
                            'name'         => $order->product_color->name.' '.$order->product_color->product->name,
                            'size'         => $entry->size->short,
                            'quantity'     => 0,
                        ];
                    } else {

                    }
                    $orderGroups[$order->product_color->product->style_number.$order->product_color->name.'#'.$entry->size->short]['quantity'] += $entry->quantity;
                }
            }
        }
        if (count($orderGroups)) {
            foreach ($orderGroups as $key => $order) {
                if ($order['quantity'] == 0) {
                    unset($orderGroups[$key]);
                }
            }
        }
        $maxStrLength = 0;
        if (count($orderGroups)) {
            $index = 1;
            foreach ($orderGroups as $order) {
                $fields['item'.$index] = $order['style_number'];
                $str = 'UltraClub Mens Cool';
                $fields['color'.$index] = $order['name'];
                if (strlen($order['name']) > $maxStrLength) {
                    $maxStrLength = strlen($order['name']);
                }
                $fields['size'.$index] = $order['size'];
                $fields['quantity'.$index] = $order['quantity'];
                $fields['ship_col1 '.$index] = '_______';
                $fields['ship_col2 '.$index] = '_______';

                $index++;
            }
        }
        $inputPdf = 'PackingSlip_1.pdf';
        if ($maxStrLength > 55 && $maxStrLength <= 83) {
            $inputPdf = 'PackingSlip_2.pdf';
        } else {
            if ($maxStrLength > 83) {
                $inputPdf = 'PackingSlip_3.pdf';
            }
        }
        $packingSlip = new Pdf(public_path($inputPdf));
        $packingSlip->fillForm($fields);
        $packingSlip->flatten();
        $packingSlip->needAppearances();
        $pdfName = '/packing_file_'.$campaign->id.'.pdf';
        if (! $packingSlip->saveAs(public_path('temp_pdf').$pdfName)) {
            throw new \Exception('Could not create PDF: '.$packingSlip->getError());
        }

        return $pdfName;
    }
}
