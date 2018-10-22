<?php

namespace App\Models;

use Carbon\Carbon;

/**
 * @property string $email
 * @property string $token
 * @property Carbon $created_at
 * @property Carbon $deleted_at
 * @mixin \Eloquent
 */
class PasswordReset
{
    protected $table = 'password_resets';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = [];

    public $email;

    public $token;

    public $created_at;

    public $deleted_at;

    public function __construct($attributes)
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function save()
    {
        \DB::insert('INSERT INTO password_resets (email, token, created_at, deleted_at) VALUES (?, ?, ?, ?)', [
            $this->email,
            $this->token,
            $this->created_at ? $this->created_at : Carbon::now(),
            $this->deleted_at,
        ]);
    }
}
