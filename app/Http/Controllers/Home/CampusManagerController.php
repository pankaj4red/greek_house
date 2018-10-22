<?php

namespace App\Http\Controllers\Home;

use App\Exceptions\HubSpotException;
use App\Http\Controllers\Controller;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFLead;
use App\Services\HubSpot;
use Illuminate\Http\Request;
use Validator;
use Session;

class CampusManagerController extends Controller
{
    public function getIndex(Request $request)
    {
        return view('v2.home.campus_manager.index');
    }

    public function postIndex(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email',
            'phone'     => 'required',
            'school'    => 'required',
            'chapter'   => 'required',
            'position'  => 'required',
            'members'   => 'required',
            'instagram' => 'nullable',
        ]);

        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }

        $names = first_last_name($request->get('name'));

        $model = campus_manager_repository()->create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'phone'     => $request->get('phone'),
            'school'    => $request->get('school'),
            'chapter'   => $request->get('chapter'),
            'position'  => $request->get('position'),
            'size'      => $request->get('members'),
            'instagram' => $request->get('instagram'),
        ]);

        session()->put('cm_id', $model->id);

        if (config('services.salesforce.enabled')) {
            $body = null;
            try {
                $body = [
                    'Chapter__c'              => $request->get('chapter'),
                    'Chapter_Size__c'         => chapter_member_count_text($request->get('members')),
                    'College__c'              => $request->get('school'),
                    'Position__c'             => chapter_position_text($request->get('position')),
                    'Phone'                   => $request->get('phone'),
                    'FirstName'               => $names->first,
                    'LastName'                => $names->last,
                    'Email'                   => $request->get('email'),
                    'Company'                 => $request->get('school').' - '.$request->get('chapter'),
                    'Lead_Type__c'            => 'Campus Manager',
                    'Status'                  => 'Open',
                    'Instagram__c'            => $request->get('instagram'),
                    'LeadSource'              => get_utm_source(),
                    'Lead_Source_Raw__c'      => get_utm_raw(),
                    'UTM_Campaign_Medium__c'  => get_utm_medium(),
                    'UTM_Campaign_Content__c' => get_utm_content(),
                    'UTM_Campaign_Name__c'    => get_utm_campaign(),
                    'UTM_Campaign_Term__c'    => get_utm_term(),
                    'Sign_Up_Link__c'         => $request->fullUrl(),
                    'GCLID__c'                => Session::get('gclid'),
                ];
                $repository = SalesforceRepositoryFactory::get();
                $lead = $repository->lead()->createLead(new SFLead($body));
                $model->update([
                    'sf_id' => $lead->Id,
                ]);
                Logger::logDebug('#CampusManager '.$model->id.' information sent to #Salesforce');
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#CampusManager SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#CampusManager '.$model->id.' information sent [SKIPPED] to #Salesforce');
        }

        if (config('services.hubspot.api.enabled')) {
            try {
                $hubspot = new HubSpot();
                $response = $hubspot->submitForm(config('services.hubspot.api.forms.campus_manager'), [
                    'email'                     => $request->get('email'),
                    'firstname'                 => $names->first,
                    'lastname'                  => $names->last,
                    'college_university_c_1__c' => $request->get('school'),
                    'chapter__c'                => $request->get('chapter'),
                    'phone'                     => $request->get('phone'),
                    'hs_context'                => json_encode([
                        'hutk'      => Session::get('gclid'),
                        'ipAddress' => $request->ip(),
                        'pageUrl'   => $request->fullUrl(),
                        'pageName'  => 'Campus Manager',
                    ]),
                ]);
            } catch (HubSpotException $ex) {
                Logger::logError('#CampusManager HUBSPOT: '.$ex->getMessage(), ['exception' => $ex]);
            }
        }

        return form()->route('campus_manager::application');
    }

    public function getApplication()
    {
        return view('v2.home.campus_manager.application');
    }

    public function postApplication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'year'        => 'required|max:255',
            'major'       => 'required|max:255',
            'positions'   => 'required|max:500',
            'description' => 'required|max:500',
            'top_brands'  => 'required|max:255',
        ]);

        if ($validator->fails()) {
            return form()->error($validator->errors())->back();
        }

        $data = [
            'year'        => $request->get('year'),
            'major'       => $request->get('major'),
            'positions'   => $request->get('positions'),
            'description' => $request->get('description'),
            'top_brands'  => $request->get('top_brands'),
        ];

        $cm = null;
        if (session()->get('cm_id')) {
            $cm = campus_manager_repository()->find(session()->get('cm_id'));
        }

        if ($cm) {
            $cm->update($data);
            $updated = true;
        } else {
            $cm = campus_manager_repository()->create($data);
        }

        if (config('services.salesforce.enabled') && $cm->sf_id) {
            $body = null;
            try {
                $body = [
                    'Year_in_College__c'                          => school_year_repository()->caption($request->get('year')),
                    'College_Major__c'                            => $request->get('major'),
                    'Involvement_On_Campus__c'                    => $request->get('positions'),
                    'Why_do_you_think_you_d_be_a_good_fit_for__c' => $request->get('description'),
                    'What_are_the_top_5_brands__c'                => $request->get('top_brands'),
                ];
                $repository = SalesforceRepositoryFactory::get();
                $repository->lead()->updateLead($cm->sf_id, $body);

                Logger::logDebug('#CampusManager '.$cm->id.' information sent to #Salesforce');
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#CampusManager SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#CampusManager '.$cm->id.' information sent [SKIPPED] to #Salesforce');
        }

        return form()->route('campus_manager::schedule');
    }

    public function getSchedule()
    {
        return view('v2.home.campus_manager.schedule');
    }
}