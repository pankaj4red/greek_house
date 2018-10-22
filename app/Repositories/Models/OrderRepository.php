<?php

namespace App\Repositories\Models;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @method Order make()
 * @method Collection|Order[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method Order|null find($id)
 * @method Order create(array $parameters = [])
 */
class OrderRepository extends ModelRepository
{
    protected $modelClassName = Order::class;

    protected $rules = [
        'shipping_line1'     => 'required|max:255',
        'shipping_line2'     => 'max:255',
        'shipping_city'      => 'required|max:255',
        'shipping_state'     => 'required|max:255',
        'shipping_zip_code'  => 'required|digits:5',
        'shipping_country'   => 'required|max:255',
        'contact_first_name' => 'required|max:255',
        'contact_last_name'  => 'required|max:255',
        'contact_email'      => 'required|email|max:255',
        'contact_phone'      => 'required|max:255',
        'contact_chapter'    => 'required|max:255',
        'contact_school'     => 'required|max:255',
        'shipping_type'      => 'required|in:group,individual',
        'billing_first_name' => 'required|max:255',
        'billing_last_name'  => 'required|max:255',
        'billing_line1'      => 'required|max:255',
        'billing_line2'      => 'max:255',
        'billing_city'       => 'required|max:255',
        'billing_state'      => 'required|max:255',
        'billing_zip_code'   => 'required|digits:5',
        'billing_country'    => 'required|max:255',
    ];

    protected $extraRules = [];

    /**
     * @return Collection|Order[]
     */
    public function getCancellingOrders()
    {
        return $this->model->whereIn('state', ['authorized', 'authorized_failed'])->whereHas('campaign', function ($query) {
            /** @var Builder $query */
            $query->where('state', 'cancelled');
            $query->where('updated_at', '>=', date('Y-m-d H:i:s', time() - (24 * 60 * 60)));
        })->get();
    }

    /**
     * @return Collection|Order[]
     */
    public function getCancellingExpiredOrders()
    {
        return $this->model->whereIn('state', ['authorized', 'authorized_failed'])->whereHas('campaign', function ($query) {
            /** @var Builder $query */
            $query->where('state', 'cancelled');
            $query->where('updated_at', '<', date('Y-m-d H:i:s', time() - (24 * 60 * 60)));
        })->get();
    }

    /**
     * @return Collection|Order[]
     */
    public function getOrderByCartId($cartId)
    {
        return $this->model->where('cart_id', $cartId)->orderBy('created_at', 'desc')->get();
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|Order[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery()->with('user');
        /** @var Builder $query */
        if (isset($filters['filter_campaign_name']) && $filters['filter_campaign_name']) {
            $query = $query->whereHas('campaign', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->whereRaw('name like ?', ['%'.$filters['filter_campaign_name'].'%']);
            });
        }
        if (isset($filters['filter_order_id']) && $filters['filter_order_id']) {
            $query = $query->where('id', $filters['filter_order_id']);
        }
        if (isset($filters['filter_campaign_username']) && $filters['filter_campaign_username']) {
            $query = $query->whereHas('campaign', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->whereRaw('concat(contact_first_name, " ", contact_last_name) like ?', ['%'.$filters['filter_campaign_username'].'%']);
            });
        }
        if (isset($filters['filter_order_email']) && $filters['filter_order_email']) {
            $query = $query->whereRaw('contact_email like ?', ['%'.$filters['filter_order_email'].'%']);
        }
        if (isset($filters['filter_order_name']) && $filters['filter_order_name']) {
            $query = $query->whereRaw('concat(contact_first_name, " ", contact_last_name) like ?', ['%'.$filters['filter_order_name'].'%']);
        }
        if (isset($filters['filter_campaign_id']) && $filters['filter_campaign_id']) {
            $query = $query->where('campaign_id', $filters['filter_campaign_id']);
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param integer $userId
     * @return Collection|Order[]
     */
    public function getByUserId($userId)
    {
        return $this->model->newQuery()->orderBy('updated_at', 'desc')->with('user', 'campaign')->where('user_id', $userId)->get();
    }

    /**
     * @param integer    $campaignId
     * @param array|null $stateFilters
     * @return Collection|Order[]
     */
    public function getByCampaignId($campaignId, $stateFilters = null)
    {
        $query = $this->model->newQuery()->with('entries')->where('campaign_id', $campaignId);
        if ($stateFilters != null) {
            $query->whereIn('state', ['authorized', 'authorized_failed', 'success']);
        }

        return $query->get();
    }

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
     * @param $total
     * @return Order|null
     */
    public function findLastByTotal($total)
    {
        return $this->model->where('total', $total)->orderBy('created_at', 'desc')->first();
    }

    public function getRevenueSpentTotal($userId)
    {
        return $this->model->newQuery()->whereHas('campaign', function ($queryResult) use ($userId) {
            /** @var Builder $queryResult */
            $queryResult->where('user_id', $userId);
        })->where('state', 'success')->sum('orders.total');
    }

    public function getRevenueSpentMembersTotal($userId)
    {
        return $this->model->newQuery()->whereHas('campaign', function ($queryResult) use ($userId) {
            /** @var Builder $queryResult */
            $queryResult->whereHas('user', function ($queryResult2) use ($userId) {
                /** @var Builder $queryResult2 */
                $queryResult2->where('account_manager_id', $userId);
            });
        })->where('state', 'success')->sum('orders.total');
    }

    public function getQuantityTotal($userId)
    {
        return $this->model->newQuery()->whereHas('campaign', function ($queryResult) use ($userId) {
            /** @var Builder $queryResult */
            $queryResult->where('user_id', $userId);
        })->where('state', 'success')->sum('orders.quantity');
    }

    public function getQuantityMembersTotal($userId)
    {
        return $this->model->newQuery()->whereHas('campaign', function ($queryResult) use ($userId) {
            /** @var Builder $queryResult */
            $queryResult->whereHas('user', function ($queryResult2) use ($userId) {
                /** @var Builder $queryResult2 */
                $queryResult2->where('account_manager_id', $userId);
            });
        })->where('state', 'success')->sum('orders.quantity');
    }
}
