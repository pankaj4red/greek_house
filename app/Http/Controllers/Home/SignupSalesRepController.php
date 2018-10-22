<?php

namespace App\Http\Controllers\Home;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SignupSalesRepController extends Controller
{
    public function getStep1($campusId = null)
    {
        if (\Auth::user()) {
            if (\Auth::user()->isType('sales_rep')) {
                return form()->route('signup_sales_rep::step2');
            } else {
                return form()->route('dashboard::index');
            }
        }

        return view('signup_sales_rep.step1', [
            'avatar'     => (new ImageUploadHandler('signup_sales', 'avatar', true))->getImage(),
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Explainer Video'],
                ['title' => 'STEP 3', 'text' => 'Get Started!'],
            ],
            'stepActive' => 0,
        ]);
    }

    public function postStep1(Request $request, $campusId = null)
    {
        if (\Auth::user()) {
            if (\Auth::user()->isType('sales_rep')) {
                return form()->route('signup_sales_rep::step2');
            } else {
                return form()->route('dashboard::index');
            }
        }
        $imageHandler = new ImageUploadHandler('signup_sales', 'avatar', true, 200, 200, 40, 40);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        $validator = user_repository()->validate($request, ['first_name', 'last_name', 'email', 'phone', 'school', 'chapter', 'venmo_username', 'password']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        if (form($request)->withRules(['agree' => 'required'])->fails()) {
            return form()->error('You need to agree to the Terms and Conditions.')->back();
        }

        $user = \App::make(RegisterController::class)->publicCreate($request->all());
        if ($result['image']) {
            $user->avatar_id = $result['image'];
            $user->avatar_thumbnail_id = $result['thumbnail'];
        }
        $user->school_year = null;
        $user->venmo_username = $request->get('venmo_username');
        $user->type_code = 'sales_rep';
        $user->school_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'school');
        $user->chapter_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'chapter');
        $user->active = true;
        if ($campusId) {
            $user->account_manager_id = $campusId;
        }
        $user->save();

        $imageHandler->clear();
        \Auth::login($user);

        return form()->success('Sign Up Successful!')->route('signup_sales_rep::step2');
    }

    public function getStep2()
    {
        if (! \Auth::user()) {
            return form()->route('home::index');
        }
        if (! \Auth::user()->isType('sales_rep')) {
            return form()->route('dashboard::index');
        }

        return view('signup_sales_rep.step2', [
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Explainer Video'],
                ['title' => 'STEP 3', 'text' => 'Get Started!'],
            ],
            'stepActive' => 1,
        ]);
    }

    public function getStep3()
    {
        if (! \Auth::user()) {
            return form()->route('home::index');
        }
        if (! \Auth::user()->isType('sales_rep')) {
            return form()->route('dashboard::index');
        }

        return view('signup_sales_rep.step3', [
            'steps'      => [
                ['title' => 'STEP 1', 'text' => 'Input Your Information'],
                ['title' => 'STEP 2', 'text' => 'Explainer Video'],
                ['title' => 'STEP 3', 'text' => 'Get Started!'],
            ],
            'stepActive' => 2,
        ]);
    }

    public function getTos()
    {
        return view('signup_sales_rep.tos');
    }
}
