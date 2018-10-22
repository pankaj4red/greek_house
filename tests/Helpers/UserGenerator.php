<?php

namespace Tests\Helpers;

use App\Models\Address;
use App\Models\Model;
use App\Models\User;

class UserGenerator
{
    /**
     * @var User $user
     */
    public $user;
    
    /**
     * @param User $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }
    
    /**
     * @param string|null $type
     * @param array       $attributes
     * @return UserGenerator
     */
    public static function create($type = null, $attributes = [])
    {
        Model::disableEvents();
        if ($type) {
            switch ($type) {
                case 'member':
                    $user = factory(User::class)->states($type)->create($attributes);
                    
                    return (new UserGenerator($user))->withAccountManager();
                case 'support':
                    $user = factory(User::class)->states('support')->create($attributes);
                    
                    return (new UserGenerator($user));
                case 'designer':
                    $user = factory(User::class)->states('designer')->create($attributes);
                    
                    return (new UserGenerator($user));
                case 'decorator':
                    $user = factory(User::class)->states('decorator')->create($attributes);
                    
                    return (new UserGenerator($user));
                case 'admin':
                    $user = factory(User::class)->states('admin')->create($attributes);
                    
                    return (new UserGenerator($user));
                case 'art_director':
                    $user = factory(User::class)->states('art_director')->create($attributes);
                    
                    return (new UserGenerator($user));
                case 'product_qa':
                    $user = factory(User::class)->states('product_qa')->create($attributes);
                    
                    return (new UserGenerator($user));
                case 'product_manager':
                    $user = factory(User::class)->states('product_manager')->create($attributes);
                    
                    return (new UserGenerator($user));
                
            }
            $user = factory(User::class)->states($type)->create($attributes);
        } else {
            $user = factory(User::class)->create($attributes);
        }
        
        Model::enableEvents();
        
        return new UserGenerator($user);
    }
    
    /**
     * @param int $addressCount
     * @return $this
     */
    public function withAddresses($addressCount)
    {
        $addresses = factory(Address::class, 3)->make();
        $this->user->addresses()->saveMany($addresses);
        $this->user->update([
            'address_id' => $addresses->first()->id,
        ]);
        
        return $this;
    }
    
    /**
     * @param User|null $accountManager
     * @return $this
     */
    public function withAccountManager($accountManager = null)
    {
        if ($accountManager) {
            $this->user->update([
                'account_manager_id' => $accountManager->id,
            ]);
        } else {
            $this->user->update([
                'account_manager_id' => factory(User::class)->states('account_manager')->create()->id,
            ]);
        }
        
        return $this;
    }
    
    /**
     * @return User $user
     */
    public function user()
    {
        return $this->user;
    }
}