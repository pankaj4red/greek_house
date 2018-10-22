<?php

namespace App\Repositories\Models;

use App\Models\Campaign;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

/**
 * @method Campaign make()
 * @method Collection|Campaign[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Campaign|null find($id)
 * @method Campaign create(array $parameters = [])
 */
class CampaignRepository extends ModelRepository
{
    protected $modelClassName = Campaign::class;

    protected $rules = [
        'name'                    => 'required|max:255',
        'state'                   => 'required|max:255',
        'date'                    => 'date|nullable',
        'close_date'              => 'date|nullable',
        'flexible'                => 'required|in:yes,no',
        'scheduled_date'          => 'date|nullable',
        'promo_code'              => 'max:255',
        'estimated_quantity'      => 'required',
        'size_short'              => 'required',
        'contact_first_name'      => 'required|max:255',
        'contact_last_name'       => 'required|max:255',
        'contact_email'           => 'required|email',
        'contact_phone'           => 'required|max:255',
        'contact_school'          => 'required|max:255',
        'contact_chapter'         => 'required|max:255',
        'address_name'            => 'required|max:255',
        'address_line1'           => 'required|max:255',
        'address_line2'           => 'max:255',
        'address_city'            => 'required|max:255',
        'address_state'           => 'required|max:255',
        'address_zip_code'        => 'required|digits:5',
        'address_country'         => 'required',
        'shipping_group'          => 'required|max:255',
        'shipping_individual'     => 'required|max:255',
        'quote_low'               => 'nullable|numeric',
        'quote_high'              => 'nullable|numeric',
        'quote_final'             => 'nullable|numeric',
        'design_hours'            => 'required',
        'reminders'               => 'required|in:on,off',
        'design_type'             => 'required|in:screen,embroidery',
        'design_style_preference' => 'required',
        'rush'                    => 'in:yes,no',
    ];

    protected $extraRules = [];

    /**
     * @param mixed      $data
     * @param array|null $rules
     * @param int|null   $id
     * @return Validator
     */
    public function validate($data, $rules = null, $id = null)
    {
        $messages = [];
        $data = $data instanceof Request ? $data->all() : $data;
        $this->extraRules = [];
        if ($rules == null || in_array('contact_phone', $rules)) {
            $data['contact_phone'] = get_phone_digits($data['contact_phone']);
            $this->extraRules['contact_phone'] = 'required|digits:10';
            $messages['contact_phone.digits'] = 'Contact Phone needs 10 digits';
        }

        $result = parent::validate($data, $rules, $messages);

        return $result;
    }

    /**
     * @param array|null $filter
     * @return array
     */
    public function getRules($filter = null)
    {
        return $this->extraRules + parent::getRules($filter);
    }

    /**
     * @param $date
     * @return Collection|Campaign[]
     */
    public function getAwaitingAwaitingApprovalFollowUp($date)
    {
        return $this->model->where('state', 'awaiting_approval')->where('followup_awaiting_approval_date', '<=', $date)->whereNull('followup_awaiting_approval')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getCurrentlyAwaitingApprovalFollowUp()
    {
        return $this->model->newQuery()->with('orders', 'success_orders')->where('state', 'awaiting_approval')->where('followup_awaiting_approval', 'yes')->get();
    }

    /**
     * @param string $state
     * @return Collection|Campaign[]
     */
    public function getInState($state)
    {
        $query = $this->model->newQuery()->with('orders', 'success_orders');
        if (is_array($state)) {
            $query->whereIn('state', $state);
        } else {
            $query->where('state', $state);
        }

        return $query->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getPaymentClosingIn24h()
    {
        return $this->model->newQuery()->with('authorized_success_orders.entries')->where('state', 'collecting_payment')->where('close_date', '<', date('Y-m-d', time() + 24 * 60 * 60))->where('closing_24h_mail_sent', false)->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getNeedsPaymentClosing()
    {
        return $this->model->newQuery()->with('authorized_success_orders')->where('state', 'collecting_payment')->where('close_date', '<', date('Y-m-d'))->get();
    }

    /**
     * @param string $date
     * @return Collection|Campaign[]
     */
    public function getAwaitingCollectingPaymentFollowUp($date)
    {
        return $this->model->where('state', 'collecting_payment')->where('followup_collecting_payment_date', '<=', $date)->whereNull('followup_collecting_payment')->where('flexible', 'yes')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getCurrentlyCollectingPaymentFollowUp()
    {
        return $this->model->newQuery()->with('orders', 'authorized_success_orders')->where('state', 'collecting_payment')->where('followup_collecting_payment', 'yes')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getFlexibleCollectingPayment()
    {
        return $this->model->where('state', 'collecting_payment')->where('flexible', 'yes')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getCurrentlyDeadlineFollowUp()
    {
        return $this->model->whereIn('state', [
            'campus_approval',
            'awaiting_design',
            'awaiting_approval',
            'revision_requested',
            'awaiting_quote',
            'collecting_payment',
        ])->where('followup_deadline', 'yes')->get();
    }

    /**
     * @param string $date
     * @return Collection|Campaign[]
     */
    public function getAwaitingDeadlineFollowUp($date)
    {
        return $this->model->whereIn('state', [
            'campus_approval',
            'awaiting_design',
            'awaiting_approval',
            'revision_requested',
            'awaiting_quote',
            'collecting_payment',
        ])->where('followup_deadline_date', '<=', $date)->whereNull('followup_deadline')->where('flexible', 'no')->get();
    }

    /**
     * @param string $date
     * @return Collection|Campaign[]
     */
    public function getAwaitingNoOrdersFollowUp($date)
    {
        return $this->model->where('state', 'collecting_payment')->where('close_date', '<=', $date)->whereNull('followup_deadline')->whereDoesntHave('orders')->whereNull('followup_no_orders')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getCurrentlyNoOrdersFollowUp()
    {
        return $this->model->where('state', 'collecting_payment')->where('followup_no_orders', 'yes')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getPreFulfillmentNonFlexible()
    {
        return $this->model->whereIn('state', [
            'campus_approval',
            'awaiting_design',
            'awaiting_approval',
            'revision_requested',
            'awaiting_quote',
            'collecting_payment',
        ])->where('flexible', 'no')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getExpiredPrintings()
    {
        return $this->model->whereNotNull('decorator_id')->where('printing_date', '<', date('Y-m-d', time() + (24 * 60 * 60)))->where('state', 'printing')->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getCurrentlyProcessingPayment()
    {
        return $this->model->newQuery()->with('authorized_orders', 'user')->where('state', 'processing_payment')->where(function (
            $query
        ) {
            /** @var Builder $query */
            $query->where('processed_at', '>=', date('Y-m-d H:i:s', time() - (24 * 60 * 60)))->orWhere('processed_at', '=', '0000-00-00 00:00:00');
        })->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getExpiredProcessingPayment()
    {
        return $this->model->where('processed_at', '<>', '0000-00-00 00:00:00')->with('authorized_orders', 'user')->where('state', 'processing_payment')->where('processed_at', '<', date('Y-m-d H:i:s', time() - (24 * 60 * 60)))->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getSalesforceCampaigns()
    {
        return $this->model->newQuery()->where('created_at', '>', config('services.salesforce.cutout_date'))->orderBy('id', 'desc')->get();
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|Campaign[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery()->with('artwork_request.designer', 'user');
        if (isset($filters['filter_user_name']) && $filters['filter_user_name']) {
            $query = $query->whereHas('user', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->whereRaw("concat(first_name, ' ', last_name) like ?", ['%'.$filters['filter_user_name'].'%']);
            });
        }
        if (isset($filters['filter_user_id']) && $filters['filter_user_id']) {
            $query = $query->where('user_id', $filters['filter_user_id']);
        }
        if (isset($filters['filter_campaign_name']) && $filters['filter_campaign_name']) {
            $query = $query->where('name', 'like', '%'.$filters['filter_campaign_name'].'%');
        }
        if (isset($filters['filter_campaign_id']) && $filters['filter_campaign_id']) {
            $query = $query->where('campaigns.id', $filters['filter_campaign_id']);
        }
        if (isset($filters['filter_campaign_state']) && $filters['filter_campaign_state']) {
            $query = $query->where('state', $filters['filter_campaign_state']);
        }
        if (isset($filters['filter_campaign_updated_from']) && $filters['filter_campaign_updated_from']) {
            $query = $query->where('campaigns.updated_at', '>=', date('Y-m-d', strtotime($filters['filter_campaign_updated_from'])));
        }
        if (isset($filters['filter_campaign_updated_to']) && $filters['filter_campaign_updated_to']) {
            $query = $query->where('campaigns.updated_at', '<=', date('Y-m-d', strtotime($filters['filter_campaign_updated_to'])));
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param integer    $userId
     * @param array|null $stateFilter
     * @return Collection|Campaign[]
     */
    public function getByUserId($userId, $stateFilter = null)
    {
        $query = $this->model->newQuery()->orderBy('updated_at', 'desc')->with('artwork_request.designer', 'user')->where('user_id', $userId);
        if ($stateFilter) {
            $query->whereIn('state', $stateFilter);
        }

        return $query->get();
    }

    /**
     * @return Collection|Campaign[]
     */
    public function getExpiredPrintingDate()
    {
        return $this->model->newQuery()->where('state', 'fulfillment_validation')->where('fulfillment_valid', true)->where('printing_date', '<=', Carbon::parse('+1 day')->format('Y-m-d'))->get();
    }

    public function getUnclaimed($embellishment = null)
    {
        $query = $this->model->newQuery()->whereHas('artwork_request', function ($query2) {
            /** @var Builder $query2 */
            $query2->whereNull('designer_id');
        })->whereIn('state', ['awaiting_design', 'revision_requested', 'awaiting_approval']);

        if ($embellishment) {
            $query->whereHas('artwork_request', function ($query2) use ($embellishment) {
                /** @var Builder $query2 */
                $query2->where('design_type', $embellishment);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getNeedingUploadFiles($embellishment = null)
    {
        /** @var Builder $query */
        $query = $this->model->newQuery()->with('artwork_request.designer', 'user')->whereHas('artwork_request', function ($query) {
            /** @var Builder $query */
            $query->whereNotNull('designer_id');
        })->whereNotIn('state', [
            'campus_approval',
            'awaiting_design',
            'revision_requested',
            'awaiting_approval',
            'cancelled',
            'shipped',
            'delivered',
        ])->whereHas('artwork_request', function ($query2) {
            /** @var Builder $query2 */
            $query2->whereDoesntHave('print_files');
        });

        if ($embellishment) {
            $query->whereHas('artwork_request', function ($query2) use ($embellishment) {
                /** @var Builder $query2 */
                $query2->where('design_type', $embellishment);
            });
        }

        if (\App::environment() != 'testing') {
            $query->orderByRaw("field(state, 'printing', 'fulfillment_validation', 'fulfillment_ready', 'processing_payment', 'collecting_payment', 'awaiting_quote'), printing_date asc");
        }

        return $query->get();
    }

    public function getDesignCompleted($embellishment = null)
    {
        /** @var Builder $query */
        $query = $this->model->newQuery()->with('artwork_request.designer', 'user')->whereNotIn('state', ['campus_approval', 'awaiting_design', 'revision_requested', 'awaiting_approval'])->whereHas('artwork_request', function ($query2) {
            /** @var Builder $query2 */
            $query2->whereHas('print_files');
        })->whereHas('artwork_request', function ($query2) {
            /** @var Builder $query2 */
            $query2->whereNotNull('designer_id');
        });

        if ($embellishment) {
            $query->whereHas('artwork_request', function ($query2) use ($embellishment) {
                /** @var Builder $query2 */
                $query2->where('design_type', $embellishment);
            });
        }

        return $query->orderBy('id', 'desc')->take(10)->get();
    }

    public function getAwaitingForDesigner($embellishment = null)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $query = $this->model->with('artwork_request.designer', 'user')->whereHas('artwork_request', function ($query2) {
            /** @var Builder $query2 */
            $query2->whereNotNull('designer_id');
        })->whereIn('state', ['awaiting_design', 'revision_requested']);

        if ($embellishment) {
            $query->whereHas('artwork_request', function ($query2) use ($embellishment) {
                /** @var Builder $query2 */
                $query2->where('design_type', $embellishment);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getAwaitingForCustomer($embellishment = null)
    {
        /** @noinspection PhpUndefinedMethodInspection */
        $query = $this->model->with('artwork_request.designer', 'user')->whereHas('artwork_request', function ($query2) {
            /** @var Builder $query2 */
            $query2->whereNotNull('designer_id');
        })->whereIn('state', ['awaiting_approval']);

        if ($embellishment) {
            $query->whereHas('artwork_request', function ($query2) use ($embellishment) {
                /** @var Builder $query2 */
                $query2->where('design_type', $embellishment);
            });
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function getAssignedToDesigner($id)
    {
        return $this->model->newQuery()->with('artwork_request.designer')->whereHas('artwork_request', function ($query2) use ($id) {
            /** @var Builder $query2 */
            $query2->where('designer_id', $id);
        })->orderBy('id', 'desc')->get();
    }

    public function belongsToMember($campaignId, $accountManagerId)
    {
        return $this->model->newQuery()->where('id', $campaignId)->whereHas('user', function ($queryResult) use ($accountManagerId) {
                /** @var Builder $queryResult */
                $queryResult->where('account_manager_id', $accountManagerId);
            })->first() != null;
    }

    public function last()
    {
        return $this->model->newQuery()->orderBy('id', 'desc')->first();
    }

    /**
     * @param string $date
     * @return \Illuminate\Database\Eloquent\Collection|Campaign[]
     */
    public function getCreatedAfter($date)
    {
        return $this->newQuery()->where('created_at', '>=', $date)->get();
    }

    /**
     * @param $name
     * @return Builder|\Illuminate\Database\Eloquent\Model|null|object
     */
    public function findByName($name)
    {
        return $this->model->newQuery()->where('name', $name)->first();
    }

    /**
     * @param int $userId
     * @param int $page
     * @param int $pageSize
     * @return \Illuminate\Database\Eloquent\Collection|Campaign[]
     */
    public function getCampaignsInUserStore($userId, $page = 0, $pageSize = 20)
    {
        return $this->getListing([
            'filter_campaign_state' => 'collecting_payment',
            'filter_user_id'        => $userId,
        ], null, $page, $pageSize);
    }
}
