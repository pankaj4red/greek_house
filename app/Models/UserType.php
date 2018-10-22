<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property string  $code
 * @property string  $caption
 * @property boolean $is_staff
 * @property boolean $is_admin
 * @property boolean $is_designer
 * @property boolean $is_support
 * @property boolean $is_decorator
 * @property boolean $can_see_full_names
 * @property boolean $can_see_all_campaigns
 * @property boolean $can_access_admin
 * @property boolean $sees_customer_quick_quote
 * @property boolean $sees_support_quick_quote
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class UserType extends Model
{
    protected $table = 'user_types';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];

    public function isCustomer()
    {
        return ! $this->isStaff();
    }

    public function isStaff()
    {
        return $this->is_staff;
    }

    public function isSupport()
    {
        return $this->is_support;
    }

    public function isDesigner()
    {
        return $this->is_designer;
    }

    public function isAdmin()
    {
        return $this->is_admin;
    }

    public function canSeeFullNames()
    {
        return $this->can_see_full_names;
    }

    public function seesSupportQuickQuote()
    {
        return $this->sees_support_quick_quote;
    }

    public function seesCustomerQuickQuote()
    {
        return $this->sees_customer_quick_quote;
    }
}
