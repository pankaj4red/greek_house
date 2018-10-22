<?php

namespace App\Repositories\Models;

use App\Models\DesignTag;
use DB;
use Illuminate\Support\Collection;

/**
 * @method DesignTag make()
 * @method Collection|DesignTag[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method DesignTag|null find($id)
 * @method DesignTag create(array $parameters = [])
 */
class DesignTagRepository extends ModelRepository
{
    protected $modelClassName = DesignTag::class;

    protected $rules = [];

    /**
     * @param integer $designId
     * @param string  $group
     * @return \Illuminate\Database\Eloquent\Collection|DesignTag[]
     */
    public function getByDesignAndGroup($designId, $group)
    {
        return $this->model->newQuery()->where('design_id', $designId)->where('group', $group)->get();
    }

    public function createTagOnGroup($designId, $group, $tag)
    {
        return $this->model->create([
            'design_id' => $designId,
            'group'     => $group,
            'name'      => $tag,
        ]);
    }

    public function search($group, $tag, $page)
    {
        return $this->model->newQuery()->where('group', $group)->where('name', 'like', '%'.$tag.'%')->select(['name', 'group'])->distinct()->orderBy('name', 'asc')->take(30)->skip($page * 30)->get();
    }

    public function getTagJSONList($group = null)
    {
        $query = DB::table($this->model->getTable())->selectRaw('name, count(*)');
        if (is_array($group)) {
            $query->whereIn('group', $group);
        } elseif (is_string($group)) {
            $query->where('group', $group);
        }

        $tags = $query->groupBy('name')->orderBy('name', 'asc')->havingRaw('count(*) >= 1')->get();
        $list = [];
        foreach ($tags as $tag) {
            $list[] = ['id' => $tag->name, 'text' => $tag->name];
        }

        return $list;
    }
}
