<?php

namespace App\Http\Controllers\Home;

use App;
use App\Exceptions\HubSpotException;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFLead;
use App\Services\HubSpot;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Session;

class WorkWithUsController extends Controller
{
    /**
     * @param string  $mode
     * @param integer $id
     * @return array
     */
    function getModeId($mode, $id)
    {
        if ($mode == null || ! in_array($mode, ['sales', 'campus'])) {
            return ['sales', null];
        }

        if (in_array($mode, ['campus']) && ! $id) {
            return ['sales', null];
        }

        if (in_array($mode, ['campus']) && ! $id) {
            return ['sales', null];
        }

        if (in_array($mode, ['campus'])) {
            $user = user_repository()->find($id);
            if (! $user || ! $user->isType('account_manager')) {
                return ['sales', null];
            }
        }
        if (in_array($mode, ['sales'])) {
            if ($id) {
                if (! user_repository()->find($id)) {
                    return ['sales', null];
                }
            }
        }

        return [$mode, $id];
    }

    /**
     * @param null $mode
     * @param null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex($mode = null, $id = null)
    {
        list($mode, $id) = $this->getModeId($mode, $id);

        return view('v2.home.work_with_us.index', [
            'mode' => $mode,
            'id'   => $id,
        ]);
    }

    /**
     * @param Request      $request
     * @param string|null  $mode
     * @param integer|null $id
     * @return App\Helpers\FormHandler|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function postIndex(Request $request, $mode = null, $id = null)
    {
        list($mode, $id) = $this->getModeId($mode, $id);
        $validator = work_with_us_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }

        $names = first_last_name($request->get('name'));

        $this->saveLead($request);

        // If the user created an account then sign up
        if (($request->get('members') == 24 && $request->get('minimum_guarantee') == 'yes') || $request->get('members') > 24) {
            $userData = [];
            $userData['first_name'] = $names->first;
            $userData['last_name'] = $names->last;
            $userData['email'] = $request->get('username');
            $userData['password'] = $request->get('password');
            $userData['chapter'] = $request->get('chapter');
            $user = App::make(App\Http\Controllers\Auth\RegisterController::class)->publicCreate($userData);
            \Auth::login($user);
        }

        Session::put('chapter-size', $request->get('members'));

        switch ($request->get('members')) {
            case 1:
                return form()->route('work_with_us::thank_you', [$mode, $id]);
            /** @noinspection PhpMissingBreakStatementInspection */
            case 24:
                if ($request->get('minimum_guarantee') == 'no') {
                    return form()->route('work_with_us::thank_you', [$mode, $id]);
                }
            // If minimum_guarantee == 'yes' then process it like everything else
            default:
                return $request->get('are_you_ready') == 'yes' ? form()->route('work_with_us::thank_you_ready', [$mode, $id]) : form()->route('work_with_us::thank_you_not_ready', [$mode, $id]);
        }
    }

    /**
     * @param Request     $request
     * @param string|null $mode
     * @param string|null $id
     * @return App\Helpers\FormHandler|\Illuminate\Http\JsonResponse
     */
    public function saveWorkWithUsLead(Request $request, $mode = null, $id = null)
    {
        $validator = work_with_us_repository()->validate($request);
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        } else {
            $this->saveLead($request);

            return response()->json([
                'success' => true,
                'message' => '',
            ]);
        }
    }

    /**
     * @param Request $request
     * @param null    $mode
     * @param null    $id
     * @return string|null
     */
    private function saveLead(Request $request, $mode = null, $id = null)
    {
        if (Session::get('wwu-lead')) {
            $lead = Session::get('wwu-lead');

            // Avoid duplicated
            if ($lead->Email == $request->get('email')) {
                return null;
            }
        }

        // Save the work with us form submission
        $model = work_with_us_repository()->create([
            'name'              => $request->get('name'),
            'email'             => $request->get('email'),
            'school'            => $request->get('school'),
            'chapter'           => $request->get('chapter'),
            'position'          => $request->get('position'),
            'size'              => $request->get('members'),
            'are_you_ready'     => $request->get('are_you_ready'),
            'minimum_guarantee' => $request->get('minimum_guarantee'),
        ]);

        // Send notifications
        try {
            $data = [
                'name'             => $request->get('name'),
                'chapter'          => $request->get('chapter'),
                'email'            => $request->get('email'),
                'chapter_position' => $request->get('position'),
                'phone'            => $request->get('phone'),
                'member_count'     => $request->get('members'),
                'school'           => $request->get('school'),
                'are_you_ready'    => $request->get('are_you_ready'),
            ];
            $this->dispatch(new SendEmailJob('workWithUs', [$data]));
        } catch (\Exception $ex) {
            Logger::logError($ex->getMessage(), ['exception' => $ex]);
        }

        $names = first_last_name($request->get('name'));

        // Integrate lead creation with salesforce
        if (config('services.salesforce.enabled')) {
            $body = null;
            try {
                $body = [
                    'Chapter__c'                         => $request->get('chapter'),
                    'Chapter_Size__c'                    => chapter_member_count_text($request->get('members')),
                    'College__c'                         => $request->get('school'),
                    'Position__c'                        => chapter_position_text($request->get('position')),
                    'Phone'                              => $request->get('phone'),
                    'FirstName'                          => $names->first,
                    'LastName'                           => $names->last,
                    'Email'                              => $request->get('email'),
                    'Company'                            => $request->get('school').' - '.$request->get('chapter'),
                    'Status'                             => 'Open',
                    'Lead_Type__c'                       => 'Member',
                    'LeadSource'                         => get_utm_source(),
                    'Lead_Source_Raw__c'                 => get_utm_raw(),
                    'UTM_Campaign_Medium__c'             => get_utm_medium(),
                    'UTM_Campaign_Content__c'            => get_utm_content(),
                    'UTM_Campaign_Name__c'               => get_utm_campaign(),
                    'UTM_Campaign_Term__c'               => get_utm_term(),
                    'Sign_Up_Link__c'                    => $request->fullUrl(),
                    'Ready_to_place_a_design_request__c' => $request->get('are_you_ready') == 'yes' ? 'Yes' : 'No',
                    'GCLID__c'                           => Session::get('gclid'),
                ];

                if ($mode == 'campus') {
                    $user = user_repository()->find($id);
                    if (! $user) {
                        return 'Unknown User';
                    }
                    $body['Campus_Manager_ID__c'] = $user->id;
                    $body['Campus_Manager__c'] = $user->getFullName(true);
                    $body['Referred_By__c'] = $user->getFullName(true);
                    $body['Lead_Type__c'] = 'Member';
                    $body['CM_Signup_Link__c'] = route('work_with_us::index', ['campus', $user->id]);
                    $body['Referred_Id__c'] = $user->id;
                }

                $user = null;
                if ($mode == 'sales' && $id !== null) {
                    $user = user_repository()->find($id);
                    if (! $user) {
                        return 'Unknown User';
                    }
                    $body['Referred_By__c'] = $user->getFullName(true);
                    $body['Referred_Id__c'] = $user->id;
                    $body['Lead_Type__c'] = 'Referral';
                }

                $repository = SalesforceRepositoryFactory::get();
                $lead = $repository->lead()->createLead(new SFLead($body));
                if ($user) {
                    $user->update([
                        'sf_id' => $lead->Id,
                    ]);
                }

                Session::put('wwu-lead', $lead);
                Logger::logDebug('#WorkWithUs '.$model->id.' information sent to #Salesforce');
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#WorkWithUs SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#WorkWithUs '.$model->id.' information sent [SKIPPED] to #Salesforce');
        }

        // Integrate with hubspot
        if (config('services.hubspot.api.enabled')) {
            try {
                $hubspot = new HubSpot();
                $hubspot->submitForm(config('services.hubspot.api.forms.work_with_us'), [
                    'firstname'                 => $names->first,
                    'lastname'                  => $names->last,
                    'college_university_c_1__c' => $request->get('school'),
                    'chapter__c'                => $request->get('chapter'),
                    'email'                     => $request->get('email'),
                    'phone'                     => $request->get('phone'),
                    'chapter_size__c'           => chapter_member_count_text($request->get('members')),
                    'company'                   => $request->get('school').' - '.$request->get('chapter'),
                    'hs_context'                => json_encode([
                        'hutk'      => Session::get('gclid'),
                        'ipAddress' => $request->ip(),
                        'pageUrl'   => $request->fullUrl(),
                        'pageName'  => 'Work With Us',
                    ]),
                ]);
            } catch (HubSpotException $ex) {
                Logger::logError('#WorkWithUs HUBSPOT: '.$ex->getMessage(), ['exception' => $ex]);
            }
        }

        return null;
    }

    /**
     * @param string|null  $mode
     * @param integer|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSchedule($mode = null, $id = null)
    {
        return view('v2.home.work_with_us.schedule');
    }

    /**
     * @param string|null  $mode
     * @param integer|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getThankYou($mode = null, $id = null)
    {
        list($mode, $id) = $this->getModeId($mode, $id);

        return view('v2.home.work_with_us.thank_you', [$mode, $id]);
    }

    /**
     * @param string|null  $mode
     * @param integer|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getThankYouReady($mode = null, $id = null)
    {
        list($mode, $id) = $this->getModeId($mode, $id);

        return view('v2.home.work_with_us.thank_you_ready', ['mode' => $mode, 'chapterSize' => Session::get('chapter-size'), 'id' => $id]);
    }

    /**
     * @param string|null  $mode
     * @param integer|null $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getThankYouNotReady($mode = null, $id = null)
    {
        list($mode, $id) = $this->getModeId($mode, $id);

        return view('v2.home.work_with_us.thank_you_howto_start', ['mode' => $mode, 'chapterSize' => Session::get('chapter-size'), 'id' => $id]);
    }

    /**
     * @param Request      $request
     * @param string|null  $mode
     * @param integer|null $id
     * @return App\Helpers\FormHandler|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function postThankYouNotReady(Request $request, $mode = null, $id = null)
    {
        $validator = $this->SFUpdateValidator($request->all());
        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }
        $userId = \Auth::user() ? \Auth::user()->id : null;
        if (empty($userId)) {
            return form()->error('Unknown User')->route('work_with_us::thank_you_not_ready', ['sales']);
        }
        $user = user_repository()->find($userId);
        if (! $user) {
            return form()->error('Unknown User')->route('work_with_us::thank_you_not_ready', ['sales']);
        }
        list($mode, $id) = $this->getModeId($mode, $id);
        if (config('services.salesforce.enabled')) {
            $body = null;
            try {
                $repository = SalesforceRepositoryFactory::get();
                $lead = $repository->lead()->getLead($user->email);

                $body = [
                    'Follow_Up_Date__c' => $request->get('followup_date') ? Carbon::parse($request->get('followup_date'))->format('Y-m-d') : null,
                    'Notes__c'          => $request->get('followup_event'),
                ];
                $repository->lead()->updateLead($lead->Id, $body);

                Logger::logDebug('#Follow Up '.$user->id.' information sent to #Salesforce');
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#Follow Up SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#Follow Up '.$user->id.' information sent [SKIPPED] to #Salesforce');
        }

        return view('v2.home.work_with_us.welcome_howto_start', ['mode' => $mode, 'chapterSize' => Session::get('chapter-size'), 'id' => $id]);
    }

    /**
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator|\Illuminate\Validation\Validator
     */
    protected function SFUpdateValidator(array $data)
    {
        return Validator::make($data, [
            'followup_date'  => 'required|date',
            'followup_event' => 'required',
        ]);
    }
}
