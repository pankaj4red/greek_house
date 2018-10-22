<?php
namespace Tests\Feature\Helpers;

use App\Helpers\OnHold\ActionNeededRule;
use App\Helpers\OnHold\BudgetRule;
use App\Helpers\OnHold\DuplicateRequestRule;
use App\Helpers\OnHold\ExpensiveProductRule;
use App\Helpers\OnHold\LowSuccessRateRule;
use App\Helpers\OnHold\NewCustomerRule;
use App\Helpers\OnHold\OnlyCancelledCampaignsRule;
use App\Helpers\OnHold\RejectedByDesignerGenericRule;
use App\Helpers\OnHold\RejectedByDesignerSpecificRule;
use App\Helpers\OnHold\TooManyDesignRequestsRule;
use App\Models\Campaign;
use App\Models\CampaignLead;
use App\Notifications\CampaignOnHold\OnHoldBudgetNotification;
use App\Notifications\CampaignOnHold\OnHoldDesignGenericNotification;
use App\Notifications\CampaignOnHold\OnHoldDesignSpecificNotification;
use App\Notifications\CampaignOnHold\OnHoldDuplicateNotification;
use App\Notifications\CampaignOnHold\OnHoldHighRiskNotification;
use App\Notifications\CampaignOnHold\OnHoldNewCustomerNotification;
use App\Notifications\CampaignOnHold\OnHoldProductNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\Helpers\CampaignGenerator;
use Tests\Helpers\CampaignLeadGenerator;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class OnHoldTest extends TestCase
{
    use RefreshDatabase;
    
    //TODO: tests
//    /**
//     * @test
//     */
//    public function can_not_match_any_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = factory(CampaignLead::class)->states('review')->create();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertNotEquals('on_hold', $campaign->state);
//    }
//
//    /**
//     * @test
//     */
//    public function rejected_by_designer_generic()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        $designer = UserGenerator::create('designer')->user();
//        $campaign = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
//        $this->be($designer);
//        $response = $this->get('/dashboard');
//
//        // Execute
//        $this->select('generic', 'reason');
//        $this->press('Reject');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('This campaign is now marked as rejected by you');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold',$campaign->state);
//        $this->assertEquals('design', $campaign->on_hold_category);
//        $this->assertEquals(RejectedByDesignerGenericRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldDesignGenericNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function rejected_by_designer_specific()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        $designer = UserGenerator::create('designer')->user();
//        $campaign = CampaignGenerator::create('awaiting_design')->withOwner($user)->campaign();
//        $this->be($designer);
//        $response = $this->get('/dashboard');
//
//        // Execute
//        $this->select('not_enough_information', 'reason');
//        $this->press('Reject');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('This campaign is now marked as rejected by you');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold',$campaign->state);
//        $this->assertEquals('design', $campaign->on_hold_category);
//        $this->assertEquals(RejectedByDesignerSpecificRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldDesignSpecificNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function action_needed_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('awaiting_approval')->withOwner($user)->campaign();
//        CampaignGenerator::create('collecting_payment')->withOwner($user)->campaign();
//        CampaignGenerator::create('collecting_payment')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = CampaignLeadGenerator::create('review')->campaignLead();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('action_needed', $campaign->on_hold_category);
//        $this->assertEquals(ActionNeededRule::class, $campaign->on_hold_rule);
//    }
//
//    /**
//     * @test
//     */
//    public function budget_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = CampaignLeadGenerator::create('review')->withExpensiveProduct()->campaignLead([
//            'budget' => 'yes',
//            'budget_range' => '<$14'
//        ]);
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('budget', $campaign->on_hold_category);
//        $this->assertEquals(BudgetRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldBudgetNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function duplicate_request_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('fulfillment_ready')->withOwner($user)->campaign(['name' => 'foobar']);
//        $this->be($user);
//        $campaignLead = factory(CampaignLead::class)->states('review')->create(['name' => 'foobar']);
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('duplicate', $campaign->on_hold_category);
//        $this->assertEquals(DuplicateRequestRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldDuplicateNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function expensive_product_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('delivered')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = CampaignLeadGenerator::create('review')->withExpensiveProduct()->campaignLead();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('product', $campaign->on_hold_category);
//        $this->assertEquals(ExpensiveProductRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldProductNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function low_success_rate_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('delivered')->withOwner($user)->campaign();
//        CampaignGenerator::create('cancelled')->withOwner($user)->campaign();
//        CampaignGenerator::create('cancelled')->withOwner($user)->campaign();
//        CampaignGenerator::create('cancelled')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = factory(CampaignLead::class)->states('review')->create();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('high_risk', $campaign->on_hold_category);
//        $this->assertEquals(LowSuccessRateRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldHighRiskNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function new_customer_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $campaignLead = factory(CampaignLead::class)->states('review')->create();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//        $this->type('email@greekhouse.org', 'email');
//        $this->type('123', 'password');
//        $this->type('123', 'password_confirmation');
//        $this->press('Save');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('new_customer', $campaign->on_hold_category);
//        $this->assertEquals(NewCustomerRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $campaign->user,
//            OnHoldNewCustomerNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function only_cancelled_campaigns_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('cancelled')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = factory(CampaignLead::class)->states('review')->create();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('high_risk', $campaign->on_hold_category);
//        $this->assertEquals(OnlyCancelledCampaignsRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldHighRiskNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
//
//    /**
//     * @test
//     */
//    public function too_many_design_requests_rule()
//    {
//        // Prepare
//        (new \TestingSeeder())->run();
//        (new \ProductSeeder())->run();
//        $user = UserGenerator::create()->user();
//        CampaignGenerator::create('awaiting_approval')->withOwner($user)->campaign();
//        CampaignGenerator::create('awaiting_approval')->withOwner($user)->campaign();
//        $this->be($user);
//        $campaignLead = factory(CampaignLead::class)->states('review')->create();
//        $this->withSession(['campaign_lead_id' => $campaignLead->id]);
//        $response = $this->get('/start-here-review');
//
//        // Execute
//        $this->check('agree');
//        $this->press('Submit Design Request');
//
//        // Assert
//        $response->assertStatus(200);
//        $response->assertSeeText('Your order has been submitted!');
//        $this->seePageIs('/start-here-success');
//        $campaign = Campaign::all()->last();
//        $this->assertEquals('on_hold', $campaign->state);
//        $this->assertEquals('high_risk', $campaign->on_hold_category);
//        $this->assertEquals(TooManyDesignRequestsRule::class, $campaign->on_hold_rule);
//        Notification::assertSentTo(
//            $user,
//            OnHoldHighRiskNotification::class,
//            function ($notification, $channels) use ($campaign) {
//                return $notification->campaign->id === $campaign->id;
//            }
//        );
//    }
}