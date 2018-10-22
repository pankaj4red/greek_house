<?php

namespace App\Forms;

use App;
use App\Helpers\FileHandler;
use App\Logging\Logger;
use File;
use Request;
use Session;

class FileUploadHandler
{
    /**
     * @var bool
     */
    protected $thumbnailEnabled = false;

    /**
     * @var string
     */
    protected $prefix;

    /**
     * @var int
     */
    protected $fieldId;

    /**
     * FileUploadHandler constructor.
     *
     * @param string $prefix
     * @param int    $fieldId
     */
    public function __construct($prefix, $fieldId)
    {
        $this->prefix = $prefix;
        $this->fieldId = $fieldId;
    }

    /**
     * @return array|null
     */
    public function getFile()
    {
        $fileId = Session::get($this->prefix.'.'.$this->fieldId.'-file');
        $file = null;
        if ($fileId) {
            $file = file_repository()->find($fileId);
        }

        if ($file) {
            $file = [
                'url'      => route('system::file', [$file->id]),
                'filename' => $file->name,
                'id'       => $file->id,
                'action'   => 'existing',
            ];
        }

        return $file;
    }

    /**
     * @return mixed
     */
    public function post()
    {
        $fileId = Session::get($this->prefix.'.'.$this->fieldId.'-file');
        $file = null;
        if ($fileId) {
            $file = file_repository()->find($fileId);
        }
        $any = false;
        if (Request::has($this->fieldId.'_action')) {
            switch (Request::get($this->fieldId.'_action')) {
                case 'new':
                    $any = true;
                    $content = App::make(FileHandler::class)->getContent(Request::get($this->fieldId.'_url'));

                    $file = file_repository()->make();
                    $file->name = Request::get($this->fieldId.'_filename');
                    $file->size = App::make(FileHandler::class)->getRemoteSize(Request::get($this->fieldId.'_url'));
                    $file->internal_filename = save_file($content);
                    $imageMimeTypes = [
                        'image/png',
                        'image/gif',
                        'image/jpeg',
                        'image/x-png',
                        'image/x-citrix-png',
                        'image/x-citrix-jpeg',
                        'image/pjpeg',
                    ];
                    File::put(sys_get_temp_dir().DIRECTORY_SEPARATOR.$file->name, $content);
                    $fileMimeType = File::mimeType(sys_get_temp_dir().DIRECTORY_SEPARATOR.$file->name);
                    if (in_array($fileMimeType, $imageMimeTypes)) {
                        $file->type = 'image';
                    }
                    $file->save();
                    $fileId = $file->id;
                    break;
                case 'remove':
                    $any = true;
                    $fileId = null;
                    if ($file != null) {
                        //$file->delete();
                        $file = null;
                    }
                    break;
                case 'existing':
                    // do nothing
                    break;
                default:
                    Logger::logWarning('#FileUpload #InvalidOperation '.Request::get($this->fieldId.'_action'));

                    return form()->error('Invalid file operation')->back();
            }
        }
        if ($any) {
            Session::put($this->prefix.'.'.$this->fieldId.'-file', $file ? $file->id : null);
        }

        return ['file' => $fileId];
    }

    /**
     * @return void
     */
    public function clear()
    {
        Session::put($this->prefix.'.'.$this->fieldId.'-file', null);
    }

    /**
     * @param int $fileId
     */
    public function setFileId($fileId)
    {
        if (! Session::has('errors')) {
            Session::put($this->prefix.'.'.$this->fieldId.'-file', $fileId);
        }
    }
}
