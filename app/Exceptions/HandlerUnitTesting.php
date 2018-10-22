<?php

namespace App\Exceptions;

use Exception;

class HandlerUnitTesting extends Handler
{
    /**
     * @param \Exception $ex
     */
    public function report(Exception $ex)
    {

    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param Exception                $e
     * @return \Illuminate\Http\Response|void
     * @throws Exception
     */
    public function render($request, Exception $e)
    {
        throw $e;
    }
}
