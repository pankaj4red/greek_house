<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer           $id
 * @property string            $campaign_lead_product_id
 * @property integer           $color_id
 * @property Carbon            $created_at
 * @property Carbon            $updated_at
 * @property Carbon            $deleted_at
 * @property-read Product      $product
 * @property-read CampaignLead $campaign_lead
 * @mixin \Eloquent
 */
class CampaignLeadProductColor extends Model
{
    use SoftDeletes;

    protected $table = 'campaign_lead_product_colors';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign_lead_product()
    {
        return $this->belongsTo(CampaignLead::class, 'campaign_lead_product_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function color()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(ProductColor::class, 'color_id');
    }
}
