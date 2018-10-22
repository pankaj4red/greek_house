<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property integer       $id
 * @property string        $channel
 * @property integer       $campaign_id
 * @property integer       $user_id
 * @property integer       $file_id
 * @property string        $body
 * @property string        $ip
 * @property Carbon        $created_at
 * @property Carbon        $updated_at
 * @property Carbon        $deleted_at
 * @property-read User     $user
 * @property-read Campaign $campaign
 * @property-read File     $file
 * @mixin \Eloquent
 */
class Comment extends Model
{
    use SoftDeletes;

    protected $table = 'comments';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['user', 'campaign', 'file'];

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
    public function file()
    {
        return $this->belongsTo(File::class, 'file_id');
    }
}
