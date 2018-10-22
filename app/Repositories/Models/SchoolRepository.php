<?php

namespace App\Repositories\Models;

use App\Models\School;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method School make()
 * @method Collection|School[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method School|null find($id)
 * @method School create(array $parameters = [])
 */
class SchoolRepository extends ModelRepository
{
    protected $modelClassName = School::class;

    /**
     * @param string $name
     * @return School|null
     */
    public function findByName($name)
    {
        return $this->model->whereRaw('name = ?', [$name, $name])->first();
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|School[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery();
        /** @var Builder $query */
        if (isset($filters['filter_school']) && $filters['filter_school']) {
            $query = $query->whereRaw('name like ?', ['%'.$filters['filter_school'].'%']);
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param string $keywords
     * @return Collection|School[]|LengthAwarePaginator
     */
    public function autoComplete($keywords)
    {
        $query = $this->model->newQuery();
        /** @var Builder $query */
        $schoolKeywords = school_keywords($keywords);
        foreach ($schoolKeywords as $keyword) {
            $query->whereRaw("name like ?", ['%'.$keyword.'%']);
        }
        $replace = "replace(replace(replace(replace(replace(replace(name, ',', ''), ' of ', ' '), ' at ', ' '), ' in ', ' '), ' on ', ' '), '  ', ' ')";
        $selectRaw = "id, name, LENGTH(".$replace.") - LENGTH(REPLACE(".$replace.", ' ', '')) + 1 as words, 0 ";
        /** @noinspection PhpUnusedLocalVariableInspection */
        foreach ($schoolKeywords as $keyword) {
            $selectRaw .= ' + ';
            if (\App::environment() !== 'testing') {
                $selectRaw .= "case  when ? like concat('%', ".$replace.", '%') <> 0 then 1 else 0 end";
            } else {
                $selectRaw .= "case  when ? like '%' || ".$replace." || '%' <> 0 then 1 else 0 end";
            }
        }
        $selectRaw .= ' as score';
        $query->selectRaw($selectRaw, $schoolKeywords);

        return $query->orderBy('score', 'desc')->orderBy('words', 'asc')->orderBy('name', 'desc')->paginate(20);
    }
}
