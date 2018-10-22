<?php

namespace App\Models;

use App\Events\Campaign\Created;
use App\Events\Campaign\PaymentCancelled;
use App\Events\Campaign\PaymentClosed;
use App\Events\Campaign\PaymentRetrying;
use App\Events\Campaign\ProofsProvided;
use App\Events\Campaign\QuoteProvided;
use App\Events\Campaign\Shipped;
use App\Http\Controllers\System\SystemController;
use App\Jobs\PrepareProcessingJob;
use App\Logging\Logger;
use Auth;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Support\Collection;

/**
 * @property integer                                      $id
 * @property string                                       $name
 * @property string                                       $sf_id
 * @property integer                                      $user_id
 * @property integer                                      $manager_id
 * @property integer                                      $free_product_id
 * @property integer                                      $free_product_size_id
 * @property integer                                      $free_product_color_id
 * @property integer                                      $artwork_request_id
 * @property integer                                      $artwork_id
 * @property integer                                      $source_design_id
 * @property string                                       $flexible
 * @property Carbon                                       $date
 * @property float                                        $invoice_total
 * @property boolean                                      $rush
 * @property string                                       $printer_shipping_date
 * @property string                                       $contact_first_name
 * @property string                                       $contact_last_name
 * @property string                                       $contact_email
 * @property string                                       $contact_phone
 * @property string                                       $contact_school
 * @property string                                       $contact_chapter
 * @property string                                       $address_name
 * @property string                                       $address_line1
 * @property string                                       $address_line2
 * @property string                                       $address_city
 * @property string                                       $address_state
 * @property string                                       $address_zip_code
 * @property string                                       $address_country
 * @property string                                       $estimated_quantity
 * @property string                                       $notes
 * @property string                                       $account_manager_notes
 * @property string                                       $promo_code
 * @property string                                       $state
 * @property string                                       $on_hold_category
 * @property string                                       $on_hold_rule
 * @property integer                                      $on_hold_actor
 * @property string                                       $on_hold_reason
 * @property string                                       $budget
 * @property string                                       $budget_range
 * @property boolean                                      $shipping_group
 * @property boolean                                      $shipping_individual
 * @property float                                        $quote_low
 * @property float                                        $quote_high
 * @property float                                        $quote_final
 * @property integer                                      $markup
 * @property integer                                      $bag_tag_id
 * @property string                                       $assigned_decorator_date
 * @property Carbon                                       $scheduled_date
 * @property string                                       $tracking_code
 * @property Carbon                                       $close_date
 * @property string                                       $payment_type
 * @property boolean                                      $payment_cheque
 * @property boolean                                      $payment_credit_card
 * @property boolean                                      $payment_links
 * @property boolean                                      $closing_24h_mail_sent
 * @property integer                                      $closing_fail_retry
 * @property boolean                                      $closing_fail_mail_sent
 * @property Carbon                                       $created_at
 * @property Carbon                                       $updated_at
 * @property Carbon                                       $deleted_at
 * @property string                                       $processed_at
 * @property integer                                      $school_id
 * @property integer                                      $chapter_id
 * @property boolean                                      $fulfillment_valid
 * @property string                                       $fulfillment_invalid_reason
 * @property string                                       $fulfillment_invalid_text
 * @property Carbon                                       $printing_date
 * @property string                                       $fulfillment_shipping_name
 * @property string                                       $fulfillment_shipping_phone
 * @property string                                       $fulfillment_shipping_line1
 * @property string                                       $fulfillment_shipping_line2
 * @property string                                       $fulfillment_shipping_city
 * @property string                                       $fulfillment_shipping_state
 * @property string                                       $fulfillment_shipping_zip_code
 * @property string                                       $fulfillment_shipping_country
 * @property integer                                      $decorator_id
 * @property string                                       $garment_arrival_date
 * @property string                                       $reminder_awaiting_approval
 * @property string                                       $reminder_collecting_payment
 * @property string                                       $reminder_deadline
 * @property string                                       $followup_awaiting_approval
 * @property string                                       $followup_collecting_payment
 * @property string                                       $followup_deadline
 * @property string                                       $followup_awaiting_approval_date
 * @property string                                       $followup_collecting_payment_date
 * @property string                                       $followup_deadline_date
 * @property string                                       $followup_no_orders
 * @property string                                       $reminders
 * @property string                                       $awaiting_approval_at
 * @property string                                       $awaiting_design_at
 * @property string                                       $revision_requested_at
 * @property string                                       $awaiting_quote_at
 * @property string                                       $collecting_payment_at
 * @property Carbon                                       $fulfillment_ready_at
 * @property string                                       $fulfillment_validation_at
 * @property string                                       $printing_at
 * @property Carbon                                       $shipped_at
 * @property string                                       $delivered_at
 * @property Carbon                                       $cancelled_at
 * @property integer                                      $campus_approval_time
 * @property integer                                      $awaiting_design_time
 * @property integer                                      $awaiting_approval_time
 * @property integer                                      $revision_requested_time
 * @property integer                                      $awaiting_quote_time
 * @property integer                                      $collecting_payment_time
 * @property integer                                      $fulfillment_ready_time
 * @property integer                                      $fulfillment_validation_time
 * @property integer                                      $printing_time
 * @property integer                                      $shipped_time
 * @property string                                       $on_hold_at
 * @property integer                                      $on_hold_time
 * @property boolean                                      $polybag_and_label
 * @property float                                        $royalty
 * @property float                                        $royalty_rate
 * @property float                                        $commission_manager_rate
 * @property float                                        $commission_manager
 * @property float                                        $commission_sales_rep_rate
 * @property float                                        $commission_sales_rep
 * @property float                                        $shipping_cost
 * @property Carbon                                       $due_at
 * @property integer                                      $days_in_transit
 * @property string                                       $decorator_pocket
 * @property string                                       $shipping_option
 * @property string                                       $fulfillment_notes
 * @property string                                       $payment_date_type
 * @property Carbon                                       $sizes_collected_date
 * @property-read User                                    $user
 * @property-read User                                    $decorator
 * @property-read User                                    $fulfillment
 * @property-read Collection|ProductColor[]|BelongsToMany $product_colors
 * @property-read Artwork                                 $artwork
 * @property-read ArtworkRequest                          $artwork_request
 * @property-read Collection|Order[]                      $orders
 * @property-read Collection|Order[]                      $authorized_orders
 * @property-read Collection|Order[]                      $authorized_success_orders
 * @property-read Collection|Order[]                      $success_orders
 * @property-read Collection|Order[]                      $expiring_orders
 * @property-read Collection|Order[]                      $expired_orders
 * @property-read Collection|CampaignSupply[]|HasMany     $supplies
 * @property-read GarmentSize                             $free_product_size
 * @property-read Collection|Design[]                     $designs
 * @property-read Chapter                                 $chapter
 * @property-read School                                  $school
 * @property-read Design                                  $source_design
 * @property-read Collection|Comment[]                    $comments
 * @property-read Collection|CampaignNote[]               $internal_notes
 * @property-read Collection|CampaignQuote[]              $quotes
 * @mixin \Eloquent
 */
class Campaign extends Model
{
    use SoftDeletes;
    use DispatchesJobs;

    protected $table = 'campaigns';

    protected $guarded = [];

    protected $dates = ['deleted_at', 'close_date', 'date', 'scheduled_date', 'printing_date', 'shipped_at', 'garment_arrival_date', 'due_at', 'cancelled_at', 'fulfillment_ready_at', 'sizes_collected_date'];

    protected $hidden = [
        'user',
        'decorator',
        'color',
        'orders',
        'authorized_orders',
        'authorized_success_orders',
        'success_orders',
        'supplies',
        'size',
        'chapter',
        'school',
        'comments',
        'artwork',
        'designs',
    ];

    protected static $runningEvent = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function decorator()
    {
        return $this->belongsTo(User::class, 'decorator_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function fulfillment()
    {
        return $this->belongsTo(User::class, 'fulfillment_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function product_colors()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsToMany(ProductColor::class, 'campaign_product_colors')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artwork()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(Artwork::class, 'artwork_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function artwork_request()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->belongsTo(ArtworkRequest::class, 'artwork_request_id')->withTrashed();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function supplies()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(CampaignSupply::class, 'campaign_id')->whereNotIn('state', ['nok', 'cancelled'])->orderBy('id', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function quotes()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(CampaignQuote::class, 'campaign_id')->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Order::class, 'campaign_id')->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authorized_orders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Order::class, 'campaign_id')->whereIn('state', ['authorized', 'authorized_failed'])->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function authorized_success_orders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Order::class, 'campaign_id')->whereIn('state', ['authorized', 'authorized_failed', 'success'])->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function success_orders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Order::class, 'campaign_id')->whereIn('state', ['success'])->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expiring_orders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Order::class, 'campaign_id')->whereIn('state', ['authorized', 'authorized_failed'])->where('created_at', '<', date('Y-m-d H:i:s', time() - (26 * 24 * 60 * 60)))->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function expired_orders()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Order::class, 'campaign_id')->whereIn('state', ['authorized', 'authorized_failed'])->where('created_at', '<', date('Y-m-d H:i:s', time() - (28 * 24 * 60 * 60)))->orderBy('created_at', 'asc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function bagTag()
    {
        return $this->belongsTo(File::class, 'bag_tag_id');
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function source_design()
    {
        return $this->belongsTo(Design::class, 'source_design_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function designs()
    {
        return $this->hasMany(Design::class, 'campaign_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(Comment::class, 'campaign_id')->orderBy('updated_at', 'desc');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function internal_notes()
    {
        /** @noinspection PhpUndefinedMethodInspection */
        return $this->hasMany(CampaignNote::class, 'campaign_id')->orderBy('updated_at', 'desc');
    }

    public function getQuoteLow($productId = null)
    {
        if ($productId != null) {
            foreach ($this->quotes as $quote) {
                if ($quote->product_id == $productId) {
                    return $quote->quote_low;
                }
            }
        }

        return $this->quote_low;
    }

    public function getQuoteHigh($productId = null)
    {
        if ($productId != null) {
            foreach ($this->quotes as $quote) {
                if ($quote->product_id == $productId) {
                    return $quote->quote_high;
                }
            }
        }

        return $this->quote_low;
    }

    public function getQuoteFinal($productId = null)
    {
        if ($productId != null) {
            foreach ($this->quotes as $quote) {
                if ($quote->product_id == $productId) {
                    return $quote->quote_final;
                }
            }
        }

        return $this->quote_final;
    }

    public static function boot()
    {
        parent::boot();

        Campaign::created(function (Campaign $campaign) {
            if ($campaign->state == 'on_hold') {
                $campaign->on_hold_at = date('Y-m-d H:i:s');
                $campaign->save();
            }
            if (empty($campaign->state) || $campaign->state == 'awaiting_design') {
                event(new Created($campaign->id));
                $campaign->awaiting_design_at = date('Y-m-d H:i:s');
                $campaign->save();
            }
        });

        Campaign::updated(function (Campaign $campaign) {
            if (! static::areEventsEnabled()) {
                return;
            }
            if (static::$runningEvent) {
                return;
            }
            static::$runningEvent = true;
            $original = (object) $campaign->getOriginal();
            if (isset($original->state)) {
                if ($original->state == 'awaiting_approval' && $campaign->state == 'revision_requested') {
                    $campaign->notificationProofRevisionRequested();
                }
                if ($original->state == 'awaiting_approval' && $campaign->state == 'awaiting_quote') {
                    $campaign->notificationProofAccepted();
                    success('Campaign state changed to: Awaiting Greek Licensing Approval');
                }
                //TODO: merge
                if ($campaign->state == 'awaiting_quote' && $original->quote_high != $campaign->quote_high || $original->quote_low != $campaign->quote_low) {
                    success('Campaign state changed to: Collecting Payment');
                    $campaign->state = 'collecting_payment';
                    $campaign->save();
                    if (! $campaign->close_date) {
                        $campaign->setCloseDate();
                    }

                    add_comment($campaign->id, 'Hey '.$campaign->user->first_name.', here is the payment link to share with members to make payment:'."\n".route('custom_store::details', [
                            product_to_description($campaign->id, $campaign->name),
                        ])."\n"."If you wish to pay by check, chapter credit card, or your Group billing system please give us your sizes here on the message board and we'll process it accordingly."."\n".'Best,'."\n".'Greek House', \Auth::user()->id);
                    event(new QuoteProvided($campaign->id));
                }
                if ($original->state == 'collecting_payment' && $campaign->state == 'processing_payment') {
                    (new PrepareProcessingJob($campaign->id))->handle();
                }
                if ($original->state != 'fulfillment_ready' && $campaign->state == 'fulfillment_ready') {
                    $campaign->calculateRoyaltiesAndCommissions();
                }
                if ($campaign->state == 'printing' && ! $original->scheduled_date && $campaign->scheduled_date) {
                    success('Campaign state changed to: Shipped');
                    $campaign->state = 'shipped';
                    $campaign->save();
                    event(new Shipped($campaign->id));
                }

                if ($campaign->decorator_id != null && (! isset($original->decorator_id) || $campaign->decorator_id != $original->decorator_id)) {
                    $campaign->assigned_decorator_date = date('Y-m-d H:i:s');
                    $campaign->save();
                }

                switch ($campaign->state) {
                    case 'on_hold':
                        if (! $campaign->on_hold_at) {
                            $campaign->on_hold_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'awaiting_design':
                        if (! $campaign->awaiting_design_at) {
                            $campaign->awaiting_design_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'awaiting_approval':
                        if (! $campaign->awaiting_approval_at) {
                            $campaign->awaiting_approval_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'revision_requested':
                        if (! $campaign->revision_requested_at) {
                            $campaign->revision_requested_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'awaiting_quote':
                        if (! $campaign->awaiting_quote_at) {
                            $campaign->awaiting_quote_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'collecting_payment':
                        if (! $campaign->collecting_payment_at) {
                            $campaign->collecting_payment_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'fulfillment_ready':
                        if (! $campaign->fulfillment_ready_at) {
                            $campaign->fulfillment_ready_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'fulfillment_validation':
                        if (! $campaign->fulfillment_validation_at) {
                            $campaign->fulfillment_validation_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'printing':
                        if (! $campaign->printing_at) {
                            $campaign->printing_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'shipped':
                        if (! $campaign->shipped_at) {
                            $campaign->shipped_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'delivered':
                        if (! $campaign->delivered_at) {
                            $campaign->delivered_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                    case 'cancelled':
                        if (! $campaign->cancelled_at) {
                            $campaign->cancelled_at = date('Y-m-d H:i:s');
                        }
                        $campaign->save();
                        break;
                }
                if ($campaign->state != $original->state && in_array($campaign->state, [
                        'campus_approval',
                        'awaiting_design',
                        'awaiting_approval',
                        'revision_requested',
                        'awaiting_quote',
                        'collecting_payment',
                        'processing_payment',
                        'fulfillment_ready',
                    ]) && $campaign->decorator_id) {
                    success('Removed Decorator');
                    $campaign->decorator_id = null;
                    $campaign->save();
                }
                if ($campaign->state != $original->state && ! in_array($original->state, ['cancelled', 'delivered'])) {
                    if ($campaign->{$original->state.'_at'}) {
                        $campaign->{$original->state.'_time'} += time() - strtotime($campaign->{$original->state.'_at'});
                    }
                    $campaign->save();
                }
                if ($campaign->state != $original->state) {
                    Logger::track(Campaign::class, $campaign->id, 'state change: '.$original->state.' => '.$campaign->state, ['state' => $campaign->state], $campaign->user->toArray(), $campaign->toArray());
                }
            }
            static::$runningEvent = false;
        });
    }

    public function track($eventName, $data = [])
    {
        $userContext = Auth::user() ? Auth::user()->toContext() : [];
        $campaignContext = $this->toContext();
        Logger::track('campaigns', $this->id, $eventName, $data, $userContext, $campaignContext);
    }

    public function getMinimumQuantity()
    {
        return estimated_quantity_by_code($this->getCurrentArtwork()->design_type, $this->estimated_quantity)->from;
    }

    public function getMaximumQuantity()
    {
        return estimated_quantity_by_code($this->getCurrentArtwork()->design_type, $this->estimated_quantity)->to;
    }

    public function getGoalPercentage($localGoalOnly = false)
    {
        $goal = $this->getNextQuantityGoal($localGoalOnly);
        if ($goal === null) {
            return null;
        }
        $percentage = ($this->getCurrentQuantity() / $goal) * 100;
        $percentage = round($percentage < 100 ? $percentage : 100);

        return $percentage;
    }

    public function getNextQuantityGoal($localGoalOnly = false)
    {
        if ($this->getCurrentQuantity() < $this->getMinimumQuantity()) {
            return $this->getMinimumQuantity();
        }

        if ($this->getCurrentQuantity() < $this->getMaximumQuantity() || $localGoalOnly) {
            return $this->getMaximumQuantity();
        }

        return null;
    }

    public function getNextGoalText()
    {
        if ($this->getCurrentQuantity() < $this->getMinimumQuantity()) {
            return 'Campaign Gets Produced';
        }

        if ($this->getCurrentQuantity() < $this->getMaximumQuantity()) {
            return 'Orders Gets Best Prices';
        }

        return null;
    }

    public function getCurrentQuantity()
    {
        return $this->getAuthorizedQuantity() + $this->getSuccessQuantity();
    }

    public function getQuantityLeft()
    {
        $quantityLeft = $this->getMinimumQuantity() - $this->getAuthorizedQuantity() - $this->getSuccessQuantity();
        if ($quantityLeft < 0) {
            return 0;
        }

        return $quantityLeft;
    }

    public function getStateDate($state)
    {
        switch ($state) {
            case 'on_hold':
                return $this->on_hold_at;
            case 'campus_approval':
                return $this->awaiting_approval_at;
            case 'awaiting_design':
                return $this->awaiting_design_at;
            case 'awaiting_approval':
                return $this->awaiting_approval_at;
            case 'revision_requested':
                return $this->revision_requested_at;
            case 'awaiting_quote':
                return $this->awaiting_quote_at;
            case 'collecting_payment':
                return $this->collecting_payment_at;
            case 'fulfillment_ready':
                return $this->fulfillment_ready_at;
            case 'fulfillment_validation':
                return $this->fulfillment_validation_at;
            case 'printing':
                return $this->printing_at;
            case 'shipped':
                return $this->shipped_at;
            case 'delivered':
                return $this->delivered_at;
            case 'cancelled':
                return $this->cancelled_at;
        }

        return null;
    }

    public function getDaysSince($date, $overrideNow = null)
    {
        $now = date('Y-m-d', $overrideNow ? strtotime($overrideNow) : strtotime(date('Y-m-d', time())));
        if ($date) {
            $result = ceil((strtotime($now) - strtotime($date)) / (24 * 60 * 60));
            if ($result != 0) {
                return $result;
            }
        }

        return 0;
    }

    public function getPaymentDeadlineDaysLeft($overrideNow = null)
    {
        $now = date('Y-m-d', $overrideNow ? strtotime($overrideNow) : strtotime(date('Y-m-d', time())));
        if ($this->date) {
            $result = ceil((strtotime($this->getPaymentDeadlineDate()) - strtotime($now)) / (24 * 60 * 60));
            if ($result != 0) {
                return $result;
            }
        }

        return 0;
    }

    public function getPaymentDeadlineDate()
    {
        if ($this->date) {
            $bdCount = 0;
            $time = strtotime($this->date);
            for ($i = 0; $i < 30; $i++) {
                if (date('N', $time) >= 1 && date('N', $time) <= 5) {
                    $bdCount++;
                    if ($bdCount == 10) {
                        return date('Y-m-d', $time);
                    }
                }
                $time -= 24 * 60 * 60;
            }
        }

        return 0;
    }

    public function getDeadlineDate()
    {
        return $this->date;
    }

    public function getDecoratorAssignedDate()
    {
        if ($this->assigned_decorator_date) {
            if (date('H', strtotime($this->assigned_decorator_date)) >= 13) {
                $safety = 30;
                $date = date('Y-m-d', strtotime($this->assigned_decorator_date) + (24 * 60 * 60));
                while (date('N', strtotime($date)) > 5 && --$safety > 0) {
                    $date = date('Y-m-d', strtotime($date) + (24 * 60 * 60));
                }
                if (date('N', strtotime($date)) > 5) {
                    Logger::logAlert('Problem with decorator assigned date', [
                        'campaign'                => $this->toArray(),
                        'assigned_decorator_date' => $this->assigned_decorator_date,
                        'date'                    => $date,
                        'safety'                  => $safety,
                    ]);

                    return null;
                }

                return $date;
            }

            return date('Y-m-d', strtotime($this->assigned_decorator_date));
        }

        return null;
    }

    public function getDecoratorAssignedAge()
    {
        $date = $this->getDecoratorAssignedDate();
        if ($date) {
            $today = date('Y-m-d');
            if (strtotime($today) - strtotime($date) < 0) {
                return 0;
            }
            $age = 0;
            $safety = 90;
            $nextDay = date('Y-m-d', strtotime($date) + (24 * 60 * 60));
            while ($today > $nextDay && --$safety > 0) {
                if (date('N', strtotime($nextDay) <= 5)) {
                    $age++;
                }
                $nextDay = date('Y-m-d', strtotime($nextDay) + (24 * 60 * 60));
            }
            if ($safety == 0) {
                return null;
            }

            return $age;
        }

        return null;
    }

    public function getDaysInState()
    {
        return $this->getDaysSince($this->getStateDate($this->state));
    }

    public function getCurrentTimeInState()
    {
        if ($this->getStateDate($this->state) != null) {
            return time() - strtotime($this->getStateDate($this->state));
        }

        return 0;
    }

    public function getSavedTimeInState($state)
    {
        switch ($state) {
            case 'on_hold':
                return $this->on_hold_time;
            case 'campus_approval':
                return $this->campus_approval_time;
            case 'awaiting_design':
                return $this->awaiting_design_time;
            case 'awaiting_approval':
                return $this->awaiting_approval_time;
            case 'revision_requested':
                return $this->revision_requested_time;
            case 'awaiting_quote':
                return $this->awaiting_quote_time;
            case 'collecting_payment':
                return $this->collecting_payment_time;
            case 'fulfillment_ready':
                return $this->fulfillment_ready_time;
            case 'fulfillment_validation':
                return $this->fulfillment_validation_time;
            case 'printing':
                return $this->printing_time;
            case 'shipped':
                return $this->shipped_time;
        }

        return 0;
    }

    public function getCustomerWaitingTime()
    {
        return $this->getCustomerNewOrderWaitingTime() + $this->getCustomerRevisionWaitingTime();
    }

    public function getCustomerNewOrderWaitingTime()
    {
        $time = $this->getSavedTimeInState('on_hold') + $this->getSavedTimeInState('awaiting_design');
        if (in_array($this->state, ['awaiting_design', 'on_hold'])) {
            $time += $this->getCurrentTimeInState();
        }

        return $time;
    }

    public function getCustomerRevisionWaitingTime()
    {
        $time = $this->getSavedTimeInState('revision_requested');
        if (in_array($this->state, ['revision_requested'])) {
            $time += $this->getCurrentTimeInState();
        }

        return $time;
    }

    public function getDesignerWaitingTime()
    {
        $time = $this->getSavedTimeInState('awaiting_approval');
        if (in_array($this->state, ['awaiting_approval'])) {
            $time += $this->getCurrentTimeInState();
        }

        return $time;
    }

    public function getCountdownTime()
    {
        if ($this->state == 'awaiting_design' && $this->awaiting_design_at) {
            return 48 * 60 * 60 - (time() - strtotime($this->awaiting_design_at));
        }
        if ($this->state == 'revision_requested' && $this->revision_requested_at) {
            return 48 * 60 * 60 - (time() - strtotime($this->revision_requested_at));
        }

        return 'N/A';
    }

    public function getContactFullName()
    {
        return getFullName($this->contact_first_name, $this->contact_last_name, $this->contact_email);
    }

    public function flagClosingIn24HoursEmailSent()
    {
        $this->closing_24h_mail_sent = true;
        $this->save();
    }

    public function isClosePaymentDateOverdue()
    {
        return $this->state == 'collecting_payment' && $this->close_date && $this->close_date < date('Y-m-d');
    }

    public function hasCloseDateRetriesLeft()
    {
        return $this->closing_fail_retry < config('greekhouse.campaign.quantity_not_met_retries');
    }

    public function closePayment()
    {
        if ($this->hasMetEstimatedQuantity() || (\Auth::check() && \Auth::user()->isType(['admin', 'support']))) {
            $this->state = 'processing_payment';
            $this->close_date = date('Y-m-d');
            $this->save();

            return 'CAMPAIGN_PAYMENT_CLOSED';
        } else {
            if ($this->hasCloseDateRetriesLeft()) {
                $this->retryCloseDate();

                return 'CAMPAIGN_PAYMENT_RETRYING';
            } else {
                if ($this->closing_fail_mail_sent == false) {
                    $this->track('quantity_not_met');
                    $this->cancelPayment();

                    return 'CAMPAIGN_QUANTITY_NOT_MET';
                } else {
                    return 'NONE';
                }
            }
        }
    }

    public function cancelPayment()
    {
        $this->closing_fail_mail_sent = true;
        $this->save();

        event(new PaymentCancelled($this->id));
    }

    public function retryCloseDate()
    {
        $this->closing_fail_retry++;
        $this->closing_24h_mail_sent = false;
        $this->close_date = date('Y-m-d', time() + (4 * 24 * 60 * 60));
        $this->save();

        event(new PaymentRetrying($this->id));
    }

    public function setCloseDate()
    {
        $this->close_date = date('Y-m-d H:i:s', time() + (40 * 24 * 60 * 60));
        $this->save();
    }

    public function notificationClosePayment($notificationType)
    {
        switch ($notificationType) {
            case 'CAMPAIGN_PAYMENT_CLOSED':
                $this->notificationPaymentClosed();
                break;
            case 'CAMPAIGN_PAYMENT_RETRYING':
                $this->notificationPaymentRetrying();
                break;
            case 'CAMPAIGN_QUANTITY_NOT_MET':
                $this->notificationPaymentQuantityNotMet();
                break;
            case 'NONE':
                break;
            default:
                throw new \Exception('No notification defined for '.$notificationType);
        }
    }

    public function notificationClosingIn24Hours()
    {
        Logger::logDebug('Campaign Closing in 24 hours Email sent to ['.$this->id.'] '.$this->name);
    }

    public function notificationPaymentClosed()
    {
        add_comment($this->id, 'Payment has been closed.');
        event(new PaymentClosed($this->id));
        Logger::logDebug('Campaign Closed Email & Fulfillment Email sent to ['.$this->id.'] '.$this->name);
    }

    public function notificationPaymentQuantityNotMet()
    {
        Logger::logDebug('Campaign Quantity not Met Email send to [support] ['.$this->id.'] '.$this->name);
    }

    public function notificationPaymentRetrying()
    {
        add_comment($this->id, 'Payment has been closed.');
        event(new PaymentRetrying($this->id));
        Logger::logDebug('Campaign Quantity Not Met Email sent to ['.$this->id.'] '.$this->name);
    }

    public function updateOrdersWithFinalQuote()
    {
        foreach ($this->authorized_orders as $order) {
            if (! in_array($order->state, ['authorized_failed', 'authorized'])) {
                continue;
            }

            $subtotal = 0;
            foreach ($order->entries as $entry) {
                $entry->price = ($this->quote_final + extra_size_charge($entry->size->short)) * 1.07;
                $entry->subtotal = $entry->price * $entry->quantity;
                $entry->save();
                $subtotal += $entry->subtotal;
            }
            $order->subtotal = $subtotal;
            $order->tax = 0;
            $total = $order->subtotal + $order->tax + $order->shipping;
            // Make sure it never goes above what was authorized.
            $order->total = $total > $order->total ? $order->total : $total;
            $order->save();
        }
    }

    public function getProofCount($type = null)
    {
        return $this->getCurrentArtwork()->getProofsFromType($type)->count();
    }

    public function getFirstProofId()
    {
        return $this->getCurrentArtwork()->proofs->first() ? $this->getCurrentArtwork()->proofs->first()->file_id : null;
    }

    public function notificationProofUploaded()
    {
        event(new ProofsProvided($this->id));
    }

    public function notificationProofRevisionRequested()
    {
        if ($this->artwork_request->designer_id) {
            //
        }
    }

    public function notificationProofAccepted()
    {
        if ($this->artwork_request->designer_id) {
            //
        }
    }

    public function notificationDesignerAssigned()
    {

    }

    public function getSuccessQuantity()
    {
        $quantity = 0;
        foreach ($this->success_orders as $order) {
            foreach ($order->entries as $entry) {
                $quantity += $entry->quantity;
            }
        }

        return $quantity;
    }

    public function getAuthorizedQuantity()
    {
        $quantity = 0;
        foreach ($this->authorized_orders as $order) {
            foreach ($order->entries as $entry) {
                $quantity += $entry->quantity;
            }
        }

        return $quantity;
    }

    public function getAuthorizedAndSuccessQuantity()
    {
        $quantity = 0;
        foreach ($this->authorized_success_orders as $order) {
            foreach ($order->entries as $entry) {
                $quantity += $entry->quantity;
            }
        }

        return $quantity;
    }

    public function hasMetEstimatedQuantity()
    {
        return ! $this->hasLessThanEstimatedQuantity();
    }

    public function hasLessThanEstimatedQuantity()
    {
        return $this->getAuthorizedQuantity() + $this->getSuccessQuantity() < $this->getMinimumQuantity();
    }

    public function hasMoreThanEstimatedQuantity()
    {
        return $this->getAuthorizedQuantity() + $this->getSuccessQuantity() > estimated_quantity_by_code($this->getCurrentArtwork()->design_type, $this->estimated_quantity)->to;
    }

    public function quoteQuantity(CampaignQuote $quote, $quantity)
    {
        $systemController = \App::make(SystemController::class);
        switch ($this->artwork_request->design_type) {
            case 'screen':
                $product = $quote->product;
                $dataRedo = [
                    'pid' => $product->id,
                    'pp'  => $product->price,
                    'pn'  => $product->name,
                    'cf'  => $this->artwork_request->designer_colors_front,
                    'cb'  => $this->artwork_request->designer_colors_back,
                    'cl'  => $this->artwork_request->designer_colors_sleeve_left,
                    'cr'  => $this->artwork_request->designer_colors_sleeve_right,
                    'bs'  => $this->artwork_request->designer_black_shirt ? 'yes' : 'no',
                    'eqf' => estimated_quantity_by_code($this->artwork_request->design_type, $this->estimated_quantity)->from,
                    'eqt' => estimated_quantity_by_code($this->artwork_request->design_type, $this->estimated_quantity)->to,
                    'dh'  => to_hours($this->artwork_request->design_minutes),
                    'mu'  => $this->markup,
                ];
                $quoteRedo = $systemController->quote('screen', $dataRedo);
                if ($quote->quote_low != $quoteRedo['quote']['price_unit'][0] || $quote->quote_high != $quoteRedo['quote']['price_unit'][0]) {
                    // Custom or outdated range was set
                    // Recalculate the price within the range

                    $estimatedQuantity = estimated_quantity_by_code($this->artwork_request->design_type, $this->estimated_quantity);
                    $rangeDivision = $estimatedQuantity->to - $estimatedQuantity->from;
                    if ($rangeDivision != 0) {
                        $rangePercentage = ($quantity - $estimatedQuantity->from) / $rangeDivision;
                        if ($rangePercentage > 1) {
                            $rangePercentage = 1;
                        }
                        if ($rangePercentage < 0) {
                            $rangePercentage = 0;
                        }
                        $rangePercentage = 1 - $rangePercentage;
                        $priceIncrease = $quote->quote_high - $quote->quote_low;
                        $finalAmount = $quote->quote_low + ($rangePercentage * $priceIncrease);
                    } else {
                        $finalAmount = $quote->quote_high;
                    }
                } else {
                    $product = $quote->product;
                    $data = [
                        'pid' => $product->id,
                        'pp'  => $product->price,
                        'pn'  => $product->name,
                        'cf'  => $this->artwork_request->designer_colors_front,
                        'cb'  => $this->artwork_request->designer_colors_back,
                        'cl'  => $this->artwork_request->designer_colors_sleeve_left,
                        'cr'  => $this->artwork_request->designer_colors_sleeve_right,
                        'bs'  => $this->artwork_request->designer_black_shirt,
                        'eqf' => $quantity,
                        'eqt' => $quantity,
                        'dh'  => to_hours($this->artwork_request->design_minutes),
                        'mu'  => $this->markup,
                    ];
                    $quote = $systemController->quote('screen', $data);
                    $finalAmount = $quote['quote']['price_unit'][0];
                }
                break;
            case 'embroidery':
                $product = $quote->product;
                $dataRedo = [
                    'pid' => $product->id,
                    'pp'  => $product->price,
                    'pn'  => $product->name,
                    'eqf' => estimated_quantity_by_code($this->artwork_request->design_type, $this->estimated_quantity)->from,
                    'eqt' => estimated_quantity_by_code($this->artwork_request->design_type, $this->estimated_quantity)->to,
                    'dh'  => to_hours($this->artwork_request->design_minutes),
                    'mu'  => $this->markup,
                ];
                $quoteRedo = $systemController->quote('embroidery', $dataRedo);
                if ($quote->quote_low != $quoteRedo['quote']['price_unit'][0] || $quote->quote_high != $quoteRedo['quote']['price_unit'][0]) {
                    // Custom or outdated range was set
                    // Recalculate the price within the range

                    $estimatedQuantity = estimated_quantity_by_code($this->artwork_request->design_type, $this->estimated_quantity);
                    $rangePercentage = ($quantity - $estimatedQuantity->from) / ($estimatedQuantity->to - $estimatedQuantity->from);
                    if ($rangePercentage > 1) {
                        $rangePercentage = 1;
                    }
                    if ($rangePercentage < 0) {
                        $rangePercentage = 0;
                    }
                    $rangePercentage = 1 - $rangePercentage;
                    $priceIncrease = $quote->quote_high - $quote->quote_low;
                    $finalAmount = $quote->quote_low + ($rangePercentage * $priceIncrease);
                } else {
                    //TODO: merge
                    $product = $this->product_colors->first()->product;
                    $data = [
                        'pid' => $product->id,
                        'pp'  => $product->price,
                        'pn'  => $product->name,
                        'eqf' => $quantity,
                        'eqt' => $quantity,
                        'dh'  => to_hours($this->artwork_request->design_minutes),
                        'mu'  => $this->markup,
                    ];
                    $quote = $systemController->quote('embroidery', $data);
                    $finalAmount = $quote['quote']['price_unit'][0];
                }
                break;
            default:
                throw new \Exception('Design Type quoting not implemented: '.$this->artwork_request->design_type);
        }

        return $finalAmount;
    }

    public function hasGroupShipping()
    {
        foreach ($this->success_orders as $order) {
            if ($order->shipping_type == 'group') {
                return true;
            }
        }

        return false;
    }

    public function hasIndividualShipping()
    {
        foreach ($this->success_orders as $order) {
            if ($order->shipping_type == 'individual') {
                return true;
            }
        }

        return false;
    }

    public function setOrdersTrackingCode()
    {
        foreach ($this->success_orders as $order) {
            $order->setTrackingCode($this->tracking_code);
        }
    }

    public function setShipped()
    {
        $this->state = 'shipped';
        $this->save();
    }

    public function notificationTrackingCode()
    {

    }

    public function notificationScheduledDate()
    {

    }

    /**
     * @param int $index
     * @return CampaignFile|null
     */
    public function getImageEntry($index)
    {
        foreach ($this->artwork_request->images as $imageEntry) {
            if ($imageEntry->sort == $index) {
                return $imageEntry;
            }
        }

        return null;
    }

    /**
     * @param int $index
     * @return CampaignFile|null
     */
    public function getPrintFileEntry($index)
    {
        foreach ($this->getCurrentArtwork()->print_files as $printFileEntry) {
            if ($printFileEntry->sort == $index) {
                return $printFileEntry;
            }
        }

        return null;
    }

    /**
     * @param string|null $type
     * @return ArtworkRequestFile[]|HasMany|Collection
     */
    public function getProofs($type = null)
    {
        return $this->getCurrentArtwork()->getProofsFromType($type);
    }

    public function getProof($type, $index)
    {
        foreach ($this->getCurrentArtwork()->getProofsFromType($type) as $proofEntry) {
            if ($proofEntry->sort == $index) {
                return $proofEntry;
            }
        }

        return null;
    }

    public function getProductColorProof($productColorId, $type)
    {
        return $this->getCurrentArtwork()->getProofsFromType($type, $productColorId)->first();
    }

    public function getProductColorProofs($productColorId)
    {
        return $this->getCurrentArtwork()->getProofsFromProductColor($productColorId);
    }

    public function getProductProofs($productId)
    {
        return $this->getCurrentArtwork()->getProofsFromProduct($productId);
    }

    /**
     * @return string|null
     */
    public function getLastProofTimestamp()
    {
        $time = null;
        foreach ($this->getCurrentArtwork()->proofs as $proofEntry) {
            if ($time == null || $proofEntry->file->created_at > $time) {
                $time = date('Y-m-d H:i:s', strtotime($proofEntry->file->created_at));
            }
        }

        return $time;
    }

    public function calculateRoyaltiesAndCommissions()
    {
        $totalSubtotal = 0;
        $totalSales = 0;
        $totalShipping = 0;
        foreach ($this->success_orders as $order) {
            $totalSubtotal += $order->subtotal;
            $totalSales += $order->total;
            $totalShipping += $order->shipping;
        }

        $commissionBase = ($totalSales - $totalShipping) * 0.85;
        $this->royalty_rate = 0;
        $this->commission_manager_rate = 0;
        $this->commission_sales_rep_rate = 0;
        if ($this->hasMetEstimatedQuantity()) {
            if ($this->user->isType('account_manager') || $this->user->account_manager_id) {
                $this->commission_manager_rate = 6.5;
            }
            if ($this->user->isType('sales_rep')) {
                if ($this->user->account_manager_id) {
                    $this->commission_manager_rate = 3.5;
                }
            }
        }
        $this->royalty = $totalSubtotal * ($this->royalty_rate / 100);
        $this->commission_manager = $commissionBase * ($this->commission_manager_rate / 100);
        $this->commission_sales_rep = $commissionBase * ($this->commission_sales_rep_rate / 100);
        $this->timestamps = false;
        $this->save();
    }

    public function getSubtotal()
    {
        $subtotal = 0;
        foreach ($this->success_orders as $order) {
            $subtotal += $order->subtotal;
        }

        return $subtotal;
    }

    public function getTotal()
    {
        $total = 0;
        foreach ($this->success_orders as $order) {
            $total += $order->total;
        }

        return $total;
    }

    public function getTax()
    {
        $tax = 0;
        foreach ($this->success_orders as $order) {
            $tax += $order->tax;
        }

        return $tax;
    }

    public function getRoyalty()
    {
        return $this->royalty;
    }

    public function getManagerCommission()
    {
        return $this->commission_manager;
    }

    public function getSalesRepCommission()
    {
        return $this->commission_sales_rep;
    }

    public function getProfit()
    {
        //TODO: profit?
        return 0;
    }

    public function getPricePerUnitWithTax()
    {
        return $this->quote_final * 1.07;
    }

    public function getQuantity()
    {
        $quantity = 0;
        foreach ($this->success_orders as $order) {
            $quantity += $order->quantity;
        }

        return $quantity;
    }

    public function getPrintingCost()
    {
        //TODO: printing cost?
        return 0;
    }

    public function getShippingCost()
    {
        $shipping = 0;
        foreach ($this->success_orders as $order) {
            $shipping += $order->shipping;
        }

        return $shipping;
    }

    public function getAuthorizedShippingCost()
    {
        $shipping = 0;
        foreach ($this->authorized_success_orders as $order) {
            $shipping += $order->shipping;
        }

        return $shipping;
    }

    public function getTotalSupplierCost()
    {
        $cost = 0;
        foreach ($this->supplies as $supply) {
            $cost += $supply->total;
        }

        return $cost;
    }

    public function getDesignCost()
    {
        return $this->getDesignHours() * $this->artwork_request->hourly_rate;
    }

    public function getTotalScreens()
    {
        return $this->artwork_request->designer_colors_front + $this->artwork_request->designer_colors_back + $this->artwork_request->designer_colors_sleeve_left + $this->artwork_request->designer_colors_sleeve_right + ($this->artwork_request->designer_black_shirt ? 1 : 0) * (($this->artwork_request->designer_colors_front ? 1 : 0) + ($this->artwork_request->designer_colors_back ? 1 : 0) + ($this->artwork_request->designer_colors_sleeve_left ? 1 : 0) + ($this->artwork_request->designer_colors_sleeve_right ? 1 : 0));
    }

    public function getDesignHours()
    {
        return ceil($this->artwork_request->design_minutes / 60);
    }

    public function toContext()
    {
        $campaign = $this->fresh('artwork_request');

        return [
            'id'              => $campaign->id,
            'name'            => $campaign->name,
            'decorator_id'    => $campaign->decorator_id,
            'artwork_request' => $campaign->artwork_request ? $campaign->artwork_request->toContext() : null,
        ];
    }

    /*
    public function getDesignerIdAttribute()
    {
        throw new \Exception('Invalid attribute: designer_id');
    }
    
    public function getRevisionCountAttribute()
    {
        throw new \Exception('Invalid attribute: revision_count');
    }
    
    public function getRevisionTextAttribute()
    {
        throw new \Exception('Invalid attribute: revision_text');
    }
    
    public function getPrintFrontAttribute()
    {
        throw new \Exception('Invalid attribute: print_front');
    }
    
    public function getPrintFrontColorsAttribute()
    {
        throw new \Exception('Invalid attribute: print_front_colors');
    }
    
    public function getPrintFrontDescriptionAttribute()
    {
        throw new \Exception('Invalid attribute: print_front_description');
    }
    
    public function getPrintPocketAttribute()
    {
        throw new \Exception('Invalid attribute: print_pocket');
    }
    
    public function getPrintPocketColorsAttribute()
    {
        throw new \Exception('Invalid attribute: print_pocket_colors');
    }
    
    public function getPrintPocketDescriptionAttribute()
    {
        throw new \Exception('Invalid attribute: print_pocket_description');
    }
    
    public function getPrintBackAttribute()
    {
        throw new \Exception('Invalid attribute: print_back');
    }
    
    public function getPrintBackColorsAttribute()
    {
        throw new \Exception('Invalid attribute: print_back_colors');
    }
    
    public function getPrintBackDescriptionAttribute()
    {
        throw new \Exception('Invalid attribute: print_back_description');
    }
    
    public function getPrintSleeveAttribute()
    {
        throw new \Exception('Invalid attribute: print_sleeve');
    }
    
    public function getPrintSleeveColorsAttribute()
    {
        throw new \Exception('Invalid attribute: print_sleeve_colors');
    }
    
    public function getPrintSleeveDescriptionAttribute()
    {
        throw new \Exception('Invalid attribute: print_sleeve_description');
    }
    
    public function getPrintSleevePreferredAttribute()
    {
        throw new \Exception('Invalid attribute: print_sleeve_preferred');
    }
    
    public function getDesignStylePreferenceAttribute()
    {
        throw new \Exception('Invalid attribute: design_style_preference');
    }
    
    public function getDesignTypeAttribute()
    {
        throw new \Exception('Invalid attribute: design_type');
    }
    
    public function getDesignMinutesAttribute()
    {
        throw new \Exception('Invalid attribute: design_minutes');
    }
    
    public function getHourlyRateAttribute()
    {
        throw new \Exception('Invalid attribute: hourly_rate');
    }
    
    public function getDesignerActionRequiredAtAttribute()
    {
        throw new \Exception('Invalid attribute: designer_action_required_at');
    }
    
    public function getDesignerAssignedAtAttribute()
    {
        throw new \Exception('Invalid attribute: designer_assigned_at');
    }
    
    public function getSpecialityInksAttribute()
    {
        throw new \Exception('Invalid attribute: speciality_inks');
    }
    
    public function getEmbellishmentNamesAttribute()
    {
        throw new \Exception('Invalid attribute: embellishment_names');
    }
    
    public function getEmbellishmentNumbersAttribute()
    {
        throw new \Exception('Invalid attribute: embellishment_numbers');
    }
    
    public function getDesignerBlackShirtAttribute()
    {
        throw new \Exception('Invalid attribute: designer_black_shirt');
    }
    
    public function getDesignerColorsFrontAttribute()
    {
        throw new \Exception('Invalid attribute: designer_colors_front');
    }
    
    public function getDesignerColorsBackAttribute()
    {
        throw new \Exception('Invalid attribute: designer_colors_back');
    }
    
    public function getDesignerColorsSleeveLeftAttribute()
    {
        throw new \Exception('Invalid attribute: designer_colors_sleeve_left');
    }
    
    public function getDesignerColorsSleeveRightAttribute()
    {
        throw new \Exception('Invalid attribute: designer_colors_sleeve_right');
    }
    
    public function getSizeIdAttribute()
    {
        throw new \Exception('Invalid attribute: size_id');
    }
    
    public function getProductIdAttribute()
    {
        throw new \Exception('Invalid attribute: product_id');
    }
    
    public function getColorIdAttribute()
    {
        throw new \Exception('Invalid attribute: color_id');
    }
    
    public function getSizeAttribute()
    {
        throw new \Exception('Invalid attribute: size');
    }
    */
    /**
     * @return Artwork|ArtworkRequest
     */
    public function getCurrentArtwork()
    {
        return $this->artwork ? $this->artwork : $this->artwork_request;
    }

    public function getOnHoldReasonCaption()
    {
        if (! $this->on_hold_reason) {
            return null;
        }

        switch ($this->on_hold_reason) {
            case 'not_enough_information':
                return 'there is not enough information to complete the design.';
            case 'inappropriate_design':
                return 'this is an inappropriate design request - Greek Licensing Nationals does not allow for these kinds of designs to be created and produced.';
            case 'copyright_infringement':
                return 'there is a Copyright infringement in your design request.';
            case 'impossible':
                return 'the design is not possible to recreate using screen printing, sublimation, or embroidery methods.';
            default:
                return 'the design needs further work.';
        }
    }

    public function getCloseDate()
    {
        if ($this->state == 'cancelled' && $this->cancelled_at) {
            return $this->cancelled_at->format('Y-m-d');
        }

        if ($this->fulfillment_ready_at) {
            return $this->fulfillment_ready_at->format('Y-m-d');
        }

        if ($this->close_date) {
            return $this->close_date->format('Y-m-d');
        }

        if ($this->date) {
            return $this->date->subWeekdays(10)->format('Y-m-d');
        }

        return $this->created_at->addDays(22)->format('Y-m-d');
    }

    public function makeOrder()
    {
        $order = order_repository()->make();
        $order->campaign_id = $this->id;
        $order->payment_type = 'individual';
        $order->shipping_type = 'group';
        $order->user_id = Auth::user() ? Auth::user()->id : null;
        $order->shipping = 0;
        $order->contact_school = $this->contact_school;
        $order->contact_chapter = $this->contact_chapter;

        if (Auth::user()) {
            if (Auth::user()->address) {
                $order->billing_line1 = Auth::user()->address->line1;
                $order->billing_line2 = Auth::user()->address->line2;
                $order->billing_city = Auth::user()->address->city;
                $order->billing_state = Auth::user()->address->state;
                $order->billing_zip_code = Auth::user()->address->zip_code;
            }
            $order->contact_first_name = Auth::user()->first_name;
            $order->contact_last_name = Auth::user()->last_name;
            $order->contact_email = Auth::user()->email;
            $order->contact_phone = Auth::user()->phone;
        }

        if (! $this->shipping_group && $order->shipping_type == 'group') {
            $order->shipping_type = 'individual';
        }
        if (! $this->shipping_individual && $order->shipping_type == 'group') {
            $order->shipping_type = 'group';
        }

        return $order;
    }
}
