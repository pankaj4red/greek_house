<?php

namespace App\Http\Controllers\Customer\Blocks;

use App\Http\Controllers\BlockController;
use Illuminate\Http\Request;

class GarmentInformationController extends BlockController
{
    public function block()
    {
        return $this->view('blocks.block.garment_information');
    }

    public function getPopup($id)
    {
        $this->forceCanBeAccessed('edit');

        return $this->view('blocks.popup.garment_information');
    }

    public function postPopup($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        $product = product($request->get('color-id'));

        //TODO: rework
        $this->getCampaign()->product_colors()->sync([
            $request->get('product-color-id'),
        ]);

        return form()->success('Garment Information Updated')->back();
    }

    public function postStep1($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        return response()->json([
            'success'    => true,
            'categories' => garment_category_list($request->get('gender-id')),
        ]);
    }

    public function postStep2($id, Request $request)
    {
        $this->forceCanBeAccessed('edit');

        return response()->json([
            'success'  => true,
            'products' => product_list($request->get('gender-id'), $request->get('category-id')),
        ]);
    }

    public function postStep3($id, Request $request)
    {
        return response()->json([
            'success' => true,
            'colors'  => product($request->get('product-id'))->colors,
        ]);
    }
}
