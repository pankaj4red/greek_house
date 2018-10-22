<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Logging\Logger;
use App\Repositories\Salesforce\SalesforceRepositoryFactory;
use App\Salesforce\SFLead;
use Illuminate\Http\Request;
use Validator;
use Session;

class AmbassadorController extends Controller
{
    public function getIndex(Request $request)
    {
        return view('v2.home.ambassador.index');
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

        $model = ambassador_repository()->create([
            'name'      => $request->get('name'),
            'email'     => $request->get('email'),
            'phone'     => $request->get('phone'),
            'school'    => $request->get('school'),
            'chapter'   => $request->get('chapter'),
            'position'  => $request->get('position'),
            'size'      => $request->get('members'),
            'instagram' => $request->get('instagram'),
        ]);

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
                    'Lead_Type__c'            => 'Campus Ambassador',
                    'Status'                  => 'Open',
                    'instagram__c'            => $request->get('instagram'),
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
                $repository->lead()->createLead(new SFLead($body));
                Logger::logDebug('#Ambassador '.$model->id.' information sent to #Salesforce');
            } catch (\BadMethodCallException $ex) {
                throw $ex;
            } catch (\Exception $ex) {
                Logger::logError('#Ambassador SF: '.$ex->getMessage(), ['exception' => $ex]);
            }
        } else {
            Logger::logDebug('#Ambassador '.$model->id.' information sent [SKIPPED] to #Salesforce');
        }

        if ($request->get('members') > 1) {
            return form()->route('ambassador::schedule');
        } else {
            return form()->route('ambassador::thank_you');
        }
    }

    public function getThankYou()
    {
        return view('v2.home.ambassador.thank_you');
    }

    public function getSchedule()
    {
        return view('v2.home.ambassador.schedule');
    }
}