<?php

namespace App\Repositories\Models;

use App\Models\ChapterOrganization;
use Illuminate\Support\Collection;

/**
 * @method ChapterOrganization make()
 * @method Collection|ChapterOrganization[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method ChapterOrganization|null find($id)
 * @method ChapterOrganization create(array $parameters = [])
 */
class ChapterOrganizationRepository extends ModelRepository
{
    protected $modelClassName = ChapterOrganization::class;

    /**
     * @param string $name
     * @return ChapterOrganization|null
     */
    public function findByName($name)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->model->newQuery()->where('name', $name)->first();
    }

    /**
     * Returns a null option for the chapter organization
     *
     * @return ChapterOrganization
     */
    public function default()
    {
        return new CHapterOrganization([
            'name'    => 'Other Organization',
            'acronym' => 'Other',
            'segment' => 'Other',
        ]);
    }

    /**
     * @param string $text
     * @return Collection|ChapterOrganization[]
     */
    public function getAutocomplete($text)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->model->newQuery()->where('name', 'like', '%'.$text.'$')->take(10)->get();
    }

    /**
     * @param array $nullOption
     * @return string[]
     */
    public function options($nullOption)
    {
        $options = $nullOption;
        $entries = $this->model->orderBy('name', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->name] = $entry->name;
        }

        return $options;
    }
}
