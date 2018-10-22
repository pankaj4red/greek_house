<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Logging\Logger;
use Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    public function username()
    {
        return 'username';
    }

    /**
     * Validate the user login request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return boolean
     */
    protected function validateLogin(Request $request)
    {
        return ! form($request)->withRules([
            $this->username() => 'required|string',
            'password'        => 'required|string',
        ])->fails();
    }

    protected function login(\Illuminate\Http\Request $request)
    {
        if (! $this->validateLogin($request)) {
            return $this->sendFailedLoginResponse($request, 'Sorry, unrecognized username or password.');
        }

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        // Checks if attempt login would be successful
        if (! $this->guard()->validate($this->credentials($request)) && ! $this->guard()->validate([
                'email'    => $request->get('username'),
                'password' => $request->get('password'),
            ])) {
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request, 'Sorry, unrecognized username or password.');
        }

        // Checks if user is active
        $user = $this->guard()->getLastAttempted();
        if (! $user->active) {
            return $this->sendFailedLoginResponse($request, 'Sorry, user is inactive.');
        }

        // Actually login the user
        if (! $this->attemptLogin($request)) {
            $this->incrementLoginAttempts($request);

            return $this->sendFailedLoginResponse($request, 'Sorry, unrecognized username or password.');
        }

        return $this->sendLoginResponse($request);
    }

    protected function attemptLogin(\Illuminate\Http\Request $request)
    {
        $user = user_repository()->findByEmailOrUsername($request->get('username'));

        if (\Auth::attempt($request->only(['username', 'password']), true)) {
            if (! $user->active) {
                Logger::logDebug('#Login '.Auth::user()->id.' Inactive', ['user_id' => Auth::user()->id, 'username' => Auth::user()->username]);

                return false;
            }

            Logger::logDebug('#Login '.Auth::user()->id.' Success', ['user_id' => Auth::user()->id, 'username' => Auth::user()->username]);

            return true;
        }

        if (\Auth::attempt([
            'email'    => $request->get('username'),
            'password' => $request->get('password'),
        ], true)) {
            if (! $user->active) {
                Logger::logDebug('#Login '.Auth::user()->id.' Inactive', ['user_id' => Auth::user()->id, 'username' => Auth::user()->username]);

                return false;
            }
            Logger::logDebug('#Login '.Auth::user()->id.' Success', ['user_id' => Auth::user()->id, 'username' => Auth::user()->username]);

            return true;
        }
        Logger::logDebug('#Login '.($user ? $user->username : $request->get('username')).' Failed', ['user_id' => ($user ? $user->id : null), 'username' => ($user ? $user->username : $request->get('username'))]);

        return false;
    }

    protected function sendLoginResponse(\Illuminate\Http\Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);
        if ($request->ajax()) {
            return $this->ajaxResponse(true, 'Login Successful');
        }

        return form()->url($this->redirectPath());
    }

    protected function sendFailedLoginResponse(\Illuminate\Http\Request $request, $message)
    {
        if ($request->ajax()) {
            return $this->ajaxResponse(false, $message);
        }

        return form()->error($message)->back();
    }

    protected function ajaxResponse($auth, $message)
    {
        return response()->json([
            'auth'     => $auth,
            'message'  => $message,
            'intended' => $this->redirectPath(),
        ]);
    }

    public function logout(Request $request)
    {
        $loginAsUser = null;
        if (Session::get('adlo')) {
            $userId = (int) Session::get('adlo');
            $loginAsUser = user_repository()->find($userId);
        }

        $user = Auth::user();

        $this->guard()->logout();

        $request->session()->invalidate();

        Logger::logDebug('#Logout '.($user ? $user->id : 'NULL'), ['user_id' => $user ? $user->id : null, 'username' => $user ? $user->username : null]);

        if ($loginAsUser) {
            $this->guard()->login($loginAsUser);

            return redirect()->route('admin::user::read', $user->id);
        }

        return redirect('/');
    }
}
