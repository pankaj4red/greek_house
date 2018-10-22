<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                      $id
 * @property string                       $campaign_id
 * @property string                       $name
 * @property string                       $code
 * @property boolean                      $trending
 * @property string                       $status
 * @property integer                      $sort
 * @property integer                      $thumbnail_id
 * @property Carbon                       $created_at
 * @property Carbon                       $updated_at
 * @property Carbon                       $deleted_at
 * @property-read DesignFile[]|Collection $files
 * @property-read DesignFile[]|Collection $images
 * @property-read DesignFile[]|Collection $enabled_images
 * @property-read DesignTag[]|Collection  $tags
 * @property-read File                    $thumbnail
 * @property-read Campaign                $campaign
 * @mixin \Eloquent
 */
class Design extends Model
{
    use SoftDeletes;

    protected $table = 'designs';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['files', 'thumbnail'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(DesignFile::class, 'design_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function images()
    {
        return $this->hasMany(DesignFile::class, 'design_id')->where('type', 'image')->orderBy('sort', 'asc')->orderBy('id', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function enabled_images()
    {
        return $this->hasMany(DesignFile::class, 'design_id')->where('type', 'image')->where('enabled', true)->orderBy('sort', 'asc')->orderBy('id', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tags()
    {
        return $this->hasMany(DesignTag::class, 'design_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thumbnail()
    {
        return $this->belongsTo(File::class, 'thumbnail_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class, 'campaign_id');
    }

    /**
     * @param string $group
     * @return DesignTag[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getTags($group)
    {
        return design_tag_repository()->getByDesignAndGroup($this->id, $group);
    }

    public function getInfo()
    {
        $images = [];
        foreach ($this->enabled_images as $image) {
            $images[] = route('system::image', [get_image_id($image->file_id, true)]);
        }

        return json_encode([
            'id'        => $this->id,
            'name'      => $this->name,
            'code'      => $this->code,
            'download'  => $this->enabled_images->count() > 0 ? route('system::image_download', [get_image_id($this->enabled_images->first()->file_id, true)]) : null,
            'thumbnail' => route('system::image', [get_image_id($this->getThumbnail(), true)]),
            'images'    => $images,
        ]);
    }

    public function getInfoRelated()
    {
        $related = $this->getRelated();
        foreach ($related as $key => $design) {
            $related[$key] = [
                'id'        => $design->id,
                'name'      => $design->name,
                'url'       => route('home::design_gallery', [$design->id]),
                'thumbnail' => route('system::image', [get_image_id($this->getThumbnail(), true)]),
            ];
        }

        return [
            'related' => $related,
        ];
    }

    /**
     * @return Collection|Design[]
     */
    public function getRelated()
    {
        return design_repository()->getRelated($this);
    }

    /**
     * @param string[] $searchTags
     * @return int
     */
    public function getTagScore($searchTags)
    {
        $score = 0;
        $modelTags = [];
        foreach ($this->tags as $modelTag) {
            $modelTags[] = $modelTag->name;
        }

        // First pass: 3pt
        foreach ($modelTags as $modelIndex => $modelTag) {
            foreach ($searchTags as $searchTag) {
                if (mb_strtolower($modelTag) == mb_strtolower($searchTag)) {
                    $score += 3;
                    array_forget($modelTags, $modelIndex);
                    break;
                }
            }
        }

        // First pass: 1pt
        foreach ($modelTags as $modelIndex => $modelTag) {
            foreach ($searchTags as $searchTag) {
                if (mb_strpos(mb_strtolower($modelTag), mb_strtolower($searchTag)) !== false) {
                    $score += 1;
                    array_forget($modelTags, $modelIndex);
                    break;
                }
            }
        }

        return $score;
    }

    public function getThumbnail()
    {
        return $this->thumbnail_id ? $this->thumbnail_id : ($this->enabled_images->first() ? $this->enabled_images->first()->file_id : 1);
    }
}
