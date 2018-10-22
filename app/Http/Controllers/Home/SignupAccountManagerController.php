<?php

namespace App\Http\Controllers\Home;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SignupAccountManagerController extends Controller
{
    public function getStep1()
    {
        if (\Auth::user()) {
            if (\Auth::user()->isType('account_manager')) {
                return form()->route('signup_account_manager::step2');
            } else {
                return form()->route('dashboard::index');
            }
        }

        return view('signup_account_manager.step1', [
            'avatar'     => (new ImageUploadHandler('signup_account_manager', 'avatar', true))->getImage(),
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Why Greek House?'],
                ['title' => 'STEP 3', 'text' => 'Explainer Video'],
                ['title' => 'STEP 4', 'text' => 'Get Started!'],
            ],
            'stepActive' => 0,
        ]);
    }

    public function postStep1(Request $request)
    {
        if (\Auth::user()) {
            if (\Auth::user()->isType('account_manager')) {
                return form()->route('signup_account_manager::step2');
            } else {
                return form()->route('dashboard::index');
            }
        }

        $imageHandler = new ImageUploadHandler('signup_account_manager', 'avatar', true, 200, 200, 40, 40);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        $validator = user_repository()->validate($request, ['first_name', 'last_name', 'email', 'school', 'phone', 'chapter', 'venmo_username', 'password', 'graduation_year']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        if (\Validator::make($request->all(), ['agree' => 'required'])->fails()) {
            return form()->error('You need to agree to the Terms and Conditions.')->back();
        }
        $user = \App::make(RegisterController::class)->publicCreate($request->all());
        if ($result['image']) {
            $user->avatar_id = $result['image'];
            $user->avatar_thumbnail_id = $result['thumbnail'];
        }

        $user->school_year = null;
        $user->venmo_username = $request->get('venmo_username');
        $user->type_code = 'account_manager';
        $user->school_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'school');
        $user->chapter_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'chapter');
        $user->active = true;
        $user->save();

        $imageHandler->clear();
        \Auth::login($user);

        return form()->success('Sign Up Successful!')->route('signup_account_manager::step2');
    }

    public function getStep2()
    {
        if (! \Auth::user()) {
            return form()->route('home::index');
        }
        if (! \Auth::user()->isType('account_manager')) {
            return form()->route('dashboard::index');
        }

        return view('signup_account_manager.step2', [
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Why Greek House?'],
                ['title' => 'STEP 3', 'text' => 'Explainer Video'],
                ['title' => 'STEP 4', 'text' => 'Get Started!'],
            ],
            'stepActive' => 1,
        ]);
    }

    public function getStep3()
    {
        if (! \Auth::user()) {
            return form()->route('home::index');
        }
        if (! \Auth::user()->isType('account_manager')) {
            return form()->route('dashboard::index');
        }

        return view('signup_account_manager.step3', [
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Why Greek House?'],
                ['title' => 'STEP 3', 'text' => 'Explainer Video'],
                ['title' => 'STEP 4', 'text' => 'Get Started!'],
            ],
            'stepActive' => 2,
        ]);
    }

    public function getStep4()
    {
        if (! \Auth::user()) {
            return form()->route('home::index');
        }
        if (! \Auth::user()->isType('account_manager')) {
            return form()->route('dashboard::index');
        }

        return view('signup_account_manager.step4', [
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Why Greek House?'],
                ['title' => 'STEP 3', 'text' => 'Explainer Video'],
                ['title' => 'STEP 4', 'text' => 'Get Started!'],
            ],
            'stepActive' => 3,
        ]);
    }

    public function getTos()
    {
        return view('signup_account_manager.tos');
    }
}
