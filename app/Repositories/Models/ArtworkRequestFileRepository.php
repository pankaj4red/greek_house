<?php

namespace App\Repositories\Models;

use App\Models\ArtworkRequestFile;
use Illuminate\Support\Collection;

/**
 * @method ArtworkRequestFile make()
 * @method Collection|ArtworkRequestFile[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method ArtworkRequestFile|null find($id)
 * @method ArtworkRequestFile create(array $parameters = [])
 */
class ArtworkRequestFileRepository extends ModelRepository
{
    protected $modelClassName = ArtworkRequestFile::class;

    protected $rules = [];

    /**
     * @param integer      $artworkRequestId
     * @param string       $type
     * @param integer|null $productColorId
     * @param integer|null $sort
     * @return ArtworkRequestFile|null
     */
    public function findByArtworkRequestAndType($artworkRequestId, $type, $productColorId = null, $sort = null)
    {
        $query = $this->model->newQuery()->where('artwork_request_id', $artworkRequestId)->where('type', $type)->whereNull('deleted_at');
        if ($productColorId !== null) {
            $query->where('product_color_id', $productColorId);
        }
        if ($sort !== null) {
            $query->where('sort', $sort);
        }

        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $query->first();
    }
}
