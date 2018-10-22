<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Helpers\ImageManipulator;
use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Storage;

class ProductColorController extends AdminBaseController
{
    public function getCreate($productId)
    {
        $this->force(['admin', 'product_qa', 'product_manager', 'support']);
        $product = product_repository()->find($productId);

        return view('admin_old.product_color.create', [
            'model'     => [],
            'image'     => (new ImageUploadHandler('product_color.create', 'image', false))->getImage(),
            'thumbnail' => (new ImageUploadHandler('product_color.create', 'thumbnail', false))->getImage(),
            'product'   => $product,
        ]);
    }

    public function postCreate($productId, Request $request)
    {
        $this->force(['admin', 'product_qa', 'product_manager', 'support']);
        $imageHandler = new ImageUploadHandler('product_color.create', 'image', false, 500, 500);
        $thumbnailHandler = new ImageUploadHandler('product_color.create', 'thumbnail', false, 30, 30);
        $resultImage = $imageHandler->post();
        if ($resultImage instanceof RedirectResponse) {
            return $resultImage;
        }
        if ($resultImage['image'] == null) {
            return form()->error('Image is required')->back();
        }
        $resultThumbnail = $thumbnailHandler->post();
        if ($resultThumbnail instanceof RedirectResponse) {
            return $resultThumbnail;
        }
        if ($resultThumbnail['image'] == null) {
            return form()->error('Thumbnail is required')->back();
        }
        $validator = product_color_repository()->validate($request, ['name']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $productColor = product_color_repository()->make();
        $productColor->name = $request->get('name');
        $productColor->product_id = $productId;
        $productColor->image_id = $resultImage['image'];
        $productColor->thumbnail_id = $resultThumbnail['image'];
        $productColor->save();
        $imageHandler->clear();
        $thumbnailHandler->clear();
        success('Product Color Information Saved');

        return form()->route('admin::product::read', [$productId]);
    }

    public function getUpdate($id)
    {
        $this->force(['admin', 'product_qa', 'product_manager', 'support']);
        $productColor = product_color_repository()->find($id);

        $imageUpload = new ImageUploadHandler('product_color.update-'.$id, 'image', false);
        $imageUpload->setImageId($productColor->image_id);
        $thumbnailUpload = new ImageUploadHandler('product_color.update-'.$id, 'thumbnail', false);
        $thumbnailUpload->setImageId($productColor->thumbnail_id);

        return view('admin_old.product_color.update', [
            'model'     => $productColor,
            'image'     => $imageUpload->getImage(),
            'thumbnail' => $thumbnailUpload->getImage(),
            'productId' => $productColor->product_id,
            'active'    => $productColor->active ? 'yes' : 'no',
        ]);
    }

    public function postUpdate($id, Request $request)
    {
        $this->force(['admin', 'product_qa', 'product_manager', 'support']);
        $productColor = product_color_repository()->find($id);
        $imageHandler = new ImageUploadHandler('product_color.update-'.$id, 'image', false, 500, 500);
        $thumbnailHandler = new ImageUploadHandler('product_color.update-'.$id, 'thumbnail', false, 30, 30);

        $resultImage = $imageHandler->post();
        if ($resultImage instanceof RedirectResponse) {
            return $resultImage;
        }
        if ($resultImage['image'] == null) {
            return form()->error('Image is required')->back();
        }
        $resultThumbnail = $thumbnailHandler->post();

        if ($resultThumbnail instanceof RedirectResponse) {
            return $resultThumbnail;
        }
        if ($resultThumbnail['image'] == null) {
            return form()->error('Thumbnail is required')->back();
        }
        if (\Auth::user()->type_code == 'product_qa') {
            $productColor->image_id = $resultImage['image'];
            $productColor->thumbnail_id = $resultThumbnail['image'];
            $productColor->save();
            $imageHandler->clear();
            $thumbnailHandler->clear();
            success('Garment Color Image Information Saved');

            return form()->route('admin::product::read', [$productColor->product_id]);
        }
        $validator = product_color_repository()->validate($request);
        if ($validator->fails()) {
            $productColor->save();

            return form()->error($validator->errors())->back();
        }
        $productColor->name = $request->get('name');
        $productColor->active = $request->get('active') == 'yes' ? true : false;
        $productColor->image_id = $resultImage['image'];
        $productColor->thumbnail_id = $resultThumbnail['image'];
        $productColor->save();
        $imageHandler->clear();
        $thumbnailHandler->clear();
        success('ProductColor Information Saved');

        return form()->route('admin::product::read', [$productColor->product_id]);
    }

    public function getDelete($id)
    {
        $this->force(['admin', 'product_manager']);
        $productColor = product_color_repository()->find($id);
        if (! $productColor) {
            return form()->error('Unknown Product Color')->route('admin::product::list');
        }

        return view('admin_old.product_color.delete', [
            'productColor' => $productColor,
        ]);
    }

    public function postDelete($id)
    {
        $productColor = product_color_repository()->find($id);
        if (! $productColor) {
            return form()->error('Unknown Product Color')->route('admin::product::list');
        }
        $productColor->delete();
        success('Product Color Deleted');

        return form()->route('admin::product::read', [$productColor->product_id]);
    }

    public function createThumbnail(Request $request)
    {

        $filename = $request->input('filename');
        $filenameArray = explode('.', $filename);
        $newFileName = $filenameArray[0].'_thumb.'.$filenameArray[1];
        $storageDir = public_path('images');
        $filePath = $storageDir.'/'.$filename;
        $newFilePath = $storageDir.'/'.$newFileName;
        $fileUrl = $request->input('file_url');
        file_put_contents($filePath, fopen($fileUrl, 'r'));
        $im = new ImageManipulator($filePath);

        $centreX = round($im->getWidth() / 2);
        $centreY = round($im->getHeight() / 2);
        $x1 = $centreX - 25;
        $y1 = $centreY - 25;
        $x2 = $centreX + 25;
        $y2 = $centreY + 25;
        $im->crop($x1, $y1, $x2, $y2); // takes care of out of boundary conditions automatically
        $im->save($newFilePath);
        $image = file_repository()->make();
        $image->name = $newFileName;
        $content = Storage::disk('images')->get($newFileName);
        $image->internal_filename = save_file($content);
        $image->type = 'image';
        $image->sub_type = 'png';
        $image->mime_type = 'image/png';
        $image->save();
        $imageId = $image->id;
        cache_image($imageId, $content);
        \Session::put($request->input('prefix').'.thumbnail-image', $imageId);
        unlink($filePath);
        unlink($newFilePath);
        $newFileUrl = route('system::image', [$imageId]);
        $data = ['image_id' => $imageId, 'url' => $newFileUrl, 'filename' => $image->internal_filename];
        echo \GuzzleHttp\json_encode($data);
    }
}
