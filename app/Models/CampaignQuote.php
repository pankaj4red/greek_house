<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer       $id
 * @property integer       $campaign_id
 * @property integer       $product_id
 * @property float         $quote_low
 * @property float         $quote_high
 * @property float         $quote_final
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 * @property Carbon        $deleted_at
 * @property-read Campaign $campaign
 * @property-read Product  $product
 * @mixin \Eloquent
 */
class CampaignQuote extends Model
{
    protected $table = 'campaign_quotes';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['campaign', 'product'];

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
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
