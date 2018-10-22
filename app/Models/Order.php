<?php

namespace App\Models;

use App\Logging\Logger;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

/**
 * @property integer                      $id
 * @property integer                      $user_id
 * @property integer                      $campaign_id
 * @property integer                      $cart_id
 * @property integer                      $quantity
 * @property float                        $subtotal
 * @property float                        $shipping
 * @property float                        $tax
 * @property float                        $total
 * @property string                       $state
 * @property string                       $state_details
 * @property string                       $contact_first_name
 * @property string                       $contact_last_name
 * @property string                       $contact_email
 * @property string                       $contact_phone
 * @property string                       $contact_chapter
 * @property string                       $contact_graduation_year
 * @property string                       $contact_school
 * @property string                       $shipping_line1
 * @property string                       $shipping_line2
 * @property string                       $shipping_city
 * @property string                       $shipping_state
 * @property string                       $shipping_zip_code
 * @property string                       $shipping_country
 * @property string                       $shipping_type
 * @property string                       $payment_type
 * @property string                       $billing_first_name
 * @property string                       $billing_last_name
 * @property string                       $billing_line1
 * @property string                       $billing_line2
 * @property string                       $billing_city
 * @property string                       $billing_state
 * @property string                       $billing_zip_code
 * @property string                       $billing_country
 * @property string                       $billing_provider
 * @property integer                      $billing_authorization_id
 * @property integer                      $billing_settlement_id
 * @property integer                      $billing_void_id
 * @property integer                      $billing_refund_id
 * @property string                       $billing_customer_id
 * @property string                       $billing_card_id
 * @property string                       $billing_charge_id
 * @property string                       $billing_details
 * @property string                       $tracking_code
 * @property boolean                      $receive_marketing
 * @property Carbon                       $created_at
 * @property Carbon                       $updated_at
 * @property Carbon                       $deleted_at
 * @property string                       $authorized_at
 * @property string                       $processed_at
 * @property integer                      $school_id
 * @property integer                      $chapter_id
 * @property-read User                    $user
 * @property-read Campaign                $campaign
 * @property-read Product                 $product
 * @property-read ProductColor            $color
 * @property-read Chapter                 $chapter
 * @property-read BillingTransaction      $transaction_authorize
 * @property-read BillingTransaction      $transaction_settlement
 * @property-read Collection|OrderEntry[] $entries
 * @mixin \Eloquent
 */
class Order extends Model
{
    use SoftDeletes;
    use DispatchesJobs;

    protected $table = 'orders';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['user', 'campaign', 'chapter', 'entries', 'billing_details'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction_authorize()
    {
        return $this->belongsTo(BillingTransaction::class, 'billing_authorization_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transaction_settlement()
    {
        return $this->belongsTo(BillingTransaction::class, 'billing_settlement_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(OrderEntry::class, 'order_id');
    }

    public static function boot()
    {
        parent::boot();

        Order::updated(function (Order $model) {
            if (! static::areEventsEnabled()) {
                return;
            }
            if (count($model->campaign->authorized_orders) > 0 && strtotime($model->campaign->close_date) - time() > 27 * 24 * 60 * 60) {
                $model->campaign->close_date = date('Y-m-d H:i:s', time() + 27 * 24 * 60 * 60);
                $model->campaign->save();
            }
        });
    }

    public function getContactFullName()
    {
        return getFullName($this->contact_first_name, $this->contact_last_name, $this->contact_email);
    }

    public function getShippingAddress()
    {
        if ($this->shipping_type == 'individual') {
            return (object) [
                'line1'    => $this->shipping_line1,
                'line2'    => $this->shipping_line2,
                'city'     => $this->shipping_city,
                'state'    => $this->shipping_state,
                'zip_code' => $this->shipping_zip_code,
                'country'  => $this->shipping_country,
            ];
        } else {
            return (object) [
                'line1'    => $this->campaign->address_line1,
                'line2'    => $this->campaign->address_line2,
                'city'     => $this->campaign->address_city,
                'state'    => $this->campaign->address_state,
                'zip_code' => $this->campaign->address_zip_code,
                'country'  => $this->campaign->address_country,
            ];
        }
    }

    public function getShippingName()
    {
        if ($this->shipping_type == 'individual') {
            return $this->getContactFullName();
        } else {
            return $this->campaign->getContactFullName();
        }
    }

    public function getTrackingCode()
    {
        if ($this->shipping_type == 'individual') {
            return $this->tracking_code;
        } else {
            return $this->campaign->tracking_code;
        }
    }

    public function getShippingEmail()
    {
        if ($this->shipping_type == 'individual') {
            return $this->contact_email;
        } else {
            return $this->campaign->contact_email;
        }
    }

    public function getShippingPhone()
    {
        if ($this->shipping_type == 'individual') {
            return $this->contact_phone.' '.$this->contact_phone;
        } else {
            return $this->campaign->contact_phone;
        }
    }

    public function setTrackingCode($trackingCode)
    {
        $this->tracking_code = $trackingCode;
        $this->save();
    }

    public function toContext()
    {
        return [
            'id' => $this->id,
        ];
    }

    public function track($eventName, $data = [])
    {
        $userContext = Auth::user() ? Auth::user()->toContext() : [];
        $campaignContext = $this->campaign->toContext();
        $orderContext = $this->toContext();
        Logger::track('orders', $this->id, $eventName, [], $userContext, $campaignContext, $this->toContext());
    }

    public function updateMetadata()
    {
        $this->load('entries');

        $subtotal = 0;
        $quantity = 0;
        $shipping = 0;
        foreach ($this->entries as $entry) {
            $quantity += $entry->quantity;
            $entrySubtotal = $entry->quantity * $entry->price;
            $subtotal += $entrySubtotal;
            $entry->update([
                'subtotal' => $entrySubtotal,
            ]);
        }

        if ($this->shipping_type != 'group') {
            $shipping = 7 + 2 * ($quantity - 1);
        }

        $tax = 0;

        $this->update([
            'subtotal' => $subtotal,
            'quantity' => $quantity,
            'shipping' => $shipping,
            'tax'      => 0,
            'total'    => $subtotal + $shipping + $tax,
        ]);
    }
}
