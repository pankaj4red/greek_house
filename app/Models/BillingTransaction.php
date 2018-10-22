<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer    $id
 * @property integer    $order_id
 * @property string     $action
 * @property float      $amount
 * @property string     $result
 * @property string     $message
 * @property string     $billing_provider
 * @property string     $billing_customer_id
 * @property integer    $billing_payment_method
 * @property string     $billing_payment_method_id
 * @property string     $billing_details
 * @property Carbon     $created_at
 * @property Carbon     $updated_at
 * @property Carbon     $deleted_at
 * @property-read Order $order
 * @mixin \Eloquent
 */
class BillingTransaction extends Model
{
    protected $table = 'billing_transactions';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
