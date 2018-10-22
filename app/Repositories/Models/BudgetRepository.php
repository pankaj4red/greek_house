<?php

namespace App\Repositories\Models;

use App\Models\Budget;
use Illuminate\Support\Collection;

/**
 * @method Budget make()
 * @method Collection|Budget[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Budget|null find($id)
 * @method Budget create(array $parameters = [])
 */
class BudgetRepository extends ModelRepository
{
    protected $modelClassName = Budget::class;

    /**
     * @param string $code
     * @return string
     */
    public function caption($code)
    {
        $campaignState = $this->model->where('code', $code)->first();
        if ($campaignState == null) {
            return 'N/A';
        }

        return $campaignState->caption;
    }

    /**
     * @param string $code
     * @return array
     */
    public function range($code)
    {
        $campaignState = $this->model->where('code', $code)->first();
        if ($campaignState == null) {
            return ['N/A', 'N/A'];
        }

        return [$campaignState->from, $campaignState->to];
    }

    public function options($nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->model->orderBy('id', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->code] = $entry->caption;
        }

        return $options;
    }
}
