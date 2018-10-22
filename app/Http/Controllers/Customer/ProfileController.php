<?php

namespace App\Http\Controllers\Customer;

use App\Exceptions\AddressValidationException;
use App\Forms\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Lob\Exception\ValidationException;

class ProfileController extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    public function getIndex()
    {
        return view('profile.index');
    }

    public function getEditInformation()
    {
        $avatar = new ImageUploadHandler('profile', 'avatar', true);
        $avatar->setImageId(Auth::user()->avatar_id);
        $avatar->setThumbnailId(Auth::user()->avatar_thumbnail_id);

        return view('profile.edit_information', [
            'model'             => Auth::user(),
            'avatar'            => $avatar->getImage(),
            'schoolYearOptions' => array_merge(['' => 'Select School Year'], school_year_options()),
        ]);
    }

    public function postEditInformation(Request $request)
    {
        if ($request->has('cancel')) {
            return form()->route('profile::index');
        }
        if ($request->has('save')) {
            $user = user_repository()->find(\Auth::user()->id);
            $avatar = new ImageUploadHandler('profile', 'avatar', true, 200, 200, 40, 40);
            $result = $avatar->post();
            if ($result instanceof RedirectResponse) {
                return $result;
            }
            $validator = user_repository()->validate($request, ['first_name', 'last_name', 'email', 'phone', 'school', 'chapter', 'school_year', 'venmo_username', 'graduation_year'], $user->id);
            if ($validator->fails()) {
                return form()->error($validator->errors())->back();
            }

            $user->first_name = $request->get('first_name');
            $user->last_name = $request->get('last_name');
            $user->email = $request->get('email');
            $user->phone = get_phone($request->get('phone'));
            $user->school = $request->get('school');
            $user->chapter = $request->get('chapter');
            $user->graduation_year = $request->get('graduation_year');
            $user->school_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'school');
            $user->chapter_id = school_chapter_match($request->get('school'), $request->get('chapter'), 'chapter');
            $user->school_year = $request->get('school_year') ? $request->get('school_year') : null;
            $user->venmo_username = $request->has('venmo_username') ? $request->get('venmo_username') : null;
            if ($request->has('hourly_rate')) {
                $user->hourly_rate = $request->get('hourly_rate');
            }
            $user->avatar_id = $result['image'];
            $user->avatar_thumbnail_id = $result['thumbnail'];
            $user->save();
            $avatar->clear();

            return form()->success('Profile Information Saved')->route('profile::index');
        }

        return form()->route('profile::edit_information');
    }

    public function getAddAddress()
    {
        return view('profile.add_address');
    }

    public function postAddAddress(Request $request)
    {
        if ($request->has('cancel')) {
            return form()->route('profile::index');
        }

        if ($request->has('save')) {
            $validator = address_repository()->validate($request);
            if ($validator->fails()) {
                return form()->error($validator->errors())->back();
            }
            try {
                lob_repository()->verifyAddress($request->all());
            } catch (AddressValidationException $ex) {
                return form()->error($ex->getMessage())->back();
            } catch (ValidationException $ex) {
                // ignore
                Logger::logLogicError([$ex->getMessage()]);
            }
            $address = address_repository()->create([
                'name'     => $request->get('name'),
                'line1'    => $request->get('line1'),
                'line2'    => $request->get('line2'),
                'city'     => $request->get('city'),
                'state'    => $request->get('state'),
                'zip_code' => $request->get('zip_code'),
                'country'  => $request->get('country') ?? 'usa',
                'user_id'  => \Auth::user()->id,
            ]);

            if (\Auth::user()->address_id == null) {
                user_repository()->find(\Auth::user()->id)->update([
                    'address_id' => $address->id,
                ]);
            }

            return form()->success('Address Saved')->route('profile::index');
        }

        return form()->route('profile::add_address');
    }

    public function getEditAddress($id)
    {
        $address = address_repository()->find($id);
        if ($address == null) {
            return form()->error('Unknown Address')->route('profile::index');
        }
        if ($address->user_id != \Auth::user()->id) {
            return form()->error('Unknown Address')->route('profile::index');
        }

        return view('profile.edit_address', [
            'model' => [
                'name'     => $address->name,
                'line1'    => $address->line1,
                'line2'    => $address->line2,
                'city'     => $address->city,
                'state'    => $address->state,
                'zip_code' => $address->zip_code,
                'country'  => $address->country,
            ],
        ]);
    }

    public function postEditAddress($id, Request $request)
    {
        $address = address_repository()->find($id);
        if ($address == null) {
            return form()->error('Unknown Address')->route('profile::index');
        }
        if ($address->user_id != \Auth::user()->id) {
            return form()->error('Unknown Address')->route('profile::index');
        }
        if ($request->has('cancel')) {
            return form()->route('profile::index');
        }
        if ($request->has('save')) {
            $validator = address_repository()->validate($request);
            if ($validator->fails()) {
                return form()->error($validator->errors())->back();
            }
            try {
                lob_repository()->verifyAddress($request->all());
            } catch (AddressValidationException $ex) {
                return form()->error($ex->getMessage())->back();
            } catch (ValidationException $ex) {
                // ignore
                Logger::logLogicError([$ex->getMessage()]);
            }
            $address->name = $request->get('name');
            $address->line1 = $request->get('line1');
            $address->line2 = $request->get('line2');
            $address->city = $request->get('city');
            $address->state = $request->get('state');
            $address->zip_code = $request->get('zip_code');
            $address->country = $request->get('country') ?? 'usa';
            $address->user_id = \Auth::user()->id;
            $address->save();

            return form()->success('Address Saved')->route('profile::index');
        }

        if ($request->has('shipping')) {
            user_repository()->find(\Auth::user()->id)->update([
                'address_id' => $address->id,
            ]);

            return form()->success('Address is now default for Shipping')->route('profile::index');
        }

        if ($request->has('delete')) {
            if (\Auth::user()->address_id == $address->id) {
                user_repository()->find(\Auth::user()->id)->update([
                    'address_id' => null,
                ]);
            }
            $address->delete();

            return form()->success('Address has been deleted')->route('profile::index');
        }

        return form()->route('profile::edit_address', [$id]);
    }

    public function postToggleDecoratorStatus()
    {
        $user = user_repository()->find(\Auth::user()->id);
        $user->update([
            'decorator_status' => $user->decorator_status == 'ON' ? 'OFF' : 'ON',
        ]);

        return form()->success('Decorator Status Toggled')->back();
    }
}
