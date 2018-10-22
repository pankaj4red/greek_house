<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read GarmentSize $size
 * @property integer          $id
 * @property integer          $campaign_supply_id
 * @property integer          $garment_size_id
 * @property integer          $quantity
 * @property float            $price
 * @property float            $subtotal
 * @property Carbon           $created_at
 * @property Carbon           $updated_at
 * @property Carbon           $deleted_at
 * @mixin \Eloquent
 */
class CampaignSupplyEntry extends Model
{
    use SoftDeletes;

    protected $table = 'campaign_supply_entries';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['size', 'supply'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function size()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(GarmentSize::class, 'garment_size_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supply()
    {
        return $this->belongsTo(CampaignSupply::class, 'campaign_supply_id');
    }
}
