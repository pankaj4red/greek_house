<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Collection;

/**
 * @property integer                        $id
 * @property string                         $name
 * @property integer                        $user_id
 * @property integer                        $distinct_id
 * @property integer                        $free_product_id
 * @property integer                        $free_product_color_id
 * @property integer                        $free_product_size_id
 * @property integer                        $gender_id
 * @property integer                        $category_id
 * @property string                         $size_short
 * @property boolean                        $print_front
 * @property string                         $print_front_colors
 * @property string                         $print_front_description
 * @property boolean                        $print_pocket
 * @property string                         $print_pocket_colors
 * @property string                         $print_pocket_description
 * @property boolean                        $print_back
 * @property string                         $print_back_colors
 * @property string                         $print_back_description
 * @property boolean                        $print_sleeve
 * @property string                         $print_sleeve_colors
 * @property string                         $print_sleeve_description
 * @property string                         $print_sleeve_preferred
 * @property string                         $design_style_preference
 * @property string                         $flexible
 * @property string                         $date
 * @property boolean                        $rush
 * @property string                         $contact_first_name
 * @property string                         $contact_last_name
 * @property string                         $contact_email
 * @property string                         $contact_phone
 * @property string                         $contact_school
 * @property string                         $contact_chapter
 * @property string                         $address_option
 * @property string                         $address_name
 * @property string                         $address_line1
 * @property string                         $address_line2
 * @property string                         $address_city
 * @property string                         $address_state
 * @property string                         $address_zip_code
 * @property string                         $address_country
 * @property boolean                        $address_save
 * @property string                         $design_type
 * @property string                         $estimated_quantity
 * @property string                         $notes
 * @property string                         $account_manager_notes
 * @property string                         $promo_code
 * @property string                         $state
 * @property string                         $budget
 * @property string                         $budget_range
 * @property string                         $close_date
 * @property Carbon                         $created_at
 * @property Carbon                         $updated_at
 * @property Carbon                         $deleted_at
 * @property integer                        $school_id
 * @property integer                        $chapter_id
 * @property integer                        $image1_id
 * @property integer                        $image2_id
 * @property integer                        $image3_id
 * @property integer                        $image4_id
 * @property integer                        $image5_id
 * @property integer                        $image6_id
 * @property integer                        $image7_id
 * @property integer                        $image8_id
 * @property integer                        $image9_id
 * @property integer                        $image10_id
 * @property integer                        $image11_id
 * @property integer                        $image12_id
 * @property integer                        $file_id
 * @property integer                        $campaign_id
 * @property integer                        $source_design_id
 * @property boolean                        $polybag_and_label
 * @property-read User                      $user
 * @property-read ProductColor[]|Collection $product_colors
 * @property-read Product                   $free_product
 * @property-read ProductColor              $free_product_color
 * @property-read GarmentSize               $free_product_size
 * @property-read File                      $image1
 * @property-read File                      $image2
 * @property-read File                      $image3
 * @property-read Chapter                   $chapter
 * @property-read School                    $school
 * @mixin \Eloquent
 */
class CampaignLead extends Model
{
    use SoftDeletes;

    protected $table = 'campaign_leads';

    protected $guarded = [];

    protected $dates = ['deleted_at'];

    protected $hidden = ['user', 'product_colors', 'images', 'chapter', 'school'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product_colors()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsToMany(ProductColor::class, 'campaign_lead_product_colors');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function free_product_color()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(ProductColor::class, 'free_product_color_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image1()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image1_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image2()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image2_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image3()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image3_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image4()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image4_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image5()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image5_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image6()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image6_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image7()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image7_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image8()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image8_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image9()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image9_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image10()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image10_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image11()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image11_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function image12()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'image12_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function file()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(File::class, 'file_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function chapter()
    {
        return $this->belongsTo(Chapter::class, 'chapter_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function school()
    {
        return $this->belongsTo(School::class, 'school_id');
    }

    public function hasProduct($productId)
    {
        foreach ($this->product_colors as $productColor) {
            if ($productColor->product_id == $productId) {
                return true;
            }
        }

        return false;
    }

    public function toProductColorTree()
    {
        $products = [];
        foreach ($this->product_colors as $productColor) {
            $productId = $productColor->product_id;
            $colorId = $productColor->id;
            if (! array_key_exists($productId, $products)) {
                $products[$productId] = [];
            }
            $products[$productId][] = $colorId;
        }

        return $products;
    }
}
