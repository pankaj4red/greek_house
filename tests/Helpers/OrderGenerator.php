<?php

namespace Tests\Helpers;

use App\Models\Campaign;
use App\Models\Model;
use App\Models\Order;
use App\Models\OrderEntry;
use App\Models\User;

class OrderGenerator
{
    /**
     * @var Order $order
     */
    public $order;
    
    /**
     * @param Order $order
     */
    public function __construct($order)
    {
        $this->order = $order;
    }
    
    /**
     * @param null  $state
     * @param int   $campaignId
     * @param array $entries
     * @return OrderGenerator
     */
    public static function create($state = null, $campaignId, $entries = [])
    {
        Model::disableEvents();
        $actualState = $state;
        if (in_array($state, ['filled', 'filled_card', 'filled_manual', 'filled_test'])) {
            $actualState = 'new';
        }
        
        $order = factory(Order::class)->states($actualState)->create([
            'campaign_id' => $campaignId,
        ]);
        
        $data = [
            'shipping_type'      => 'group',
            'contact_first_name' => 'John',
            'contact_last_name'  => 'Doe',
            'contact_email'      => 'email@greekhouse.org',
            'contact_phone'      => '(555) 555-5555',
            'billing_line1'      => 'Line 1',
            'billing_line2'      => 'Line 2',
            'billing_city'       => 'City',
            'billing_state'      => 'State',
            'billing_zip_code'   => '10000',
        ];
        switch ($state) {
            case 'filled':
                $order->update($data);
                break;
            case 'filled_test':
                $order->update(array_merge($data, ['billing_provider' => 'test']));
                break;
            case 'filled_manual':
                $order->update(array_merge($data, ['billing_provider' => 'manual']));
                break;
            case 'filled_card':
                $order->update(array_merge($data, ['billing_provider' => 'card']));
                break;
        }
        
        static::attachEntries($order, $entries);
        
        $order = $order->fresh();
        $subtotal = 0;
        $quantity = 0;
        foreach ($order->entries as $entry) {
            $subtotal += $entry->subtotal;
            $quantity += $entry->quantity;
        }
        /** @var Order $order */
        $order->update([
            'quantity' => $quantity,
            'subtotal' => $subtotal,
            'tax'      => $subtotal * 0.065,
            'total'    => $subtotal * 1.065,
        ]);
        
        Model::enableEvents();
        
        return new OrderGenerator($order);
    }
    
    /**
     * @param $order
     * @param $entries
     * @return Campaign
     */
    public static function attachEntries($order, $entries)
    {
        foreach ($entries as $entry) {
            $sizeModel = garment_size_repository()->findByShort($entry->size);
            
            factory(OrderEntry::class)->create([
                'order_id'         => $order->id,
                'product_color_id' => $entry->product_color_id,
                'garment_size_id'  => $sizeModel->id,
                'quantity'         => $entry->quantity,
                'price'            => $order->campaign->quote_final ?? $order->campaign->quote_high,
                'subtotal'         => $entry->quantity * ($order->campaign->quote_final ?? $order->campaign->quote_high),
            ]);
        }
        
        return $order;
    }
    
    /**
     * @param User $user
     * @return $this
     */
    public function withOwner($user)
    {
        $this->order->update([
            'user_id' => $user ? $user->id : null,
        ]);
        
        return $this;
    }
    
    /**
     * @return Order $order
     */
    public function order()
    {
        return $this->order;
    }
}
