<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminBaseController;
use Illuminate\Http\Request;

class AddressController extends AdminBaseController
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('user_type:is_support');
    }

    public function getCreate($userId)
    {
        return view('admin_old.address.create', [
            'model'  => [],
            'userId' => $userId,
        ]);
    }

    public function postCreate($userId, Request $request)
    {
        $user = user_repository()->find($userId);
        if ($user == null) {
            return form()->error('Unknown User')->route('admin::user::list');
        }
        $validator = address_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $address = address_repository()->create([
            'name'     => $request->get('name'),
            'line1'    => $request->get('line1'),
            'line2'    => $request->get('line2'),
            'city'     => $request->get('city'),
            'state'    => $request->get('state'),
            'zip_code' => $request->get('zip_code'),
            'country'  => $request->get('country'),
            'user_id'  => $userId,
        ]);
        if ($user->address_id == null) {
            $user = user_repository()->find($userId);
            $user->address_id = $address->id;
            $user->save();
        }

        return form()->success('Address Saved')->route('admin::user::read', [$userId]);
    }

    public function getUpdate($id)
    {
        $address = address_repository()->find($id);

        return view('admin_old.address.update', [
            'model'  => $address,
            'userId' => $address->user_id,
        ]);
    }

    public function postUpdate($id, Request $request)
    {
        $address = address_repository()->find($id);
        if ($address == null) {
            return form()->error('Unknown Address')->route('admin::user::list');
        }
        if ($address->user_id == null) {
            return form()->error('Unknown Address')->route('admin::user::list');
        }
        $validator = address_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors());
        }
        $address->name = $request->get('name');
        $address->line1 = $request->get('line1');
        $address->line2 = $request->get('line2');
        $address->city = $request->get('city');
        $address->state = $request->get('state');
        $address->zip_code = $request->get('zip_code');
        $address->country = $request->get('country');
        $address->save();
        success('Address Saved');

        return form()->route('admin::user::read', [$address->user_id]);
    }

    public function getDelete($id)
    {
        return view('admin_old.address.delete');
    }

    public function postDelete($id)
    {

    }

    public function getMakeShipping($id)
    {
        $address = address_repository()->find($id);
        $user = user_repository()->find($address->user_id);
        $user->address_id = $address->id;
        $user->save();

        success('Address Saved');

        return form()->route('admin::user::read', [$address->user_id]);
    }
}
