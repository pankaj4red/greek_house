<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Exceptions\AddressValidationException;
use App\Http\Controllers\BlockController;
use App\Logging\Logger;
use Illuminate\Http\Request;
use Lob\Exception\ValidationException;

class ShippingInformationController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.shipping_information');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.shipping_information');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        form($request)->validate([
            'address_line1'    => 'required',
            'address_line2'    => '',
            'address_city'     => 'required',
            'address_state'    => 'required',
            'address_zip_code' => 'required|digits:5',
        ]);

        try {
            $lob = lob_repository();
            $lob->verifyAddress([
                'line1'    => $request->get('address_line1'),
                'line2'    => $request->get('address_line2'),
                'city'     => $request->get('address_city'),
                'state'    => $request->get('address_state'),
                'zip_code' => $request->get('address_zip_code'),
                'country'  => $request->get('address_country') ?? 'usa',
            ]);
        } catch (AddressValidationException $ex) {
            return form()->error($ex->getMessage())->back();
        } catch (ValidationException $ex) {
            Logger::logNotice('#Lob '.$ex->getMessage().' #ShippingInformation');
        }

        $this->getCampaign()->update([
            'address_line1'    => $request->get('address_line1'),
            'address_line2'    => $request->get('address_line2'),
            'address_city'     => $request->get('address_city'),
            'address_state'    => $request->get('address_state'),
            'address_zip_code' => $request->get('address_zip_code'),
            'address_country'  => $request->get('address_country'),
        ]);

        return form()->success('Shipping Information Saved')->back();
    }
}
