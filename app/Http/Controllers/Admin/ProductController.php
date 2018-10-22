<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\AdminBaseController;
use App\Models\ProductSize;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProductController extends AdminBaseController
{
    public function getList(Request $request)
    {
        $this->force(['admin', 'product_manager', 'support']);

        return view('admin_old.product.list', [
            'list' => product_repository()->getListing($request->all(), null, null, 20),
        ]);
    }

    public function getRead($id)
    {
        $this->force(['admin', 'product_manager', 'support']);

        return view('admin_old.product.read', [
            'model' => product_repository()->find($id),
        ]);
    }

    public function getCreate()
    {
        $this->force(['admin', 'product_manager', 'support']);

        return view('admin_old.product.create', [
            'model' => [
                'active' => 'yes',
            ],
            'image' => (new ImageUploadHandler('product.create', 'image', false))->getImage(),
        ]);
    }

    public function postCreate(Request $request)
    {
        $this->force(['admin', 'product_manager', 'support']);
        $imageHandler = new ImageUploadHandler('product.create', 'image', false, 250, 250);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        if ($result['image'] == null) {
            return form()->error('Image is required')->back();
        }
        $validator = product_repository()->validate($request, [
            'name',
            'style_number',
            'garment_brand_id',
            'garment_category_id',
            'garment_gender_id',
            'price',
            'description',
            'sizes_text',
            'features',
            'active',
        ]);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }

        $product = product_repository()->make();
        $product->name = $request->get('name');
        $product->sku = $request->get('style_number');
        $product->style_number = $request->get('style_number');
        $product->garment_brand_id = $request->get('garment_brand_id');
        $product->garment_category_id = $request->get('garment_category_id');
        $product->garment_gender_id = $request->get('garment_gender_id');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->sizes_text = $request->get('sizes_text');
        $product->features = $request->get('features');
        $product->active = $request->get('active') == 'yes' ? true : false;
        if ($result['image']) {
            $product->image_id = $result['image'];
        }
        $product->suggested_supplier = $request->get('suggested_supplier');
        $product->designer_instructions = $request->get('designer_instructions');
        $product->fulfillment_instructions = $request->get('fulfillment_instructions');
        $product->save();

        $sizes = garment_size_repository()->all();
        foreach ($sizes as $size) {
            if ($request->has('size_'.$size->short)) {
                $productSize = product_size_repository()->make();
                $productSize->product_id = $product->id;
                $productSize->garment_size_id = $size->id;
                $productSize->save();
            }
        }
        $imageHandler->clear();
        success('Product Information Saved');

        return form()->route('admin::product::read', [$product->id]);
    }

    public function getUpdate($id)
    {
        $this->force(['admin', 'product_manager', 'support']);
        $product = product_repository()->find($id);
        if ($product == null) {
            return form()->error('Unknown Product')->route('admin::product::list');
        }
        $imageUpload = new ImageUploadHandler('product.update-'.$id, 'image', false);
        $imageUpload->setImageId($product->image_id);

        $sizeSelected = [];
        foreach ($product->sizes as $productSize) {
            $sizeSelected['size_'.$productSize->size->short] = 'yes';
        }

        return view('admin_old.product.update', [
            'model' => array_merge($product->toArray(), $sizeSelected, ['active' => $product->active ? 'yes' : 'no']),
            'image' => $imageUpload->getImage(),
        ]);
    }

    public function postUpdate($id, Request $request)
    {
        $this->force(['admin', 'product_manager', 'support']);
        $product = product_repository()->find($id);
        if ($product == null) {
            return form()->error('Unknown Product')->route('admin::product::list');
        }
        $imageHandler = new ImageUploadHandler('product.update-'.$id, 'image', false, 250, 250);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        if ($result['image'] == null) {
            return form()->error('Image is required')->back();
        }
        $validator = product_repository()->validate($request, [
            'name',
            'style_number',
            'garment_brand_id',
            'garment_category_id',
            'garment_gender_id',
            'price',
            'description',
            'sizes_text',
            'features',
            'active',
        ]);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        if (\Auth::user()->type_code == 'product_qa') {
            $product->image_id = $result['image'];
            $product->save();
            $imageHandler->clear();
            success('Product Image Information Saved');

            return form()->route('admin::product::read', [$id]);
        }
        $product->name = $request->get('name');
        $product->sku = $request->get('style_number');
        $product->style_number = $request->get('style_number');
        $product->garment_brand_id = $request->get('garment_brand_id');
        $product->garment_category_id = $request->get('garment_category_id');
        $product->garment_gender_id = $request->get('garment_gender_id');
        $product->price = $request->get('price');
        $product->description = $request->get('description');
        $product->sizes_text = $request->get('sizes_text');
        $product->features = $request->get('features');
        $product->active = $request->get('active') == 'yes' ? true : false;
        $product->image_id = $result['image'];
        $product->suggested_supplier = $request->get('suggested_supplier');
        $product->designer_instructions = $request->get('designer_instructions');
        $product->fulfillment_instructions = $request->get('fulfillment_instructions');

        $sizes = garment_size_repository()->all();
        foreach ($sizes as $size) {
            $productSizeIndex = $product->sizes->search(function ($item) use ($size) {
                /** @var ProductSize $item */
                return $item->size->short == $size->short;
            });
            if ($request->has('size_'.$size->short)) {
                if ($productSizeIndex === false) {
                    product_size_repository()->create([
                        'product_id'      => $id,
                        'garment_size_id' => $size->id,
                    ]);
                }
            } else {
                if ($productSizeIndex !== false) {
                    $product->sizes[$productSizeIndex]->delete();
                }
            }
        }
        $product->save();

        success('Product Information Saved');

        return form()->route('admin::product::read', [$id]);
    }

    public function getDelete($id)
    {
        $this->force(['admin', 'product_manager']);

        return view('admin_old.product.delete');
    }

    public function postDelete($id)
    {

    }
}
