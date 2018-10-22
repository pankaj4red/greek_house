<?php

namespace App\Http\Controllers;

use App\Logging\Logger;
use Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        Logger::setModule('#'.$this->getControllerName());
    }

    private function getControllerName()
    {
        return str_replace('Controller', '', class_basename($this));
    }

    public function force($types)
    {
        if (! Auth::user() || ! Auth::user()->isType($types)) {
            throw new HttpException(403, 'Access Denied');
        }
    }
}
