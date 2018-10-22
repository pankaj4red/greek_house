<?php

namespace App\Helpers;

use App\Repositories\Models\ModelRepository;

class ModelCache extends Cache
{
    /**
     * The source repository
     *
     * @var ModelRepository
     */
    protected $repository;

    /**
     * ModelCache constructor.
     *
     * @param ModelRepository $repository
     */
    public function __construct(ModelRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Gets a model from cache.
     * If it doesn't exist, fetch it, put it on the cache and return it.
     *
     * @param string $id
     * @param string $methodOverride
     * @return \App\Models\Model|mixed|null
     */
    public function getOrFetch($id, $methodOverride = 'find')
    {
        $item = parent::get($id);

        if (! $item) {
            $item = $this->repository->$methodOverride($id);
            if ($item) {
                $this->put($id, $item);
            }
        }

        return $item;
    }
}