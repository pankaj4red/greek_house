<?php

namespace App\Repositories\Models;

use App\Models\SFContact;
use Illuminate\Support\Collection;

/**
 * @method SFContact make()
 * @method Collection|SFContact[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method SFContact|null find($id)
 * @method SFContact create(array $parameters = [])
 */
class SFContactRepository extends ModelRepository
{
    protected $modelClassName = SFContact::class;

    /**
     * @param string $id
     * @return SFContact
     */
    public function findBySfId($id)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->model->newQuery()->where('sf_id', $id)->first();
    }
}
