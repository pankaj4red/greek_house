<?php

namespace Tests\Feature\Home;

use App\Models\WorkWithUs;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class WorkWithUsTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_work_with_us()
    {
        // Execute
        $response = $this->get('/work-with-us');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Join our House. Get Rewards.');
    }
    
    /**
     * @test
     */
    public function can_see_work_with_us_with_sales_rep_referral()
    {
        // Prepare
        $user = UserGenerator::create('sales_rep')->user();
        
        // Execute
        $response = $this->get('/work-with-us/sales/' . $user->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Join our House. Get Rewards.');
    }
    
    /**
     * @test
     */
    public function can_see_work_with_us_with_campus_referral()
    {
        // Prepare
        $user = UserGenerator::create('account_manager')->user();
        
        // Execute
        $response = $this->get('/work-with-us/sales/' . $user->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Join our House. Get Rewards.');
    }
    
    /**
     * @test
     */
    public function can_submit_work_with_us_with_schedule()
    {
        // Execute
        $response = $this->post('/work-with-us', [
            'name'              => 'John Doe',
            'chapter'           => 'Sigma Alpha Zeta',
            'email'             => 'fake@greekhouse.org',
            'position'          => 'tshirt_chair',
            'phone'             => '(555) 555-5555',
            'members'           => '51',
            'school'            => 'Generic State College',
            'are_you_ready'     => 'no',
            'minimum_guarantee' => 'yes',
        ]);
        
        // Assert
        $response->assertRedirect('/work-with-us/sales/schedule');
        $response = $this->get('/work-with-us/sales/schedule');
        $response->assertStatus(200);
        $response->assertSee('Schedule Your Welcome Call!');
    }
    
    /**
     * @test
     */
    public function can_submit_work_with_us_without_schedule()
    {
        // Execute
        $response = $this->post('/work-with-us/sales', [
            'name'              => 'John Doe',
            'chapter'           => 'Sigma Alpha Zeta',
            'email'             => 'fake@greekhouse.org',
            'position'          => 'tshirt_chair',
            'phone'             => '(555) 555-5555',
            'members'           => '51',
            'school'            => 'Generic State College',
            'are_you_ready'     => 'yes',
            'minimum_guarantee' => 'yes',
        ]);
        
        // Assert
        $response->assertRedirect('/work-with-us/sales/thank-you-ready');
        $response = $this->get('/work-with-us/sales/thank-you-ready');
        $response->assertStatus(200);
        $response->assertSee('Welcome to Greek House');
    }
    
    /**
     * @test
     * Note: If a referral is set then it should always redirect user to the schedule page.
     */
    public function can_submit_work_with_us_with_sales_rep_referral()
    {
        // Prepare
        $user = UserGenerator::create()->user();
        
        // Execute
        $response = $this->post('/work-with-us/sales/' . $user->id, [
            'name'              => 'John Doe',
            'chapter'           => 'Sigma Alpha Zeta',
            'email'             => 'fake@greekhouse.org',
            'position'          => 'tshirt_chair',
            'phone'             => '(555) 555-5555',
            'members'           => '51',
            'school'            => 'Generic State College',
            'are_you_ready'     => 'no',
            'minimum_guarantee' => 'yes',
        ]);
        
        // Assert
        $response->assertRedirect('/work-with-us/sales/schedule/' . $user->id);
        $response = $this->get('/work-with-us/sales/schedule/' . $user->id);
        $response->assertStatus(200);
        $response->assertSee('Schedule Your Welcome Call!');
    }
    
    /**
     * @test
     * Note: If a referral is set then it should always redirect user to the schedule page.
     */
    public function can_submit_work_with_us_with_campus_referral()
    {
        // Prepare
        $user = UserGenerator::create('account_manager')->user();
        
        // Execute
        $response = $this->post('/work-with-us/campus/' . $user->id, [
            'name'              => 'John Doe',
            'chapter'           => 'Sigma Alpha Zeta',
            'email'             => 'fake@greekhouse.org',
            'position'          => 'tshirt_chair',
            'phone'             => '(555) 555-5555',
            'members'           => '51',
            'school'            => 'Generic State College',
            'are_you_ready'     => 'no',
            'minimum_guarantee' => 'yes',
        ]);
        
        // Assert
        $response->assertRedirect('/work-with-us/campus/schedule/' . $user->id);
        $response = $this->get('/work-with-us/campus/schedule/' . $user->id);
        $response->assertStatus(200);
        $response->assertSee('Schedule Your Welcome Call!');
    }
    
    /**
     * @test
     */
    public function can_submit_work_with_us_sends_notifications()
    {
        // Execute
        $response = $this->post('/work-with-us/sales', [
            'name'              => 'John Doe',
            'chapter'           => 'Sigma Alpha Zeta',
            'email'             => 'fake@greekhouse.org',
            'position'          => 'tshirt_chair',
            'phone'             => '(555) 555-5555',
            'members'           => '51',
            'school'            => 'Generic State College',
            'are_you_ready'     => 'no',
            'minimum_guarantee' => 'yes',
        ]);
        
        // Assert
        $this->getMockedMailService()->shouldHaveReceived('workWithUs')->once();
        $this->assertCount(1, WorkWithUs::all());
    }
    
    /**
     * @test
     */
    public function handles_membership_url()
    {
        // Prepare
        $user = UserGenerator::create('account_manager')->user();
        
        // Execute
        $response = $this->get('/membership/campus/' . $user->id);
        
        // Assert
        $response->assertStatus(200);
    }
}