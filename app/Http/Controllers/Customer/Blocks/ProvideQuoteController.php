<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class ProvideQuoteController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.provide_quote');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        if ($this->getCampaign()->artwork_request->designer_id == null) {
            return form()->error('Campaign must have an associated designer first.')->back();
        }

        return $this->view('blocks.popup.provide_quote', [
            'defaultMarkup' => $this->getCampaign()->markup ? $this->getCampaign()->markup : estimated_quantity_by_code($this->getCampaign()->getCurrentArtwork()->design_type, $this->getCampaign()->estimated_quantity)->markup,
        ]);
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        form($request)->validate([
            'estimated_quantity' => 'required',
            'design_hours'       => 'required',
            'product_id.*'       => 'required|integer',
            'unit_price_low.*'   => 'required|regex:/[\d]+[\.]*[\d]{0,2}/',
            'unit_price_high.*'  => 'required|regex:/[\d]+[\.]*[\d]{0,2}/',
            'markup'             => 'required|integer|min:0',
        ]);

        $firstProductId = $this->getCampaign()->product_colors->first()->product_id;
        $index = 0;
        foreach ($request->get('product_id') as $productId) {
            if ($productId == $firstProductId) {
                $this->getCampaign()->update([
                    'estimated_quantity' => $request->get('estimated_quantity'),
                    'quote_low'          => round((str_replace('$', '', $request->get('unit_price_low')[0]) / 1.07) * 100) / 100,
                    'quote_high'         => round((str_replace('$', '', $request->get('unit_price_high')[0]) / 1.07) * 100) / 100,
                    'quote_final'        => null,
                    'markup'             => $request->get('markup'),
                ]);
            }

            $found = false;
            foreach ($this->getCampaign()->quotes as $quote) {
                if ($quote->product_id == $productId) {
                    $found = true;
                    $quote->update([
                        'quote_low'  => round((str_replace('$', '', $request->get('unit_price_low')[$index]) / 1.07) * 100) / 100,
                        'quote_high' => round((str_replace('$', '', $request->get('unit_price_high')[$index]) / 1.07) * 100) / 100,
                    ]);
                }
            }

            if ($found == false) {
                $this->getCampaign()->quotes()->insert([
                    'campaign_id' => $this->getCampaign()->id,
                    'product_id'  => $productId,
                    'quote_low'   => round((str_replace('$', '', $request->get('unit_price_low')[$index]) / 1.07) * 100) / 100,
                    'quote_high'  => round((str_replace('$', '', $request->get('unit_price_high')[$index]) / 1.07) * 100) / 100,
                ]);
            }
            $index++;
        }

        foreach ($this->getCampaign()->quotes as $quote) {
            $found = false;
            foreach ($request->get('product_id') as $productId) {
                if ($productId == $quote->product_id) {
                    $found = true;
                }
            }

            if ($found == false) {
                $quote->delete();
            }
        }

        $this->getCampaign()->artwork_request->update([
            'design_minutes' => to_minutes($request->get('design_hours')),
            'hourly_rate'    => $this->getCampaign()->artwork_request->designer->hourly_rate,
        ]);

        return form()->success('A quote has been provided')->back();
    }
}
