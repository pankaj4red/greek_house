<?php

namespace App\Helpers;

use App\Logging\Logger;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Validation\ValidationException;
use Session;
use Validator;

class FormHandler
{
    protected $request = null;

    protected $rules = [];

    protected $errors = [];

    /**
     * FormHandler constructor.
     *
     * @param Request|null $request
     */
    public function __construct(Request $request = null)
    {
        $this->request = $request;
    }

    /**
     * @param string|array $success
     * @return $this
     */
    public function success($success)
    {
        success($success);

        return $this;
    }

    /**
     * @param string|array $error
     * @return $this
     */
    public function error($error)
    {
        if (is_array($error)) {
            $this->errors = array_merge($this->errors, $error);

            return $this;
        }

        if ($error instanceof MessageBag) {
            $this->errors = array_merge($this->errors, $error->toArray());

            return $this;
        }
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @param array $rules
     * @return $this
     */
    public function withRules($rules)
    {
        $this->rules = array_merge($this->rules, $rules);

        return $this;
    }

    /*
     * @return \Illuminate\Http\RedirectResponse
     */
    public function back()
    {
        $validator = $this->getValidatorWithErrors();
        $errors = $validator->errors()->toArray();
        if (count($errors) > 0) {
            Session::flash('errors', (new ViewErrorBag())->put('default', new MessageBag($errors)));
            Logger::logLogicError($this->errors);
        }

        if (\Request::ajax()) {
            if (count($errors) > 0) {
                return response()->json([
                    'success' => false,
                    'errors'  => $this->errors,
                ]);
            } else {
                return response()->json([
                    'success'  => true,
                    'intended' => back()->getTargetUrl(),
                ]);
            }
        }

        return back()->withInput();
    }

    /**
     * @param string $route
     * @param array  $parameters
     * @return \Illuminate\Http\RedirectResponse
     */
    public function route($route, $parameters = [])
    {
        $validator = $this->getValidatorWithErrors();
        $errors = $validator->errors()->toArray();
        if (count($errors) > 0) {
            Session::flash('errors', (new ViewErrorBag())->put('default', new MessageBag($errors)));
            Logger::logLogicError($this->errors);
        }

        if (\Request::ajax()) {
            return response()->json([
                'success'  => true,
                'intended' => route($route, $parameters),
            ]);
        }

        return redirect()->route($route, $parameters);
    }

    /**
     * @param $url
     * @return \Illuminate\Http\RedirectResponse
     * @internal param string $route
     */
    public function url($url)
    {
        $validator = $this->getValidatorWithErrors();
        $errors = $validator->errors()->toArray();
        if (count($errors) > 0) {
            Session::flash('errors', (new ViewErrorBag())->put('default', new MessageBag($errors)));
            Logger::logLogicError($this->errors);
        }

        if (\Request::ajax()) {
            return response()->json([
                'success'  => true,
                'intended' => $url,
            ]);
        }

        return redirect()->intended($url);
    }

    /**
     * @param array $rules
     * @return \Illuminate\Validation\Validator
     */
    private function getValidatorWithErrors($rules = [])
    {
        $rules = array_merge($this->rules, $rules);
        $validator = Validator::make($this->request ? $this->request->all() : [], $rules);
        foreach ($this->errors as $key => $error) {
            $key = is_string($key) ? $key : null;
            if (is_array($error)) {
                foreach ($error as $errorEntry) {
                    $validator->getMessageBag()->add($key, $errorEntry);
                }
            } else {
                $validator->getMessageBag()->add($key, $error);
            }
        }

        return $validator;
    }

    /**
     * @param array $rules
     * @throws ValidationException
     */
    public function validate($rules = [])
    {
        $validator = $this->getValidatorWithErrors($rules);
        if ($this->request && $this->request->expectsJson() && $validator->fails()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'errors'  => $validator->errors()->toArray(),
            ]));
        }
        $validator->validate();
    }

    /**
     * @param       $data
     * @param array $rules
     */
    public function validateData($data, $rules = [])
    {
        $validator = Validator::make($data, $rules);
        if ($validator->fails()) {
            if (\Request::ajax()) {
                throw new HttpResponseException(response()->json([
                    'success' => false,
                    'errors'  => $validator->errors()->toArray(),
                ]));
            }

            throw new HttpResponseException(back()->withErrors($validator->errors()->toArray()));
        }
    }

    /**
     * @return bool
     */
    public function fails()
    {
        return $this->getValidatorWithErrors()->fails();
    }
}
