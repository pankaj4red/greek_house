<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;

class GarmentBrandController extends AdminBaseController
{
    public function getList()
    {
        $this->force(['admin', 'product_qa', 'product_manager']);

        return view('admin_old.garment_brand.list', [
            'list' => garment_brand_repository()->getListing(null, ['name', 'asc']),
        ]);
    }

    public function getRead($id)
    {
        $this->force(['admin', 'product_qa', 'product_manager']);

        return view('admin_old.garment_brand.read', [
            'model' => garment_brand_repository()->find($id),
        ]);
    }

    public function getCreate()
    {
        $this->force(['admin', 'product_manager']);

        return view('admin_old.garment_brand.create', [
            'model' => [],
        ]);
    }

    public function postCreate(Request $request)
    {
        $this->force(['admin', 'product_manager']);
        $validator = garment_brand_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $garmentBrand = garment_brand_repository()->create([
            'name' => $request->get('name'),
        ]);
        success('Garment Brand Saved');

        return form()->route('admin::garment_brand::read', [$garmentBrand->id]);
    }

    public function getUpdate($id)
    {
        $this->force(['admin', 'product_manager']);
        $GarmentBrand = garment_brand_repository()->find($id);

        return view('admin_old.garment_brand.update', [
            'model' => $GarmentBrand,
        ]);
    }

    public function postUpdate($id, Request $request)
    {
        $this->force(['admin', 'product_manager']);
        $garmentBrand = garment_brand_repository()->find($id);
        if ($garmentBrand == null) {
            return form()->error('Unknown Garment Brand')->route('admin::garment_brand::list');
        }
        $validator = garment_brand_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $garmentBrand->name = $request->get('name');
        $garmentBrand->save();

        success('Garment Brand Saved');

        return form()->route('admin::garment_brand::read', [$garmentBrand->id]);
    }

    public function getDelete($id)
    {
        $this->force(['admin', 'product_manager']);

        return view('admin_old.garment_brand.delete');
    }

    public function postDelete($id)
    {
        $this->force(['admin', 'product_manager']);
    }
}
