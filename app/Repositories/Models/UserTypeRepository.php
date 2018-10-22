<?php

namespace App\Repositories\Models;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Collection;

/**
 * @method UserType make()
 * @method Collection|UserType[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method UserType|null find($id)
 * @method UserType create(array $parameters = [])
 */
class UserTypeRepository extends ModelRepository
{
    protected $modelClassName = UserType::class;

    /**
     * @param string $code
     * @return string
     */
    public function caption($code)
    {
        if ($code instanceof User) {
            $code = $code->type;
        }
        $type = $this->model->where('code', $code)->first();

        return $type ? $type->caption : 'N/A';
    }

    public function options($nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->model->orderBy('caption', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->code] = $entry->caption;
        }

        return $options;
    }

    public function getType($code)
    {
        $userType = $this->model->where('code', $code)->first();
        if ($userType) {
            return $userType->type;
        } else {
            return 'customer';
        }
    }
}
