<?php

namespace App\Forms;

use App;
use App\Helpers\ImageHandler;
use App\Logging\Logger;
use Exception;
use Request;
use Session;

class ImageUploadHandler
{
    /**
     * @var bool
     */
    protected $thumbnailEnabled = false;

    /**
     * @var array|int[]
     */
    protected $imageSize = [1024, 960];

    /**
     * @var array|int[]
     */
    protected $thumbnailSize = [260, 260];

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var int
     */
    protected $fieldId;

    /**
     * ImageUploadHandler constructor.
     *
     * @param string $prefix
     * @param int    $fieldId
     * @param bool   $thumbnailEnabled
     * @param int    $imageWidth
     * @param int    $imageHeight
     * @param int    $thumbnailWidth
     * @param int    $thumbnailHeight
     */
    public function __construct(
        $prefix,
        $fieldId,
        $thumbnailEnabled = false,
        $imageWidth = 1024,
        $imageHeight = 960,
        $thumbnailWidth = 260,
        $thumbnailHeight = 260
    ) {
        $this->prefix = $prefix;
        $this->fieldId = $fieldId;
        $this->thumbnailEnabled = $thumbnailEnabled;
        $this->imageSize = [$imageWidth, $imageHeight];
        $this->thumbnailSize = [$thumbnailWidth, $thumbnailHeight];
    }

    /**
     * @param bool $thumbnailEnabled
     */
    public function setThumbnailEnabled($thumbnailEnabled)
    {
        $this->thumbnailEnabled = $thumbnailEnabled;
    }

    /**
     * @param int $width
     * @param int $height
     */
    public function setImageSize($width, $height)
    {
        $this->imageSize = [$width, $height];
    }

    /**
     * @param int $width
     * @param int $height
     */
    public function setThumbnailSize($width, $height)
    {
        $this->thumbnailSize = [$width, $height];
    }

    /**
     * @return array|null
     */
    public function getImage()
    {
        $imageId = Session::get($this->prefix.'.'.$this->fieldId.'-image');
        $image = null;
        if ($imageId) {
            $image = file_repository()->find($imageId);
        }

        if ($image) {
            $image = [
                'url'      => route('system::image', [$image->id]),
                'filename' => $image->name,
                'id'       => $image->id,
                'action'   => 'existing',
            ];
        }

        return $image;
    }

    /**
     * @return array|null
     */
    public function getThumbnail()
    {
        $thumbnailId = Session::get($this->prefix.'.'.$this->fieldId.'-thumbnail');
        $thumbnail = null;
        if ($thumbnailId) {
            $thumbnail = file_repository()->find($thumbnailId);
        }
        if ($thumbnail) {
            $thumbnail = [
                'url'      => route('system::image', [$thumbnail->id]),
                'filename' => $thumbnail->name,
                'id'       => $thumbnail->id,
                'action'   => 'existing',
            ];
        }

        return $thumbnail;
    }

    /**
     * @return mixed
     */
    public function post()
    {
        try {
            $imageId = Session::get($this->prefix.'.'.$this->fieldId.'-image');
            $image = null;
            if ($imageId) {
                $image = file_repository()->find($imageId);
            }
            $thumbnailId = null;
            $thumbnail = null;
            if ($this->thumbnailEnabled) {
                $thumbnailId = Session::get($this->prefix.'.'.$this->fieldId.'-thumbnail');
                if ($thumbnailId) {
                    $thumbnail = file_repository()->find($thumbnailId);
                }
            }
            $any = false;
            if (Request::has($this->fieldId.'_action')) {
                switch (Request::get($this->fieldId.'_action')) {
                    case 'new':
                        if ($image) {
                            //TODO: Remove image
                            //$image->delete();
                        }
                        if ($this->thumbnailEnabled && $thumbnail) {
                            //TODO: Remove image
                            //$thumbnail->delete();
                        }
                        $any = true;
                        $content = App::make(ImageHandler::class)->getContent(Request::get($this->fieldId.'_url'), $this->imageSize[0], $this->imageSize[1]);

                        $image = file_repository()->make();
                        $image->name = Request::get($this->fieldId.'_filename');
                        $image->internal_filename = save_file($content);
                        $image->type = 'image';
                        $image->sub_type = 'png';
                        $image->mime_type = 'image/png';
                        $image->save();
                        $imageId = $image->id;
                        cache_image($imageId, $content);

                        if ($this->thumbnailEnabled) {
                            $content = App::make(ImageHandler::class)->getContent(Request::get($this->fieldId.'_url'), $this->thumbnailSize[0], $this->thumbnailSize[1]);

                            $thumbnail = file_repository()->make();
                            $thumbnail->name = Request::get($this->fieldId.'_filename');
                            $thumbnail->internal_filename = save_file($content);
                            $thumbnail->type = 'image';
                            $thumbnail->sub_type = 'png';
                            $thumbnail->mime_type = 'image/png';
                            $thumbnail->save();
                            $thumbnailId = $thumbnail->id;
                            cache_image($thumbnailId, $content);
                        }
                        break;
                    case 'remove':
                        $any = true;
                        if ($image != null) {
                            $image = null;
                            $imageId = null;
                            if ($this->thumbnailEnabled) {
                                $thumbnail = null;
                                $thumbnailId = null;
                            }
                        }
                        break;
                    case 'existing':
                        // do nothing
                        break;
                    default:
                        Logger::logWarning('#ImageUpload #InvalidOperation '.Request::get($this->fieldId.'_action'));

                        return form()->error('Invalid image operation')->back();
                }
            }
            if ($any) {
                Session::put($this->prefix.'.'.$this->fieldId.'-image', $image ? $image->id : null);
                if ($this->thumbnailEnabled) {
                    Session::put($this->prefix.'.'.$this->fieldId.'-thumbnail', $thumbnail ? $thumbnail->id : null);
                }
            }

            return ['image' => $imageId, 'thumbnail' => $thumbnailId];
        } catch (Exception $ex) {
            Logger::logWarning('#ImageUpload #Exception '.substr($ex->getMessage(), 200), ['exception' => $ex]);

            return form()->error('An error has occurred while trying to process the image. Please confirm the image is not corrupted and try again.')->back();
        }
    }

    /**
     * @return void
     */
    public function clear()
    {
        Session::put($this->prefix.'.'.$this->fieldId.'-image', null);
        Session::put($this->prefix.'.'.$this->fieldId.'-thumbnail', null);
    }

    /**
     * @param int $imageId
     */
    public function setImageId($imageId)
    {
        if (! Session::has('errors')) {
            Session::put($this->prefix.'.'.$this->fieldId.'-image', $imageId);
        }
    }

    /**
     * @param int $thumbnailId
     */
    public function setThumbnailId($thumbnailId)
    {
        if (! Session::has('errors')) {
            Session::put($this->prefix.'.'.$this->fieldId.'-thumbnail', $thumbnailId);
        }
    }
}
