<?php

namespace Tests\Helpers;

use App\Models\File;

class FileGenerator
{
    /**
     * @var File $file
     */
    public $file;
    
    /**
     * @param File $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }
    
    /**
     * @param string|null $type
     * @return FileGenerator
     */
    public static function create($type = null)
    {
        if ($type) {
            $user = factory(File::class)->states($type)->create();
        } else {
            $user = factory(File::class)->create();
        }
        
        return new FileGenerator($user);
    }
    
    /**
     * @return File $file
     */
    public function file()
    {
        return $this->file;
    }
}