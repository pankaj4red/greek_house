<?php

namespace App\Models;

use App\Logging\Logger;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Collection;

/**
 * @property integer                    $id
 * @property string                     $sf_id
 * @property string                     $username
 * @property string                     $first_name
 * @property string                     $last_name
 * @property string                     $phone
 * @property string                     $school
 * @property string                     $chapter
 * @property string                     $email
 * @property integer                    $address_id
 * @property string                     $password_old
 * @property string                     $password
 * @property string                     $type_code
 * @property integer                    $avatar_id
 * @property integer                    $avatar_thumbnail_id
 * @property string                     $billing_customer_id
 * @property string                     $billing_card_id
 * @property string                     $activation_code
 * @property boolean                    $active
 * @property float                      $hourly_rate
 * @property string                     $remember_token
 * @property string                     $last_login_at
 * @property string                     $school_year
 * @property string                     $venmo_username
 * @property integer                    $school_id
 * @property integer                    $chapter_id
 * @property string                     $graduation_year
 * @property integer                    $referred_by_id
 * @property integer                    $account_manager_id
 * @property string                     $decorator_status
 * @property boolean                    $decorator_screenprint_enabled
 * @property boolean                    $decorator_embroidery_enabled
 * @property string                     $on_hold_state
 * @property Carbon                     $created_at
 * @property Carbon                     $updated_at
 * @property Carbon                     $deleted_at
 * @property-read Collection|Address[]  $addresses
 * @property-read Address               $address
 * @property-read User                  $account_manager
 * @property-read File                  $avatar
 * @property-read UserType              $type
 * @property-read File                  $avatar_thumbnail
 * @property-read School                $school_account
 * @property-read Chapter               $chapter_account
 * @property-read Collection|Order[]    $orders
 * @property-read Collection|Campaign[] $campaigns
 * @property-read Collection|Campaign[] $designer_campaigns
 * @property-read Collection|Campaign[] $decorator_campaigns
 * @property-read Collection|User[]     $members
 * @property-read Collection|User[]     $users_referred
 * @property-read User                  $referred_by
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use SoftDeletes;
    use Notifiable;

    protected $table = 'users';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'password',
        'remember_token',
        'addresses',
        'address',
        'notifications',
        'avatar',
        'avatar_thumbnail',
        'orders',
        'campaigns',
        'account_manager',
        'members',
        'type',
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school_account()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter_account()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class, 'address_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar()
    {
        return $this->belongsTo(File::class, 'avatar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function avatar_thumbnail()
    {
        return $this->belongsTo(File::class, 'avatar_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function type()
    {
        return $this->fresh()->belongsTo(UserType::class, 'type_code', 'code');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function designer_campaigns()
    {
        return $this->hasManyThrough(Campaign::class, ArtworkRequest::class, 'designer_id', 'artwork_request_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function decorator_campaigns()
    {
        return $this->hasMany(Campaign::class, 'decorator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function account_manager()
    {
        return $this->belongsTo(User::class, 'account_manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(User::class, 'account_manager_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users_referred()
    {
        return $this->hasMany(User::class, 'referred_by_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function referred_by()
    {
        return $this->belongsTo(User::class, 'referred_by_id');
    }

    public function getFullName($forceFullName = false)
    {
        if ($forceFullName || (Auth::user() && Auth::user()->fresh()->type->canSeeFullNames())) {
            return getFullName($this->first_name, $this->last_name, $this->email);
        }

        return $this->first_name;
    }

    public function getAvatar()
    {
        if ($this->avatar_id) {
            return route('system::image', $this->avatar_thumbnail_id);
        } else {
            return static_asset('images/no-avatar.jpg');
        }
    }

    public function getAvatarLarge()
    {
        if ($this->avatar_id) {
            return route('system::image', $this->avatar_id);
        } else {
            return static_asset('images/no-avatar.jpg');
        }
    }

    public function getCampaignsPlacedCount()
    {
        try {
            $this->load('campaigns');

            return count($this->campaigns);
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information to ', ['exception' => $ex]);
        }

        return 0;
    }

    public function getCampaignsSuccessCount()
    {
        try {
            $this->load('campaigns');

            return campaign_repository()->getByUserId($this->id, ['printing', 'shipped', 'delivered'])->count();
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information', ['exception' => $ex]);
        }

        return 0;
    }

    public function getCampaignsCancelledCount()
    {
        try {
            $this->load('campaigns');

            return campaign_repository()->getByUserId($this->id, ['cancelled'])->count();
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information', ['exception' => $ex]);
        }

        return 0;
    }

    public function getCampaignRevenueSpentTotal()
    {
        try {
            return order_repository()->getRevenueSpentTotal($this->id);
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information', ['exception' => $ex]);
        }

        return 0;
    }

    public function getCampaignRevenueSpentMembersTotal()
    {
        try {
            if ($this->isType('account_manager')) {
                return order_repository()->getRevenueSpentMembersTotal($this->id);
            }
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information', ['exception' => $ex]);
        }

        return 0;
    }

    public function getCampaignQuantityTotal()
    {
        try {
            return order_repository()->getQuantityTotal($this->id);
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information', ['exception' => $ex]);
        }

        return 0;
    }

    public function getCampaignQuantityMembersTotal()
    {
        try {
            if ($this->isType('account_manager')) {
                return order_repository()->getQuantityMembersTotal($this->id);
            }
        } catch (\Exception $ex) {
            Logger::logError('Exception while sending user global information', ['exception' => $ex]);
        }

        return 0;
    }

    public function isType($type)
    {
        if (is_array($type)) {
            foreach ($type as $typeEntry) {
                if ($this->isType($typeEntry)) {
                    return true;
                }
            }

            return false;
        }
        if ($type == $this->type_code) {
            return true;
        }

        return false;
    }

    protected $viewCache = [];

    protected $viewDefault = [];

    public function hasView($campaignId, $view)
    {
        $views = $this->getViews($campaignId);

        return in_array($view, $views);
    }

    public function getViews($campaignId)
    {
        if (! array_key_exists($campaignId, $this->viewCache)) {
            $views = [];

            $campaign = campaign_repository()->find($campaignId);
            if ($campaign && $campaign->user_id == $this->id) {
                $views[] = 'customer';
            }
            /*
                        if ($campaign && $campaign->artwork_request->designer_id == $this->id && $this->type_code == 'junior_designer') {
                            $views[] = 'junior_designer';
                            $views[] = 'design_gallery';
                        }
            */
            switch ($this->type_code) {
                case 'admin':
                    $views[] = 'public';
                    if (! in_array('customer', $views)) {
                        $views[] = 'customer';
                    }
                    $views[] = 'director';
                    $views[] = 'designer';
                    $views[] = 'support';
                    $views[] = 'decorator';
                    $views[] = 'design_gallery';
                    break;
                case 'support':
                    $views[] = 'public';
                    $views[] = 'support';
                    $views[] = 'design_gallery';
                    break;
                case 'art_director':
                    $views[] = 'director';
                    $views[] = 'design_gallery';
                    break;
                case 'designer':
                    $views[] = 'designer';
                    break;
                case 'decorator':
                    $views[] = 'decorator';
                    break;
                case 'product_qa':
                case 'product_manager':
                case 'supplier':
                    $views[] = 'public';
                    break;
                case 'junior_designer':
                    $views[] = 'junior_designer';
                    $views[] = 'design_gallery';
                    break;
            }
            if ($this->isType('account_manager') && campaign_repository()->belongsToMember($campaignId, $this->id)) {
                $views[] = 'account_manager';
            }
            $this->viewCache[$campaignId] = sort_array($views, ['public', 'customer', 'director', 'designer', 'junior_designer', 'support', 'decorator', 'account_manager', 'design_gallery']);
        }

        return $this->viewCache[$campaignId];
    }

    public function getDefaultView($campaignId)
    {
        if (! array_key_exists($campaignId, $this->viewDefault)) {
            $default = 'customer';
            switch ($this->type) {
                case 'admin':
                case 'support':
                    $default = 'support';
                    break;
                case 'designer':
                    $default = 'designer';
                    break;
                case 'junior_designer':
                    $default = 'junior_designer';
                    break;
                case 'art_director':
                    $default = 'director';
                    break;
                case 'decorator':
                    $default = 'decorator';
                    break;
                case 'product_qa':
                case 'product_manager':
                case 'supplier':
                    $default = 'public';
                    break;
            }
            $this->viewDefault[$campaignId] = $default;
        }

        return $this->viewDefault[$campaignId];
    }

    public function hasSuccessfulCampaigns()
    {
        return user_repository()->hasSuccessfulCampaigns($this->id);
    }

    /**
     * @param int $id
     * @return boolean
     */
    public function hasCampaign($id)
    {
        $this->load('campaigns');
        foreach ($this->campaigns as $campaign) {
            if ($campaign->id == $id) {
                return true;
            }
        }

        return false;
    }

    public function toContext()
    {
        return [
            'id'       => $this->id,
            'username' => $this->username,
            'email'    => $this->email,
            'sf_id'    => $this->sf_id,
        ];
    }

    public function assignChapter()
    {
        $user = $this;
        $chapter = chapter_repository()->findBySchoolAndChapter($user->school, $this->chapter);

        if ($chapter) {
            $this->chapter_id = $chapter->id;
            $this->school_id = $chapter->school_id;
            $this->save();
        }
    }

    public function needsToWaitToComment()
    {
        return comment_repository()->isUserNeedingToWait($this->id);
    }

    public function getPlacedCampaigns()
    {
        return $this->campaigns->count();
    }

    public function getSuccessfulCampaigns()
    {
        $count = 0;
        foreach ($this->campaigns as $campaign) {
            if (in_array($campaign->state, ['fulfillment_ready', 'fulfillment_validation', 'printing', 'shipped', 'delivered'])) {
                $count++;
            }
        }

        return $count;
    }

    public function getCancelledCampaigns()
    {
        $count = 0;
        foreach ($this->campaigns as $campaign) {
            if (in_array($campaign->state, ['cancelled'])) {
                $count++;
            }
        }

        return $count;
    }

    public function getTotalDesignHours()
    {
        $total = 0;
        foreach ($this->campaigns as $campaign) {
            $total += $campaign->artwork_request->design_minutes;
        }

        return to_hours($total);
    }

    public function getAverageDesignHours()
    {
        $total = 0;
        $count = 0;
        foreach ($this->campaigns as $campaign) {
            $total += $campaign->artwork_request->design_minutes;
            $count++;
        }

        return $count ? to_hours(round($total / $count, 0)) : '0:00';
    }

    public function getAverageRevisions()
    {
        $total = 0;
        $count = 0;
        foreach ($this->campaigns as $campaign) {
            $total += $campaign->artwork_request->revision_count;
            $count++;
        }

        return $count ? round($total / $count, 2) : 0;
    }

    public function getTotalRevenue()
    {
        $total = 0;
        foreach ($this->campaigns as $campaign) {
            foreach ($campaign->success_orders as $order) {
                $total += $order->total;
            }
        }

        return $total;
    }

    public function getAverageRevenue()
    {
        $count = 0;
        $total = 0;
        foreach ($this->campaigns as $campaign) {
            if (in_array($campaign->state, ['fulfillment_ready', 'fulfillment_validation', 'printing', 'shipped', 'delivered'])) {
                $count++;
                foreach ($campaign->success_orders as $order) {
                    $total += $order->total;
                }
            }
        }

        return $count > 0 ? round($total / $count, 2) : 0;
    }

    public function getTotalQuantityOrdered()
    {
        $total = 0;
        foreach ($this->campaigns as $campaign) {
            if (in_array($campaign->state, ['fulfillment_ready', 'fulfillment_validation', 'printing', 'shipped', 'delivered'])) {
                foreach ($campaign->success_orders as $order) {
                    $total += $order->quantity;
                }
            }
        }

        return $total;
    }

    public function getAverageQuantityOrdered()
    {
        $count = 0;
        $total = 0;
        foreach ($this->campaigns as $campaign) {
            if (in_array($campaign->state, ['fulfillment_ready', 'fulfillment_validation', 'printing', 'shipped', 'delivered'])) {
                $count++;
                foreach ($campaign->success_orders as $order) {
                    $total += $order->quantity;
                }
            }
        }

        return $count ? round($total / $count, 0) : 0;
    }

    public function getReferralsSubmitted()
    {
        return $this->users_referred->count();
    }

    public function getReferralsSuccess()
    {
        $count = 0;
        foreach ($this->users_referred as $user) {
            foreach ($user->campaigns as $campaign) {
                if (in_array($campaign->state, ['fulfillment_ready', 'fulfillment_validation', 'printing', 'shipped', 'delivered'])) {
                    $count++;
                    break;
                }
            }
        }

        return $count;
    }
}
