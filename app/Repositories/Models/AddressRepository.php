<?php

namespace App\Repositories\Models;

use App\Models\Address;
use Illuminate\Support\Collection;

/**
 * @method Address make()
 * @method Collection|Address[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Address|null find($id)
 * @method Address create(array $parameters = [])
 */
class AddressRepository extends ModelRepository
{
    protected $modelClassName = Address::class;

    protected $rules = [
        'name'     => 'required',
        'line1'    => 'required',
        'line2'    => '',
        'city'     => 'required',
        'state'    => 'required',
        'zip_code' => 'required|digits:5',
    ];
}
