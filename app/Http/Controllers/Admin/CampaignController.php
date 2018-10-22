<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\AdminBaseController;
use App\Models\Campaign;
use App\Models\CampaignQuote;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CampaignController extends AdminBaseController
{
    /**
     * CampaignController constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_support');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getList(Request $request)
    {
        return view('admin.campaign.list', [
            'list' => campaign_repository()->getListing($request->all(), null, null, 20),
        ]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getRead(Campaign $campaign)
    {
        return view('admin.campaign.read', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateContact(Campaign $campaign)
    {
        return view('admin.campaign.update_contact', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return $this|\Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function postUpdateContact(Campaign $campaign, Request $request)
    {
        $this->validate($request, [
            'contact_first_name' => 'required|max:255',
            'contact_last_name'  => 'required|max:255',
            'contact_email'      => 'required|email|max:255',
            'contact_phone'      => 'required|phone|max:255',
            'contact_school'     => 'required|max:255',
            'contact_chapter'    => 'required|max:255',
        ]);

        $campaign->update([
            'contact_first_name' => $request->get('contact_first_name'),
            'contact_last_name'  => $request->get('contact_last_name'),
            'contact_email'      => $request->get('contact_email'),
            'contact_phone'      => $request->get('contact_phone'),
            'contact_school'     => $request->get('contact_school'),
            'contact_chapter'    => $request->get('contact_chapter'),
            'school_id'          => school_chapter_match($request->get('contact_school'), $request->get('contact_chapter'), 'school'),
            'chapter_id'         => school_chapter_match($request->get('contact_school'), $request->get('contact_chapter'), 'chapter'),
        ]);

        success('Contact Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateShipping(Campaign $campaign)
    {
        return view('admin.campaign.update_shipping', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function postUpdateShipping(Campaign $campaign, Request $request)
    {
        $this->validate($request, [
            'address_name'     => 'required|max:255',
            'address_line1'    => 'required|max:255',
            'address_line2'    => 'max:255',
            'address_city'     => 'required|max:255',
            'address_state'    => 'required|max:255',
            'address_zip_code' => 'required|digits:5',
        ]);

        $campaign->update([
            'address_name'     => $request->get('address_name'),
            'address_line1'    => $request->get('address_line1'),
            'address_line2'    => $request->get('address_line2'),
            'address_city'     => $request->get('address_city'),
            'address_state'    => $request->get('address_state'),
            'address_zip_code' => $request->get('address_zip_code'),
            'address_country'  => $request->get('address_country') ?? 'usa',
        ]);

        success('Shipping Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateShippingTypes(Campaign $campaign)
    {
        return view('admin.campaign.update_shipping_types', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function postUpdateShippingTypes(Campaign $campaign, Request $request)
    {
        $this->validate($request, [
            'shipping_group'      => 'required|max:255|in:enabled,disabled',
            'shipping_individual' => 'required|max:255|in:enabled,disabled',
        ]);

        $campaign->update([
            'shipping_group'      => $request->get('shipping_group') == 'enabled' ? true : false,
            'shipping_individual' => $request->get('shipping_individual') == 'enabled' ? true : false,
        ]);

        success('Shipping Types Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateActors(Campaign $campaign)
    {
        return view('admin.campaign.update_actors', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function postUpdateActors(Campaign $campaign, Request $request)
    {
        $campaign->update([
            'user_id'      => $request->get('user_id'),
            'decorator_id' => $request->get('decorator_id'),
        ]);

        $campaign->artwork_request->update([
            'designer_id' => $request->get('designer_id'),
        ]);

        success('Order Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateProducts(Campaign $campaign)
    {
        return view('admin.campaign.update_products', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return RedirectResponse
     */
    public function postUpdateProducts(Campaign $campaign, Request $request)
    {
        $campaign->product_colors()->sync($request->get('color_id'));

        success('Product Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateGeneral(Campaign $campaign)
    {
        return view('admin.campaign.update_general', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function postUpdateGeneral(Campaign $campaign, Request $request)
    {
        $this->validate($request, [
            'name'               => 'required|max:255',
            'state'              => 'required|max:255',
            'date'               => 'date|nullable',
            'close_date'         => 'date|nullable',
            'flexible'           => 'required|in:yes,no',
            'scheduled_date'     => 'date|nullable',
            'promo_code'         => 'max:255',
            'estimated_quantity' => 'required',
            'reminders'          => 'required|in:on,off',
        ]);

        $campaign->update([
            'name'               => $request->get('name'),
            'state'              => $request->get('state'),
            'date'               => $request->get('date') ? Carbon::parse($request->get('date')) : null,
            'close_date'         => $request->get('close_date') ? Carbon::parse($request->get('close_date')) : null,
            'flexible'           => $request->get('flexible'),
            'scheduled_date'     => $request->get('scheduled_date') ? Carbon::parse($request->get('scheduled_date')) : null,
            'promo_code'         => $request->get('promo_code'),
            'estimated_quantity' => estimated_quantity_by_code($campaign->artwork_request->design_type, $request->get('estimated_quantity'))->code,
            'reminders'          => $request->get('reminders'),
            'budget'             => $request->get('budget'),
            'budget_range'       => $request->get('budget_range'),
            'fulfillment_notes'  => $request->get('fulfillment_notes'),
        ]);

        success('Order Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateQuote(Campaign $campaign)
    {
        return view('admin.campaign.update_quotes', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse
     * @throws \Exception
     */
    public function postUpdateQuote(Campaign $campaign, Request $request)
    {
        $this->validate($request, [
            'product.*' => 'integer',
            'low.*'     => 'numeric|nullable',
            'high.*'    => 'numeric|nullable',
            'final.*'   => 'numeric|nullable',
        ]);

        // Update Existing
        $existing = $campaign->quotes->filter(function ($value) use ($request) {
            return in_array($value->product_id, $request->get('product'));
        });
        /** @var CampaignQuote $quote */
        foreach ($existing as $quote) {
            $index = array_search($quote->product_id, $request->get('product'));
            $quote->update([
                'quote_low'   => $request->get('low')[$index] ? str_replace('$', '', $request->get('low')[$index]) : 0,
                'quote_high'  => $request->get('high')[$index] ? str_replace('$', '', $request->get('high')[$index]) : 0,
                'quote_final' => $request->get('final')[$index] ? str_replace('$', '', $request->get('final')[$index]) : null,
            ]);
        }

        // Create New
        foreach ($request->get('product') as $index => $productId) {
            if ($campaign->quotes->where('product_id', $productId)->count() == 0) {
                $campaign->quotes()->insert([
                    'campaign_id' => $campaign->id,
                    'product_id'  => $productId,
                    'quote_low'   => $request->get('low')[$index] ? str_replace('$', '', $request->get('low')[$index]) : 0,
                    'quote_high'  => $request->get('high')[$index] ? str_replace('$', '', $request->get('high')[$index]) : 0,
                    'quote_final' => $request->get('final')[$index] ? str_replace('$', '', $request->get('final')[$index]) : null,
                ]);
            }
        }

        // Remove Non Existing
        $existing = $campaign->quotes->filter(function ($value) use ($request) {
            return ! in_array($value->product_id, $request->get('product'));
        });
        /** @var CampaignQuote $quote */
        foreach ($existing as $quote) {
            $quote->delete();
        }

        if (count($request->get('product')) > 0) {
            $campaign->update([
                'quote_low'   => $request->get('low')[0] ?? 0,
                'quote_high'  => $request->get('high')[0] ?? 0,
                'quote_final' => $request->get('final')[0],
            ]);
        }

        success('Quote Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getProofs(Campaign $campaign)
    {
        $proofsGeneric = [];
        for ($i = 0; $i < 10; $i++) {
            $proofsGeneric[$i] = new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$i);
            $proofsGeneric[$i]->setImageId($campaign->getProof('generic', $i) ? $campaign->getProof('generic', $i)->file_id : null);
        }
        $proofs['generic'] = [
            'proof0' => $proofsGeneric[0]->getImage(),
            'proof1' => $proofsGeneric[1]->getImage(),
            'proof2' => $proofsGeneric[2]->getImage(),
            'proof3' => $proofsGeneric[3]->getImage(),
            'proof4' => $proofsGeneric[4]->getImage(),
            'proof5' => $proofsGeneric[5]->getImage(),
            'proof6' => $proofsGeneric[6]->getImage(),
            'proof7' => $proofsGeneric[7]->getImage(),
            'proof8' => $proofsGeneric[8]->getImage(),
            'proof9' => $proofsGeneric[9]->getImage(),
        ];

        $proofsProduct = [];
        foreach ($campaign->product_colors as $productColor) {
            $proofsProduct[$productColor->id] = (object) [
                'front'    => new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$productColor->id.'_front'),
                'back'     => new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$productColor->id.'_back'),
                'close_up' => new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$productColor->id.'_close_up'),
                'other'    => new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$productColor->id.'_other'),
            ];

            $proofsProduct[$productColor->id]->front->setImageId($campaign->getProductColorProof($productColor->id, 'front') ? $campaign->getProductColorProof($productColor->id, 'front')->file_id : null);
            $proofsProduct[$productColor->id]->front = $proofsProduct[$productColor->id]->front->getImage();

            $proofsProduct[$productColor->id]->back->setImageId($campaign->getProductColorProof($productColor->id, 'back') ? $campaign->getProductColorProof($productColor->id, 'back')->file_id : null);
            $proofsProduct[$productColor->id]->back = $proofsProduct[$productColor->id]->back->getImage();

            $proofsProduct[$productColor->id]->close_up->setImageId($campaign->getProductColorProof($productColor->id, 'close_up') ? $campaign->getProductColorProof($productColor->id, 'close_up')->file_id : null);
            $proofsProduct[$productColor->id]->close_up = $proofsProduct[$productColor->id]->close_up->getImage();

            $proofsProduct[$productColor->id]->other->setImageId($campaign->getProductColorProof($productColor->id, 'other') ? $campaign->getProductColorProof($productColor->id, 'other')->file_id : null);
            $proofsProduct[$productColor->id]->other = $proofsProduct[$productColor->id]->other->getImage();
        }

        $proofs['products'] = $proofsProduct;

        return view('admin.campaign.update_proofs', [
            'campaign' => $campaign,
            'proofs'   => (object) $proofs,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse|mixed
     * @throws \Exception
     */
    public function postProofs(Campaign $campaign, Request $request)
    {
        $proofs = [];
        for ($i = 0; $i < 10; $i++) {
            $imageHandler = new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$i, false, 600, 600);
            $result = $imageHandler->post();
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $proofs[] = (object) [
                'type'             => 'proof_generic',
                'file_id'          => $result['image'],
                'product_color_id' => null,
                'sort'             => $i,
            ];
        }

        foreach ($campaign->product_colors as $productColor) {
            foreach (['front', 'back', 'close_up', 'other'] as $position) {
                $imageHandler = new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$productColor->id.'_'.$position, false, 600, 600);
                $result = $imageHandler->post();
                if ($result instanceof RedirectResponse) {
                    return $result;
                }
                $proofs[] = (object) [
                    'type'             => 'proof_'.$position,
                    'file_id'          => $result['image'],
                    'product_color_id' => $productColor->id,
                    'sort'             => 0,
                ];
            }
        }

        foreach ($proofs as $proof) {
            $currentProof = artwork_request_file_repository()->findByArtworkRequestAndType($campaign->artwork_request_id, $proof->type, $proof->product_color_id, $proof->sort);
            if ($currentProof && ! $proof->file_id) {
                $currentProof->delete();
                continue;
            }
            if ($currentProof && $proof->file_id && $currentProof->file_id != $proof->file_id) {
                $currentProof->update([
                    'file_id' => $proof->file_id,
                ]);
                continue;
            }
            if (! $currentProof && $proof->file_id) {
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'file_id'            => $proof->file_id,
                    'product_color_id'   => $proof->product_color_id,
                    'sort'               => $proof->sort,
                    'type'               => $proof->type,
                ]);
                continue;
            }
        }

        $proofs = [];
        for ($i = 0; $i < 10; $i++) {
            $imageHandler = new ImageUploadHandler('campaign.update-'.$campaign->id, 'proof'.$i, false, 600, 600);
            $result = $imageHandler->post();
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $proofs[$i] = $result;
        }

        for ($i = 0; $i < 10; $i++) {
            $campaignFile = $campaign->getProof('generic', $i);
            if ($campaignFile != null && $campaignFile->file_id != $proofs[$i]['image'] && $proofs[$i]['image'] != null) {
                $campaignFile->file_id = $proofs[$i]['image'];
                $campaignFile->save();
            } elseif ($campaignFile != null && $campaignFile->file_id != $proofs[$i]['image'] && $proofs[$i]['image'] == null) {
                $campaignFile->delete();
            } elseif ($campaignFile == null && $proofs[$i]['image'] != null) {
                artwork_request_file_repository()->create([
                    'artwork_request_id' => $campaign->artwork_request_id,
                    'file_id'            => $proofs[$i]['image'],
                    'sort'               => $i,
                    'type'               => 'proof',
                ]);
            }
        }
        success('Proofs Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    /**
     * @param Campaign $campaign
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getUpdateArtworkRequest(Campaign $campaign)
    {
        return view('admin.campaign.update_artwork_request', [
            'campaign' => $campaign,
        ]);
    }

    /**
     * @param Campaign $campaign
     * @param Request  $request
     * @return \App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|RedirectResponse|mixed
     */
    public function postUpdateArtworkRequest(Campaign $campaign, Request $request)
    {
        $this->validate($request, [
            'design_hours',
            'design_type',
        ]);

        $campaign->artwork_request->update([
            'design_minutes'           => to_minutes($request->get('design_hours')),
            'hourly_rate'              => $request->get('hourly_rate'),
            'design_type'              => $request->get('design_type'),
            'print_front'              => $request->get('print_front') == 'yes',
            'print_pocket'             => $request->get('print_pocket') == 'yes',
            'print_back'               => $request->get('print_back') == 'yes',
            'print_sleeve'             => $request->get('print_sleeve') == 'yes',
            'print_front_description'  => $request->get('print_front_description'),
            'print_pocket_description' => $request->get('print_pocket_description'),
            'print_back_description'   => $request->get('print_back_description'),
            'print_sleeve_description' => $request->get('print_sleeve_description'),
            'print_sleeve_preferred'   => $request->get('print_sleeve_preferred'),
            'print_front_colors'       => $request->get('print_front_colors'),
            'print_pocket_colors'      => $request->get('print_pocket_colors'),
            'print_back_colors'        => $request->get('print_back_colors'),
            'print_sleeve_colors'      => $request->get('print_sleeve_colors'),
            'revision_text'            => $request->get('revision_text'),
        ]);

        success('Order Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }

    public function getCreate()
    {
        return view('admin_old.campaign.create');
    }

    public function postCreate(Request $request)
    {
        $validator = campaign_repository()->validate($request->all(), [
            'name',
            'state',
            'flexible',
            'date',
            'design_type',
            'estimated_quantity',
        ]);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $artworkRequest = artwork_request_repository()->create([
            'design_type' => $request->get('design_type'),
        ]);

        $campaign = campaign_repository()->create([
            'name'               => $request->get('name'),
            'state'              => $request->get('state'),
            'flexible'           => $request->get('flexible'),
            'date'               => Carbon::parse($request->get('date'))->format('Y-m-d'),
            'design_type'        => $request->get('design_type'),
            'estimated_quantity' => $request->get('estimated_quantity'),
            'artwork_request_id' => $artworkRequest->id,
            'user_id'            => \Auth::user()->id,
        ]);

        $product = product_repository()->first();
        $campaign->product_colors()->attach($product->colors->first()->id);
        design_repository()->createFromCampaign($campaign);

        success('Order Information Saved');

        return form()->route('admin::campaign::read', [$campaign->id]);
    }
}