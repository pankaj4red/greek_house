<?php

namespace App\Repositories\Models;

use App\Models\BillingTransaction;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

/**
 * @method BillingTransaction make()
 * @method Collection|BillingTransaction[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method BillingTransaction|null find($id)
 * @method BillingTransaction create(array $parameters = [])
 */
class BillingTransactionRepository extends ModelRepository
{
    protected $modelClassName = BillingTransaction::class;

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return Collection|BillingTransaction[]
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery()->with(['order.campaign', 'order.user']);
        if (isset($filters['filter_transaction_id']) && $filters['filter_transaction_id']) {
            $query = $query->where('id', $filters['filter_transaction_id']);
        }
        if (isset($filters['filter_campaign_id']) && $filters['filter_campaign_id']) {
            $query = $query->whereHas('order', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->where('campaign_id', $filters['filter_campaign_id']);
            });
        }
        if (isset($filters['filter_campaign_name']) && $filters['filter_campaign_name']) {
            $query = $query->whereHas('order', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->whereHas('campaign', function ($queryInner2) use ($filters) {
                    /** @var Builder $queryInner2 */
                    $queryInner2->where('name', 'like', '%'.$filters['filter_campaign_name'].'%');
                });
            });
        }
        if (isset($filters['filter_user_name']) && $filters['filter_user_name']) {
            $query = $query->whereHas('order', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->whereHas('user', function ($queryInner2) use ($filters) {
                    /** @var Builder $queryInner2 */
                    $queryInner2->whereRaw("concat(first_name, ' ', last_name) like ?", ['%'.$filters['filter_user_name'].'%']);
                });
            });
        }
        if (isset($filters['filter_order_id']) && $filters['filter_order_id']) {
            $query = $query->where('order_id', $filters['filter_order_id']);
        }
        if (isset($filters['filter_campaign_state']) && $filters['filter_campaign_state']) {
            $query = $query->whereHas('order', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->whereHas('campaign', function ($queryInner2) use ($filters) {
                    /** @var Builder $queryInner2 */
                    $queryInner2->where('state', $filters['filter_campaign_state']);
                });
            });
        }
        if (isset($filters['filter_order_state']) && $filters['filter_order_state']) {
            $query = $query->whereHas('order', function ($queryInner) use ($filters) {
                /** @var Builder $queryInner */
                $queryInner->where('state', $filters['filter_order_state']);
            });
        }
        if (isset($filters['filter_created_from']) && $filters['filter_created_from']) {
            $query->where('billing_transactions.created_at', '>=', date('Y-m-d', strtotime($filters['filter_created_from'])));
        }
        if (isset($filters['filter_created_to']) && $filters['filter_created_to']) {
            $query->where('billing_transactions.created_at', '<=', date('Y-m-d', strtotime($filters['filter_created_to'])));
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }
}
