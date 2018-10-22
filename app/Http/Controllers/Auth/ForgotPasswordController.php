<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest');
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {
        if (\Request::ajax()) {
            return $this->ajaxResponse(true);
        }

        return form()->success(trans($response))->back();
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
     * @throws ValidationException
     */
    protected function validateEmail(Request $request)
    {
        if ($request->ajax()) {
            $validator = \Validator::make($request->all(), ['email' => 'required|email']);

            if ($validator->fails()) {
                throw new ValidationException($validator, new JsonResponse([
                    'success'  => false,
                    'intended' => '',
                ]));
            }
        }
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        if ($request->ajax()) {
            return $this->ajaxResponse(false);
        }

        return form()->error(['email' => trans($response)])->back();
    }

    protected function ajaxResponse($success)
    {
        return response()->json([
            'success'  => $success,
            'intended' => '/',
        ]);
    }
}
