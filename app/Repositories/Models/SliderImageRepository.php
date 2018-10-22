<?php
/**
 * Created by PhpStorm.
 * User: LENOVO
 * Date: 7/6/2018
 * Time: 10:58 AM
 */

namespace App\Repositories\Models;

use App\Models\SliderImages;

class SliderImageRepository extends ModelRepository
{
    protected $modelClassName = SliderImages::class;

    protected $rules = [
        'image' => 'required|max:255',
        'url'   => 'required|max:255',

    ];

    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery();
        if ($orderBy) {
            $query->orderBy(\DB::raw("-`$orderBy`"), 'desc');
        }

        return $this->queryPaginate($query, $page, $pageSize);
    }
}