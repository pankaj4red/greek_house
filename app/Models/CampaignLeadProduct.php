<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                                    $id
 * @property string                                     $campaign_lead_id
 * @property integer                                    $product_id
 * @property Carbon                                     $created_at
 * @property Carbon                                     $updated_at
 * @property Carbon                                     $deleted_at
 * @property-read Product                               $product
 * @property-read CampaignLead                          $campaign_lead
 * @property-read CampaignLeadProductColor[]|Collection $colors
 * @mixin \Eloquent
 */
class CampaignLeadProduct extends Model
{
    use SoftDeletes;

    protected $table = 'campaign_lead_products';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign_lead()
    {
        return $this->belongsTo(CampaignLead::class, 'campaign_lead_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function colors()
    {
        return $this->hasMany(CampaignLeadProductColor::class, 'campaign_lead_product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(Product::class, 'product_id')->withTrashed();
    }
}
