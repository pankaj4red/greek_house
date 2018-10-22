<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\AdminBaseController;
use App\Models\SliderImages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SliderImageController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getList()
    {
        return view('admin.slider.list', [
            'list' => slider_image_repository()->getListing(),
        ]);
    }

    public function getCreate()
    {
        $this->force(['admin', 'support']);

        return view('admin.slider.create', [
            'model' => [],
            'image' => (new ImageUploadHandler('sliderImage.create', 'image', false))->getImage(),

        ]);
    }

    public function postCreate(Request $request)
    {
        $this->force(['admin', 'support']);

        $homeUrl = url('/');
        if (! empty($request->get('image_url')) && strpos($request->get('image_url'), $homeUrl) === false) {

            list($width, $height) = getimagesize($request->get('image_url'));
            if ($width < 660 || $height < 440) {
                return form()->error('Image width should be atleast 660px and height should be atleast 440px')->back();
            }
        }

        $imageHandler = new ImageUploadHandler('sliderImage.create', 'image', false, 1024, 960);
        $resultImage = $imageHandler->post();
        if ($resultImage instanceof RedirectResponse) {
            return $resultImage;
        }
        if ($resultImage['image'] == null) {
            return form()->error('Image is required')->back();
        }

        $validator = slider_image_repository()->validate($request, ['url']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $sliderImage = slider_image_repository()->make();
        $sliderImage->url = $request->get('url');
        $sliderImage->priority = $request->get('priority');
        $sliderImage->image = $resultImage['image'];

        $sliderImage->save();
        $imageHandler->clear();

        success('Slide Information Saved');

        return form()->route('admin::slider::list');
    }

    public function getUpdate(SliderImages $image)
    {
        $this->force(['admin', 'support']);

        $imageUpload = new ImageUploadHandler('sliderImage.update-'.$id, 'image', false);
        $imageUpload->setImageId($image->image);

        return view('admin.slider.update', [
            'model' => $image,
            'image' => $imageUpload->getImage(),

        ]);
    }

    public function postUpdate(SliderImages $image, Request $request)
    {
        $this->force(['admin', 'support']);
        $homeUrl = url('/');
        if (! empty($request->get('image_url')) && strpos($request->get('image_url'), $homeUrl) === false) {

            list($width, $height) = getimagesize($request->get('image_url'));
            if ($width < 660 || $height < 440) {
                return form()->error('Image width should be atleast 660px and height should be atleast 440px')->back();
            }
        }
        $imageHandler = new ImageUploadHandler('sliderImage.update-'.$id, 'image', false, 1024, 960);
        $resultImage = $imageHandler->post();
        if ($resultImage instanceof RedirectResponse) {
            return $resultImage;
        }
        if ($resultImage['image'] == null) {
            return form()->error('Image is required')->back();
        }

        $validator = slider_image_repository()->validate($request, [
            'url',
            'image' => 'dimensions:min_width=660,min_height=440',
        ]);
        if ($validator->fails()) {
            $image->save();

            return form()->error($validator->errors())->back();
        }
        $image->url = $request->get('url');
        $image->priority = $request->get('priority');
        $image->image = $resultImage['image'];
        $image->save();
        $imageHandler->clear();

        success('Slide Information Saved');

        return form()->route('admin::slider::list');
    }

    public function getDelete(SliderImages $image)
    {
        $this->force(['admin']);

        return view('admin.slider.delete', [
            'image' => $image,
        ]);
    }

    public function postDelete(SliderImages $image)
    {
        $image->delete();
        success('Slide Deleted');

        return form()->route('admin::slider::list');
    }
}
