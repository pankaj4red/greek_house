<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                 $id
 * @property integer                 $user_id
 * @property string                  $contact_first_name
 * @property string                  $contact_last_name
 * @property string                  $contact_email
 * @property string                  $contact_phone
 * @property string                  $contact_school
 * @property string                  $contact_chapter
 * @property string                  $contact_graduation_year
 * @property string                  $billing_line1
 * @property string                  $billing_line2
 * @property string                  $billing_city
 * @property string                  $billing_state
 * @property string                  $billing_zip_code
 * @property string                  $shipping_line1
 * @property string                  $shipping_line2
 * @property string                  $shipping_city
 * @property string                  $shipping_state
 * @property string                  $shipping_zip_code
 * @property string                  $shipping_type
 * @property string                  $payment_type
 * @property string                  $payment_method
 * @property string                  $payment_nonce
 * @property boolean                 $allow_marketing
 * @property string                  $state
 * @property string                  $billing_provider
 * @property string                  $billing_customer_id
 * @property Carbon                  $created_at
 * @property Carbon                  $updated_at
 * @property Carbon                  $deleted_at
 * @property-read Collection|Order[] $orders
 * @property-read \Illuminate\Database\Eloquent\Relations\BelongsTo|User $user
 * @mixin \Eloquent
 */
class Cart extends Model
{
    use SoftDeletes;

    protected $table = 'carts';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'cart_id')->orderBy('id');
    }

    /**
     * @return float|int
     */
    public function getSubtotal()
    {
        $subtotal = 0;
        foreach ($this->orders as $order) {
            $subtotal += $order->subtotal;
        }

        return $subtotal;
    }

    /**
     * @return float|int
     */
    public function getTax()
    {
        $tax = 0;
        foreach ($this->orders as $order) {
            $tax += $order->tax;
        }

        return $tax;
    }

    /**
     * @return float|int
     */
    public function getTotal()
    {
        $total = 0;
        foreach ($this->orders as $order) {
            $total += $order->total;
        }

        return $total;
    }

    /**
     * @return float|int
     */
    public function getTotalWithoutShipping()
    {
        $totalWithoutShipping = 0;
        foreach ($this->orders as $order) {
            $totalWithoutShipping += $order->total - $order->shipping;
        }

        return $totalWithoutShipping;
    }

    /**
     * @return float|int
     */
    public function getShipping()
    {
        $shipping = 0;
        foreach ($this->orders as $order) {
            $shipping += $order->shipping;
        }

        return $shipping;
    }

    /**
     * @param Campaign $campaign
     * @param array    $newEntries
     * @return bool
     */
    public function addProductColors($campaign, $newEntries)
    {
        $order = null;
        foreach ($this->orders as $cartOrder) {
            if ($cartOrder->campaign_id == $campaign->id) {
                $order = $cartOrder;
                break;
            }
        }

        if (! $order) {
            $order = $campaign->makeOrder();
            $order->cart_id = $this->id;
            $order->quantity = 0;
            $order->subtotal = 0;
            $order->tax = 0;
            $order->total = 0;
            $order->save();
        }

        foreach ($order->entries as $entry) {
            foreach ($newEntries as $newEntryIndex => $newEntry) {
                if ($newEntry->color_id == $entry->product_color_id && $newEntry->size_id == $entry->garment_size_id) {
                    $entry->update([
                        'quantity' => $entry->quantity + $newEntry->quantity,
                        'price'    => $newEntry->price,
                    ]);
                    unset($newEntries[$newEntryIndex]);
                    break;
                }
            }
        }

        foreach ($newEntries as $newEntryIndex => $newEntry) {
            $orderEntry = order_entry_repository()->create([
                'order_id'         => $order->id,
                'product_color_id' => $newEntry->color_id,
                'garment_size_id'  => $newEntry->size_id,
                'quantity'         => $newEntry->quantity,
                'price'            => $newEntry->price,
                'subtotal'         => $newEntry->price * $newEntry->quantity,
            ]);
        }

        $order->update([
            'cart_id' => $this->id,
        ]);
        $order->updateMetadata();

        return true;
    }

    /**
     * @param integer $orderEntryId
     * @return bool
     * @throws \Exception
     */
    public function removeOrderEntry($orderEntryId)
    {
        foreach ($this->orders as $order) {
            foreach ($order->entries as $entry) {
                if ($entry->id == $orderEntryId) {
                    $entry->delete();
                    $order->load('entries');

                    if ($order->entries->count() == 0) {
                        $order->delete();

                        return true;
                    }

                    $order->updateMetadata();

                    return true;
                }
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasProcessedOrders()
    {
        foreach ($this->orders as $order) {
            if ($order->state != 'new') {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function hasUnprocessedOrders()
    {
        foreach ($this->orders as $order) {
            if ($order->state == 'new') {
                return true;
            }
        }

        return false;
    }

    /**
     * @return bool
     */
    public function isEmpty()
    {
        return $this->orders->count() == 0;
    }

    /**
     * @return Cart
     */
    public function createCartWithUnprocessedOrders()
    {
        $cart = Cart::create();

        foreach ($this->orders as $order) {
            if ($order->state == 'new') {
                $order->update([
                    'cart_id' => $cart->id,
                ]);
            }
        }

        $this->load('orders');
        $cart->load('orders');

        return $cart;
    }
}
