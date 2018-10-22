<?php

namespace App\Http\Controllers\Admin;

use App\Forms\ImageUploadHandler;
use App\Http\Controllers\AdminBaseController;
use App\Http\Controllers\Auth\RegisterController;
use App\Logging\Logger;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class UserController extends AdminBaseController {

    public function __construct() {
        parent::__construct();
        $this->middleware('user_type:is_support');
    }

    public function getList(Request $request) {
        return view('admin_old.user.list', [
            'list' => user_repository()->getListing($request->all(), [['first_name', 'asc'], ['last_name', 'asc']], null, 20),
        ]);
    }

    public function getStores(Request $request) {
        return view('admin_old.store.list', [
            'list' => store_repository()->getListing($request->all(), [], null, 20),
        ]);
    }

    public function getRead($id) {
        return view('admin_old.user.read', [
            'user' => user_repository()->find($id),
        ]);
    }

    public function getStoreRead($id) {
        return view('admin_old.store.read', [
            'user' => store_repository()->find($id),
        ]);
    }

    public function getCreate() {
        return view('admin_old.user.create', [
            'model' => [],
            'avatar' => (new ImageUploadHandler('user.create', 'avatar', false))->getImage(),
        ]);
    }

    public function CreateStore(Request $request) {
        $user = Auth::user();
        if ($request->isMethod('post')) {
            $validator = store_repository()->validate($request, [
                'name',
                'link',
            ]);
            if ($validator->fails()) {
                return form()->error($validator->errors())->back();
            }

            $store = new \App\Models\Store();
            $store->name = $request->name;
            $store->link = $request->link;
            $store->user_id = $user->id;
            $store->created_at = time();
            $store->status = 1;
            if ($store->save()) {
                success('Store Information Saved');
                return form()->route('admin::store::list');
            } else {
                error_log('Store Information Not Saved');
                return form()->route('admin::store::create');
            }
        } else {
            return view('admin_old.store.create', [
                'model' => [],
                'avatar' => (new ImageUploadHandler('user.create', 'avatar', false))->getImage(),
            ]);
        }
    }

    public function postCreate(Request $request) {
        $imageHandler = new ImageUploadHandler('user.create', 'avatar', true, 200, 200, 40, 40);
        $result = $imageHandler->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        if ($result['image'] == null) {
            return form()->error('Image is required')->back();
        }
        if ($result['thumbnail'] == null) {
            return form()->error('Thumbnail is required')->back();
        }
        $validator = user_repository()->validate($request, ['first_name', 'last_name', 'email', 'chapter', 'school', 'school_year', 'venmo_username', 'password', 'graduation_year']);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $user = \App::make(RegisterController::class)->publicCreate($request->all());

        $user->avatar_id = $result['image'];
        $user->avatar_thumbnail_id = $result['thumbnail'];
        $user->school_year = $request->get('school_year') ? $request->get('school_year') : null;
        $user->venmo_username = $request->get('venmo_username');
        $user->school_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'school');
        $user->chapter_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'chapter');
        $user->type_code = $request->get('user_type');
        $user->save();
        $imageHandler->clear();
        success('User Information Saved');

        return form()->route('admin::user::read', [$user->id]);
    }

    public function getUpdate($id) {
        $user = user_repository()->find($id);
        $imageUpload = new ImageUploadHandler('user.update-' . $id, 'avatar', true);
        $imageUpload->setImageId($user->avatar_id);
        $imageUpload->setThumbnailId($user->avatar_thumbnail_id);

        return view('admin_old.user.update', [
            'model' => $user->toArray(),
            'avatar' => $imageUpload->getImage(),
        ]);
    }

    public function getStoreUpdate($id, Request $request) {
        $user = Auth::user();
        if ($request->isMethod('post')) {
            $validator = store_repository()->validate($request, [
                'name',
                'link',
            ]);
            if ($validator->fails()) {
                return form()->error($validator->errors())->back();
            }
            $store = \App\Models\Store::where('id', $id)->first();
            $store->name = $request->name;
            $store->link = $request->link;
            if ($store->save()) {
                success('Store Information Updated');
                return form()->route('admin::store::list');
            } else {
                error_log('Store Information Not Updated');
                return form()->route('admin::store::update', $id);
            }
        } else {
            $store = store_repository()->find($id);
            return view('admin_old.store.update', [
                'model' => $store->toArray()
            ]);
        }
    }

    public function postUpdate($id, Request $request) {
        $user = user_repository()->find($id);
        $imageUpload = new ImageUploadHandler('user.update-' . $id, 'avatar', true, 200, 200, 40, 40);
        $result = $imageUpload->post();
        if ($result instanceof RedirectResponse) {
            return $result;
        }
        $validator = user_repository()->validate($request, [
            'username',
            'first_name',
            'last_name',
            'email',
            'chapter',
            'school',
            'school_year',
            'venmo_username',
            'activation_code',
            'decorator_status',
            'activation_code',
            'decorator_status',
            'on_hold_state',
            'type_code',
            'graduation_year',
                ], $id);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }

        $user->username = $request->get('username');
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->phone = get_phone($request->get('phone'));
        $user->email = $request->get('email');
        $user->chapter = $request->get('chapter');
        $user->school = $request->get('school');
        $user->graduation_year = $request->get('graduation_year');
        $user->school_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'school');
        $user->chapter_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'chapter');
        $user->school_year = $request->get('school_year') ? $request->get('school_year') : null;
        $user->venmo_username = $request->get('venmo_username');
        $user->activation_code = $request->get('activation_code');
        $user->active = $request->get('active') ? true : false;
        $user->account_manager_id = null;
        $user->decorator_status = $request->get('decorator_status');
        $user->decorator_screenprint_enabled = $request->get('decorator_screenprint_enabled') ? true : false;
        $user->decorator_embroidery_enabled = $request->get('decorator_embroidery_enabled') ? true : false;
        $user->on_hold_state = $request->get('on_hold_state');

        $user->avatar_id = $result['image'];
        $user->avatar_thumbnail_id = $result['thumbnail'];

        if ($request->has('account_manager')) {
            $user->account_manager_id = $request->get('account_manager');
        }
        $user->type_code = $request->get('type_code');
        $user->save();
        success('User Information Saved');

        return form()->route('admin::user::read', [$id]);
    }

    public function getDelete($id) {
        return view('admin_old.user.delete');
    }

    public function getStoreDelete($id) {
        $store = \App\Models\Store::find($id);
        if ($store->delete()) {
            success('Store Successfully Deleted');
            return form()->route('admin::store::list');
        }
    }

    public function postDelete($id) {
        
    }

    public function postLoginAs($id) {
        $user = user_repository()->find($id);
        if ($user == null) {
            return form()->error('Unknown User')->route('admin::user::list');
        }
        \Session::put('adlo', \Auth::user()->id);
        \Auth::login($user);
        Logger::track('Session', '', '#User ' . \Auth::user()->id . ' logged as ' . $id, []);

        return form()->route('dashboard::index');
    }

}
