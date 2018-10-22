<?php

namespace Tests\Feature\Home;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class SignupAccountManagerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_signup()
    {
        // Execute
        $response = $this->get('/signup/campus');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Input Your Information');
    }
    
    /**
     * @test
     */
    public function can_see_tos()
    {
        // Execute
        $response = $this->get('/signup/campus/tos');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Website Terms of Use');
    }
    
    /**
     * @test
     */
    public function can_submit_signup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        
        // Execute
        $response = $this->post('/signup/campus', [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'email@greekhouse.org',
            'phone'                 => '(555) 555-5555',
            'school'                => 'Generic State College',
            'chapter'               => 'Sigma Alpha Zeta',
            'venmo_username'        => 'venmo123',
            'password'              => '123',
            'password_confirmation' => '123',
            'agree'                 => 'on',
            'graduation_year'       => Carbon::now()->addYear(1)->format('Y'),
        ]);
        
        // Assert
        $response->assertRedirect('/signup/campus/contract');
        $this->assertCount(1, User::all());
        $response = $this->get('/signup/campus/contract');
        $response->assertSee('Sign Up Successful!');
    }
    
    /**
     * @test
     */
    public function can_accept_contract()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $this->be(UserGenerator::create('account_manager')->user());
        $response = $this->get('/signup/campus/contract');
        $response->assertStatus(200);
        $response->assertSee('/signup/campus/video');
        
        // Execute
        $response = $this->get('/signup/campus/video');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function can_skip_video()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $this->be(UserGenerator::create('account_manager')->user());
        $response = $this->get('/signup/campus/video');
        $response->assertStatus(200);
        $response->assertSee('/signup/campus/success');
        
        // Execute
        $response = $this->get('/signup/campus/success');
        
        // Assert
        $response->assertStatus(200);
    }
    
    /**
     * @test
     */
    public function short_hand_redirects()
    {
        // Execute
        $response = $this->get('/campus');
        
        // Assert
        $response->assertRedirect('/signup/campus');
    }
}