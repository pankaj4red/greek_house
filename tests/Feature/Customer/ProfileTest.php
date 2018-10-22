<?php

namespace Tests\Feature\Customer;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserGenerator;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;
    
    /**
     * @test
     */
    public function can_see_profile_url()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Profile');
        $response->assertSee('/profile');
    }
    
    /**
     * @test
     */
    public function can_see_profile()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/profile');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSee('/profile/add-address');
        $response->assertSee('/profile/edit-information');
        $response->assertSee('/work-with-us/sales/' . $user->id);
        $response->assertSeeText($user->getFullName());
        $response->assertSeeText(get_phone($user->phone));
        $response->assertSeeText($user->email);
        $response->assertSeeText($user->chapter);
        foreach ($user->addresses as $address) {
            $response->assertSeeText($address->name);
            $response->assertSeeText($address->line1);
            $response->assertSeeText($address->line2);
            $response->assertSeeText($address->city);
            $response->assertSeeText($address->state);
            $response->assertSeeText($address->zip_code);
            $response->assertSee('/profile/edit-address/' . $address->id);
        }
    }
    
    /**
     * @test
     */
    public function can_open_information_form_for_regular_users()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/profile/edit-information');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Edit Profile Information');
        $response->assertSeeText('Save');
        $response->assertSee($user->first_name);
        $response->assertSee($user->last_name);
        $response->assertSee($user->phone);
        $response->assertSee($user->email);
        $response->assertSee($user->school);
        $response->assertSee($user->chapter);
        $response->assertDontSeeText('School Year');
        $response->assertDontSeeText('Venmo Username');
        $response->assertDontSeeText('Hourly Rate');
    }
    
    /**
     * @test
     */
    public function can_open_information_form_for_sales_users()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('sales_rep')->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/profile/edit-information');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Edit Profile Information');
        $response->assertSeeText('Save');
        $response->assertSee($user->first_name);
        $response->assertSee($user->last_name);
        $response->assertSee($user->phone);
        $response->assertSee($user->email);
        $response->assertSee($user->school);
        $response->assertSee($user->chapter);
        $response->assertSee((string)$user->school_year);
        $response->assertSee($user->venmo_username);
        $response->assertDontSeeText('Hourly Rate');
    }
    
    /**
     * @test
     */
    public function can_open_information_form_for_designers()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('designer')->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/profile/edit-information');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Edit Profile Information');
        $response->assertSeeText('Save');
        $response->assertSee($user->first_name);
        $response->assertSee($user->last_name);
        $response->assertSee($user->phone);
        $response->assertSee($user->email);
        $response->assertSee($user->school);
        $response->assertSee($user->chapter);
        $response->assertDontSeeText('School Year');
        $response->assertDontSeeText('Venmo Username');
        $response->assertSee((string)$user->hourly_rate);
    }
    
    /**
     * @test
     */
    public function can_submit_information_form()
    {
        $this->withoutExceptionHandling();
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create()->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->post('/profile/edit-information', array_merge([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'email'      => 'email@greekhouse.org',
            'phone'      => '(555) 555-5555',
            'school'     => 'Generic State College',
            'chapter'    => 'Sigma Alpha Zeta',
            'save'       => true,
            'graduation_year' => Carbon::now()->addYear(1)->format('Y'),
        ], $this->attachFile('avatar')));
        
        // Assert
        $response->assertRedirect('/profile');
        $response = $this->get('/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Profile Information Saved');
        $user = $user->fresh();
        $this->assertEquals('John', $user->first_name);
        $this->assertEquals('Doe', $user->last_name);
        $this->assertEquals('(555) 555-5555', $user->phone);
        $this->assertEquals('email@greekhouse.org', $user->email);
        $this->assertEquals('Generic State College', $user->school);
        $this->assertEquals('Sigma Alpha Zeta', $user->chapter);
    }
    
    /**
     * @test
     */
    public function can_open_add_address_form()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('designer')->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->get('/profile/add-address');
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('New Address');
        $response->assertSeeText('Save');
    }
    
    /**
     * @test
     */
    public function can_submit_add_address_form()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('designer')->withAddresses(3)->user();
        $this->be($user);
        
        // Execute
        $response = $this->post('/profile/add-address', [
            'name'     => 'Address Name',
            'line1'    => 'Address Line 1',
            'line2'    => 'Address Line 2',
            'city'     => 'Address City',
            'state'    => 'Address State',
            'zip_code' => '10000',
            'save'     => true,
        ]);
        
        // Assert
        $response->assertRedirect('/profile');
        $response = $this->get('/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Address Saved');
        $user = $user->fresh();
        $this->assertEquals(4, $user->addresses->count());
    }
    
    /**
     * @test
     */
    public function automatically_sets_shipping_address()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('designer')->user();
        $this->be($user);
        
        // Execute
        $response = $this->post('/profile/add-address', [
            'name'     => 'Address Name',
            'line1'    => 'Address Line 1',
            'line2'    => 'Address Line 2',
            'city'     => 'Address City',
            'state'    => 'Address State',
            'zip_code' => '10000',
            'save'     => true,
        ]);
        
        // Assert
        $response->assertRedirect('/profile');
        $user = $user->fresh();
        $this->assertEquals(1, $user->addresses->count());
        $this->assertNotNull($user->address_id);
    }
    
    /**
     * @test
     */
    public function can_open_edit_address_form()
    {
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('designer')->withAddresses(3)->user();
        $address = $user->addresses->first();
        $this->be($user);
        
        // Execute
        $response = $this->get('/profile/edit-address/' . $address->id);
        
        // Assert
        $response->assertStatus(200);
        $response->assertSeeText('Edit Address');
        $response->assertSeeText('Save');
        $response->assertSee($address->name);
        $response->assertSee($address->line1);
        $response->assertSee($address->line2);
        $response->assertSee($address->city);
        $response->assertSee($address->state);
        $response->assertSee($address->zip_code);
    }
    
    /**
     * @test
     */
    public function can_submit_edit_address_form()
    {
        $this->withoutExceptionHandling();
        // Prepare
        (new \TestingSeeder())->run();
        (new \ProductSeeder())->run();
        $user = UserGenerator::create('designer')->withAddresses(3)->user();
        $address = $user->addresses->first();
        $this->be($user);
        
        // Execute
        $response = $this->post('/profile/edit-address/' . $address->id, [
            'name'     => 'Address Name',
            'line1'    => 'Address Line 1',
            'line2'    => 'Address Line 2',
            'city'     => 'Address City',
            'state'    => 'Address State',
            'zip_code' => '10000',
            'save'     => true,
        ]);
        
        // Assert
        $response->assertRedirect('/profile');
        $response = $this->get('/profile');
        $response->assertStatus(200);
        $response->assertSeeText('Address Saved');
        $user = $user->fresh();
        $this->assertEquals(3, $user->addresses->count());
        $this->assertNotNull($user->address_id);
        $address = $address->fresh();
        $this->assertEquals('Address Name', $address->name);
        $this->assertEquals('Address Line 1', $address->line1);
        $this->assertEquals('Address Line 2', $address->line2);
        $this->assertEquals('Address City', $address->city);
        $this->assertEquals('Address State', $address->state);
        $this->assertEquals('10000', $address->zip_code);
    }
}