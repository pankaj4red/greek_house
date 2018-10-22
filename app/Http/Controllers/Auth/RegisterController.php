<?php

namespace App\Http\Controllers\Auth;

use App\Events\User\UserCreated;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFLead;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'first_name'      => 'required|max:255',
            'last_name'       => 'required|max:255',
            'email'           => 'required|email|max:255|unique:users',
            'phone'           => 'required',
            'password'        => 'required|confirmed|min:3',
            'school'          => 'required',
            'chapter'         => 'required',
            'position'        => 'required',
            'members'         => 'required',
            'graduation_year' => 'required',
        ]);
    }

    /**
     *  A validator for new set password popup
     */
    protected function setPasswordValidator(array $data)
    {
        return Validator::make($data, [
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:3',

        ]);
    }

    /**
     * @param array $data
     * @return \App\Models\User
     * check Set password form validation
     */
    public function checkSetPasswordInputs(Request $request)
    {
        $validator = $this->setPasswordValidator($request->all());

        if ($validator->fails()) {

            return response()->json([
                'success' => false,
                'message' => $validator->getMessageBag()->first(),
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => '',
            ]);
        }
    }

    public function publicCreate(array $data)
    {
        return $this->create($data);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        $user = user_repository()->make();
        $user->first_name = trim($data['first_name']);
        $user->last_name = trim($data['last_name']);
        $user->email = trim($data['email']);
        $user->password = bcrypt($data['password']);
        $user->activation_code = str_random(40);
        if (isset($data['phone'])) {
            $user->phone = $data['phone'];
        }
        if (isset($data['chapter'])) {
            $user->chapter = $data['chapter'];
        }
        if (isset($data['graduation_year'])) {
            $user->graduation_year = $data['graduation_year'];
        }
        if (isset($data['school'])) {
            $user->school = $data['school'];
        }
        $user->save();
        $user->username = str_replace(' ', '', strtolower($user->first_name).'_'.strtolower($user->last_name).'_'.$user->id);
        $user->save();
        event(new UserCreated($user->id));

        return $user;
    }

    public function register(Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json([
                    'auth'     => false,
                    'intended' => \URL::previous(),
                    'error'    => $validator->getMessageBag()->first(),
                ]);
            } else {
                $this->throwValidationException($request, $validator);
            }
        }

        $user = $this->create($request->all());
        \Auth::login($user);

        if (config('services.salesforce.enabled')) {
            try {
                $repository = SalesforceRepositoryFactory::get();
                $lead = $repository->lead()->getLead($user->email);
                if (! $lead) {
                    $body = null;
                    $body = [
                        'Chapter__c'              => $user->chapter,
                        'College__c'              => $user->school,
                        'Phone'                   => $user->phone,
                        'FirstName'               => $user->first_name,
                        'LastName'                => $user->last_name,
                        'Email'                   => $user->email,
                        'Company'                 => $user->school.(($user->school && $user->chapter) ? ' - ' : '').$user->chapter,
                        'Status'                  => 'Campaign Placed',
                        'Lead_Type__c'            => 'Member',
                        'LeadSource'              => get_utm_source(),
                        'Lead_Source_Raw__c'      => get_utm_raw(),
                        'UTM_Campaign_Medium__c'  => get_utm_medium(),
                        'UTM_Campaign_Content__c' => get_utm_content(),
                        'UTM_Campaign_Name__c'    => get_utm_campaign(),
                        'UTM_Campaign_Term__c'    => get_utm_term(),
                        'Sign_Up_Link__c'         => get_wizard_start_url(),
                        'Chapter_Size__c'         => chapter_member_count_text($request->get('members')),
                        'Position__c'             => chapter_position_text($request->get('position')),
                        'Contact__c'              => $user->sf_id ?? null,
                    ];
                    $repository->lead()->createLead(new SFLead($body));
                    Logger::logDebug('#Wizard '.$user->id.' information sent to #Salesforce');
                } else {
                    Logger::logDebug('#Wizard '.$user->id.' already has lead on #Salesforce');
                }
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#WorkWithUs SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#WorkWithUs '.$user->id.' information sent [SKIPPED] to #Salesforce');
        }

        if ($request->ajax()) {
            return response()->json([
                'auth'     => true,
                'intended' => $this->redirectPath(),
            ]);
        } else {
            return redirect($this->redirectPath());
        }
    }
}
