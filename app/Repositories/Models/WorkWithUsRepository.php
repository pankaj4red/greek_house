<?php

namespace App\Repositories\Models;

use App\Models\WorkWithUs;
use Illuminate\Support\Collection;

/**
 * @method WorkWithUs make()
 * @method Collection|WorkWithUs[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method WorkWithUs|null find($id)
 * @method WorkWithUs create(array $parameters = [])
 */
class WorkWithUsRepository extends ModelRepository
{
    protected $modelClassName = WorkWithUs::class;

    protected $rules = [
        'name'              => 'required|max:220',
        'email'             => 'required|email|unique:users|max:100',
        'phone'             => 'required|max:100',
        'school'            => 'required|max:100',
        'chapter'           => 'required|max:100',
        'position'          => 'required|max:100',
        'members'           => 'required|max:100',
        'are_you_ready'     => 'required:yes,no',
        'minimum_guarantee' => 'required:yes,no',
    ];
}
