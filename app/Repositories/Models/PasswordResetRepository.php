<?php

namespace App\Repositories\Models;

use App\Models\PasswordReset;
use Illuminate\Support\Collection;

/**
 * @method PasswordReset make()
 * @method Collection|PasswordReset[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method PasswordReset|null find($id)
 * @method PasswordReset create(array $parameters = [])
 */
class PasswordResetRepository
{
    public function getLastByEmail($email)
    {
        $result = \DB::table('password_resets')->where('email', $email)->whereNull('deleted_at')->orderBy('created_at', 'desc')->take(1)->first();
        if ($result !== null) {
            return new PasswordReset([
                'email'      => $result->email,
                'token'      => $result->token,
                'created_at' => $result->created_at,
                'deleted_at' => $result->deleted_at,
            ]);
        }

        return null;
    }
}
