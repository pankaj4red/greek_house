<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $order_id
 * @property string  $x_response_code
 * @property string  $x_response_reason_code
 * @property string  $x_response_reason_text
 * @property string  $response_reason_text_displayed
 * @property string  $x_auth_code
 * @property string  $x_trans_id
 * @property string  $x_invoice_num
 * @property string  $x_description
 * @property string  $x_method
 * @property string  $x_amount
 * @property string  $x_tax
 * @property string  $x_type
 * @property string  $x_MD5_Hash
 * @property string  $x_cvv2_resp_code
 * @property Carbon  $created_at
 * @property Carbon  $updated_at
 * @mixin \Eloquent
 */
class Transaction extends Model
{
    protected $table = 'transactions';

    protected $guarded = [];

    protected $dates = [];

    protected $hidden = [];
}
