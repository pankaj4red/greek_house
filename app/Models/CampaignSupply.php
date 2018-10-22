<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                               $id
 * @property integer                               $supplier_id
 * @property integer                               $campaign_id
 * @property integer                               $product_color_id
 * @property integer                               $color_id
 * @property integer                               $quantity
 * @property float                                 $total
 * @property string                                $ship_from
 * @property string                                $eta
 * @property string                                $state
 * @property string                                $nok_reason
 * @property Carbon                                $created_at
 * @property Carbon                                $updated_at
 * @property Carbon                                $deleted_at
 * @property-read Supplier                         $supplier
 * @property-read Campaign                         $campaign
 * @property-read Product                          $product
 * @property-read ProductColor                     $color
 * @property-read Collection|CampaignSupplyEntry[] $entries
 * @mixin \Eloquent
 */
class CampaignSupply extends Model
{
    use SoftDeletes;

    protected $table = 'campaign_supplies';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['supplier', 'campaign', 'product', 'color', 'entries'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id');
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
    public function product_color()
    {
        return $this->belongsTo(ProductColor::class, 'product_color_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function color()
    {
        return $this->belongsTo(ProductColor::class, 'color_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function entries()
    {
        return $this->hasMany(CampaignSupplyEntry::class, 'campaign_supply_id');
    }
}
