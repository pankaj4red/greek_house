<?php

namespace App\Repositories\Models;

use App\Models\CampaignLead;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Validation\Validator;

/**
 * @method CampaignLead make()
 * @method Collection|CampaignLead[] all($columns = ['*'], $with = null, $orderBy = null)
 * @method CampaignLead|null find($id)
 * @method CampaignLead create(array $parameters = [])
 */
class CampaignLeadRepository extends ModelRepository
{
    protected $modelClassName = CampaignLead::class;

    protected $rules = [
        'name'                    => 'max:255',
        'state'                   => 'max:255',
        'date'                    => 'date|nullable',
        'close_date'              => 'date|nullable',
        'flexible'                => 'in:yes,no',
        'promo_code'              => 'max:255',
        'estimated_quantity'      => '',
        'size_short'              => '',
        'contact_first_name'      => 'max:255',
        'contact_last_name'       => 'max:255',
        'contact_email'           => 'email',
        'contact_phone'           => 'max:255',
        'contact_school'          => 'max:255',
        'contact_chapter'         => 'max:255',
        'address_name'            => 'max:255',
        'address_line1'           => 'max:255',
        'address_line2'           => 'max:255',
        'address_city'            => 'max:255',
        'address_state'           => 'max:255',
        'address_zip_code'        => 'digits:5',
        'address_country'         => 'required',
        'design_type'             => 'in:screen,embroidery',
        'design_style_preference' => '',
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
        return array_merge($this->extraRules, parent::getRules($filter));
    }
}
