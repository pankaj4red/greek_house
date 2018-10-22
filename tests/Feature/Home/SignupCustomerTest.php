<?php

namespace Tests\Feature\Home;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class SignupCustomerTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_signup()
    {
        // Execute
        $response = $this->get('/signup/customer/information');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Input Your Information');
    }
    
    /**
     * @test
     */
    public function can_see_tos()
    {
        // Execute
        $response = $this->get('/signup/customer/tos');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('Website Terms of Use');
    }
    
    /**
     * @test
     */
    public function can_submit_signup()
    {
        // Prepare
        (new \TestingSeeder())->run();
        
        // Execute
        $response = $this->post('/signup/customer/information', [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'email@greekhouse.org',
            'phone'                 => '(555) 555-5555',
            'school'                => 'Generic State College',
            'chapter'               => 'Sigma Alpha Zeta',
            'password'              => '123',
            'password_confirmation' => '123',
            'agree'                 => 'on',
        ]);
        
        // Assert
        $response->assertRedirect('/signup/customer/video');
        $this->assertCount(1, User::all());
        $response = $this->get('/signup/customer/video');
        $response->assertSee('Sign Up Successful!');
    }
    
    /**
     * @test
     */
    public function can_submit_signup_with_referral()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $user = UserGenerator::create('account_manager')->user();
    
        // Execute
        $response = $this->post('/signup/customer/information/' . $user->id, [
            'first_name'            => 'John',
            'last_name'             => 'Doe',
            'email'                 => 'email@greekhouse.org',
            'phone'                 => '(555) 555-5555',
            'school'                => 'Generic State College',
            'chapter'               => 'Sigma Alpha Zeta',
            'password'              => '123',
            'password_confirmation' => '123',
            'agree'                 => 'on',
        ]);
    
        // Assert
        $response->assertRedirect('/signup/customer/video');
        $this->assertCount(1, user_repository()->getMembers($user->id));
        $response = $this->get('/signup/customer/video');
        $response->assertSee('Sign Up Successful!');
    }
    
    /**
     * @test
     */
    public function can_skip_video()
    {
        // Prepare
        (new \TestingSeeder())->run();
        $this->be(UserGenerator::create()->user());
        $response = $this->get('/signup/customer/video');
        $response->assertStatus(200);
        $response->assertSee('/signup/customer/success');
        
        // Execute
        $response = $this->get('/signup/customer/success');
        
        // Assert
        $response->assertStatus(200);
    }
}