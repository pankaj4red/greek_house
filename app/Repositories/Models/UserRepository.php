<?php

namespace App\Repositories\Models;

use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

/**
 * @method User make()
 * @method Collection|User[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method User|null find($id)
 * @method User create(array $parameters = [])
 */
class UserRepository extends ModelRepository
{
    protected $modelClassName = User::class;

    protected $rules = [
        'first_name'       => 'required|max:255',
        'last_name'        => 'required|max:255',
        'chapter'          => 'required|max:250',
        'school'           => 'required|max:250',
        'school_year'      => '',
        'venmo_username'   => 'max:250',
        'password'         => 'required|confirmed|min:3',
        'activation_code'  => 'max:250',
        'decorator_status' => 'required|in:ON,OFF',
        'hourly_rate'      => 'regex:/[\d]+[\.]*[\d]{0,2}/',
        'on_hold_state'    => 'required|in:enabled,disabled',
        'type_code'        => 'required',
        'graduation_year'  => 'required',
    ];

    protected $extraRules = [];

    public function validate($data, $rules = null, $id = null)
    {
        $messages = [];
        $data = $data instanceof Request ? $data->all() : $data;
        $this->extraRules = [];
        if ($rules == null || in_array('phone', $rules)) {
            $data['phone'] = get_phone_digits($data['phone'], true);
            $this->extraRules['phone'] = 'required|digits:10';
            $messages['phone.digits'] = 'Contact Phone needs 10 digits';
        }
        if ($rules == null || in_array('email', $rules)) {
            $this->extraRules['email'] = 'required|email|max:255|unique:users,email'.($id ? (','.$id) : '');
        }
        if ($rules == null || in_array('username', $rules)) {
            $this->extraRules['username'] = 'required|max:255|unique:users,username'.($id ? (','.$id) : '');
        }

        $result = parent::validate($data, $rules, $messages);

        return $result;
    }

    public function getRules($filter = null)
    {
        return $this->extraRules + parent::getRules($filter);
    }

    /**
     * @param array|null $filters
     * @param array|null $orderBy
     * @param int|null   $page
     * @param int|null   $pageSize
     * @return User[]|Collection|LengthAwarePaginator
     */
    public function getListing($filters = null, $orderBy = null, $page = null, $pageSize = null)
    {
        $query = $this->model->newQuery();
        /** @var Builder $query */
        if (isset($filters['filter_name']) && $filters['filter_name']) {
            $query = $query->whereRaw('concat(first_name, " ", last_name) like ?', ['%'.$filters['filter_name'].'%']);
        }
        if (isset($filters['filter_id']) && $filters['filter_id']) {
            $query = $query->where('id', $filters['filter_id']);
        }
        if (isset($filters['filter_email']) && $filters['filter_email']) {
            $query = $query->whereRaw('email like ?', ['%'.$filters['filter_email'].'%']);
        }
        if (isset($filters['filter_phone']) && $filters['filter_phone']) {
            $query = $query->whereRaw('phone like ?', ['%'.$filters['filter_phone'].'%']);
        }
        if (isset($filters['filter_type']) && $filters['filter_type'] && $filters['filter_type'] != 'all') {
            $query = $query->where('type_code', $filters['filter_type']);
        }
        $this->queryOrderBy($query, $orderBy);

        return $this->queryPaginate($query, $page, $pageSize);
    }

    /**
     * @param $email
     * @param $code
     * @return User|null
     */
    public function findByEmailAndActivationCode($email, $code)
    {
        return $this->model->where('email', $email)->where('activation_code', $code)->first();
    }

    /**
     * @param string|null $printType
     * @return Collection|User[]
     */
    public function getActiveDecorators($printType = null)
    {
        $field = null;
        if ($printType == 'screen') {
            $field = 'decorator_screenprint_enabled';
        }
        if ($printType == 'embroidery') {
            $field = 'decorator_embroidery_enabled';
        }
        $query = $this->model->newQuery()->where('type_code', 'decorator')->where('decorator_status', 'ON')->where('active', true);
        if ($field != null) {
            $query->where($field, true);
        }

        return $query->get();
    }

    public function decoratorOptions($printType, $nullOption = [])
    {
        $decorators = user_repository()->getActiveDecorators($printType);
        $options = [] + $nullOption;
        foreach ($decorators as $decorator) {
            $options[$decorator->id] = $decorator->getFullName();
        }

        return $options;
    }

    /**
     * @param $id
     * @return bool
     */
    public function hasSuccessfulCampaigns($id)
    {
        return campaign_repository()->newQuery()->whereIn('state', [
                'fulfillment_ready',
                'fulfillment_validation',
                'printing',
                'shipped',
                'delivered',
            ])->where('user_id', $id)->count() > 0;
    }

    public function getDesigners()
    {
        return $this->model->newQuery()->whereIn('type_code', ['designer', 'junior_designer'])->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
    }

    public function getMembers($managerId)
    {
        return $this->model->newQuery()->where('account_manager_id', $managerId)->get();
    }

    /**
     * @param string|string[] $role
     * @return Collection|User[]
     */
    public function getByType($role)
    {
        if (is_array($role)) {
            $query = $this->model->newQuery()->whereIn('type_code', $role);
        } else {
            $query = $this->model->newQuery()->where('type_code', $role);
        }

        return $query->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
    }

    /**
     * @param string|string[] $userType
     * @param array           $nullOption
     * @return array
     */
    public function optionsByType($userType, $nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->getByType($userType);
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->getFullName();
        }

        return $options;
    }

    /**
     * @param array $nullOption
     * @return array
     */
    public function options($nullOption = [])
    {
        $options = $nullOption;
        $entries = $this->model->newQuery()->orderBy('first_name', 'asc')->orderBy('last_name', 'asc')->get();
        foreach ($entries as $entry) {
            $options[$entry->id] = $entry->getFullName().' ('.$entry->email.')';
        }

        return $options;
    }

    public function findByEmailOrUsername($username)
    {
        return $this->model->newQuery()->where('username', $username)->orWhere('email', $username)->first();
    }

    /**
     * @param string $email
     * @return User
     */
    public function findByEmail($email)
    {
        /** @noinspection PhpIncompatibleReturnTypeInspection */
        return $this->model->newQuery()->where('email', $email)->first();
    }

    /**
     * Returns new users to insert on salesforce
     *
     * @return Collection|User[]
     */
    public function getNewUsers()
    {
        return User::query()->with('campaigns')->whereNotNull('first_name')->whereNotNull('last_name')->whereNull('sf_id')->where('created_at', '>=', '2017-01-01')->get();
    }
}
