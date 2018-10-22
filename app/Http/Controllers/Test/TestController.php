<?php

namespace App\Http\Controllers\Test;

use App\Helpers\OnHold\OnHoldEngine;
use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Jobs\TestJob;
use App\Services\HubSpot;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;

class TestController extends Controller
{
    use DispatchesJobs;

    public function error()
    {
        throw new \Exception('woot');
    }

    public function block($id, $blockName, Request $request)
    {
        $blockClass = '\\App\\Http\\Controllers\\Customer\\Blocks\\'.$blockName;
        $block = \App::make($blockClass);
        $block->configure($id, array_merge($request->all(), ['view' => true, 'edit' => true]), []);

        return $block->block($id, $request);
    }

    public function showReport()
    {
        $this->dispatch(new SendEmailJob('sendLogReport', []));
    }

    public function showAlert()
    {
        $record = [
            'level'   => 'ALERT',
            'channel' => 'production',
            'message' => '#Campaign does #notexist',
            'extra'   => [
                'user_id'  => 23423,
                'username' => 'alex',
                'ip'       => '123.123.123.123',
            ],
            'context' => [
                'random context' => 'random',
                'request'        => ['id' => 1, 'pass' => 'no pass'],
                'session'        => \Session::all(),
                'method'         => 'App\Model\User::getRole',
                'args'           => ['vip'],
                'stack'          => call_stack_print(debug_backtrace()),
            ],
        ];
        $this->dispatch(new SendEmailJob('sendErrorAlert', [$record]));
    }

    public function sendEmail($ruleName, $campaignId)
    {
        $campaign = campaign_repository()->find($campaignId);
        $campaign->user->notify(OnHoldEngine::getRule($ruleName)->getNotification($campaign));
    }

    public function job()
    {
        $this->dispatch(new TestJob());
        echo 'ok';
    }

    public function getTest()
    {
        return view('v3.test.index');
    }

    public function postTest(Request $request)
    {
        try {
            $hubspot = new HubSpot();
            $forms = $hubspot->getForms();
            dd($forms);

//            $hubspot = new HubSpot();
//            $response = $hubspot->submitForm(config('services.hubspot.api.forms.work_with_us'), [
//                'first_name'          => 'Alexandre',
//                'last_name'           => 'Viseu',
//                'college'             => 'College',
//                'chapter'             => 'Chapter',
//                'email'               => 'alex@greekhouse.org',
//                'phone'               => '555-555-5555',
//                'position_in_chapter' => 'none',
//                'number_of_members'   => 24,
//                'hs_context' => [
//                    'hutk' => $_COOKIE['hubspotutk'],
//                ]
//            ]);

        } catch (\Exception $ex) {
            dd($ex);
        }
    }
}
