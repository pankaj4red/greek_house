<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer   $id
 * @property integer   $user_id
 * @property string    $name
 * @property string    $line1
 * @property string    $line2
 * @property string    $city
 * @property string    $state
 * @property string    $zip_code
 * @property string    $country
 * @property Carbon    $created_at
 * @property Carbon    $updated_at
 * @property Carbon    $deleted_at
 * @property-read User $user
 * @mixin \Eloquent
 */
class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['user'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
