<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GarmentCategoryController extends AdminBaseController
{
    public function getList()
    {
        $this->force(['admin', 'product_qa', 'product_manager']);

        return view('admin_old.garment_category.list', [
            'list' => garment_category_repository()->getListing(),
        ]);
    }

    public function getRead($id)
    {
        $this->force(['admin', 'product_qa', 'product_manager']);

        return view('admin_old.garment_category.read', [
            'garmentCategory' => garment_category_repository()->find($id),
        ]);
    }

    public function getCreate()
    {
        $this->force(['admin', 'product_manager']);

        return view('admin_old.garment_category.create', [
            'image' => (new ImageUploadHandler('garment_category.create', 'image', true))->getImage(),
        ]);
    }

    public function postCreate(Request $request)
    {
        $this->force(['admin', 'product_manager']);
        $imageHandler = new ImageUploadHandler('garment_category.create', 'image', false, 250, 250);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        if ($result['image'] == null) {
            return form()->error('Image is required')->back();
        }
        $validator = garment_category_repository()->validate($request, ['name']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $garmentCategory = garment_category_repository()->create([
            'name'     => $request->get('name'),
            'image_id' => $result['image'],
        ]);
        $imageHandler->clear();
        success('Garment Category Information Saved');

        return form()->route('admin::garment_category::read', [$garmentCategory->id]);
    }

    public function getUpdate($id)
    {
        $this->force(['admin', 'product_qa', 'product_manager']);
        $garmentCategory = garment_category_repository()->find($id);
        $imageUpload = new ImageUploadHandler('garment_category.update-'.$id, 'image', true);
        $imageUpload->setImageId($garmentCategory->image_id);

        return view('admin_old.garment_category.update', [
            'garmentCategory' => $garmentCategory,
            'image'           => $imageUpload->getImage(),
        ]);
    }

    public function postUpdate($id, Request $request)
    {
        $this->force(['admin', 'product_qa', 'product_manager']);
        $garmentCategory = garment_category_repository()->find($id);
        $imageHandler = new ImageUploadHandler('garment_category.update-'.$id, 'image', true, 250, 250);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        if ($result['image'] == null) {
            return form()->error('Image is required')->back();
        }

        if (\Auth::user()->type_code == 'product_qa') {
            $garmentCategory->image_id = $result['image'];
            $garmentCategory->save();
            $imageHandler->clear();
            success('Garment Category Image Information Saved');

            return form()->route('admin::garment_category::read', [$id]);
        }

        $validator = garment_category_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $garmentCategory->name = $request->get('name');
        $garmentCategory->active = (bool) $request->get('active');
        $garmentCategory->image_id = $result['image'];
        $garmentCategory->sort = $request->get('sort');
        $garmentCategory->wizard = $request->get('wizard');
        $garmentCategory->allow_additional = $request->get('allow_additional') ? true : false;
        $garmentCategory->save();

        $all = garment_category_repository()->getListing();
        $index = 0;
        foreach ($all as $garmentCategory) {
            if ($request->get('wizard') == 'default' && $garmentCategory->wizard == 'default' && $garmentCategory->id != $id) {
                $garmentCategory->update([
                    'wizard' => 'show',
                ]);
            }
            if ($garmentCategory->sort != $index) {
                $garmentCategory->update([
                    'sort' => $index,
                ]);
            }
            $index++;
        }

        $imageHandler->clear();
        success('Garment Category Information Saved');

        return form()->route('admin::garment_category::read', [$id]);
    }

    public function getDelete($id)
    {
        $this->force(['admin', 'product_manager']);

        return view('admin_old.garment_category.delete');
    }

    public function postDelete($id)
    {
        $this->force(['admin', 'product_manager']);
    }
}
