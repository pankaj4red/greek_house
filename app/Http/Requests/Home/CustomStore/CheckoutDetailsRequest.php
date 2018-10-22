<?php

namespace App\Http\Requests\Home\CustomStore;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class CheckoutDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'color'      => 'required|array',
            'quantity'   => 'required|array|same_size:color',
            'size'       => 'required|array|same_size:color',
            'color.*'    => 'integer',
            'quantity.*' => 'integer|min:1',
            'size.*'     => 'integer',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator $validator
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $campaign = $this->route('campaign_checkout');

        $validator->after(function (Validator $validator) use ($campaign) {
            foreach ($validator->getData()['size'] as $sizeId) {
                $productSize = product_size_repository()->find($sizeId);
                if (! $productSize) {
                    $validator->errors()->add('size', 'Invalid Size');
                }
            }

            foreach ($validator->getData()['color'] as $index => $colorId) {
                $productColor = product_color_repository()->find($colorId);
                if (! $productColor || $campaign->product_colors->where('id', $productColor->id)->count() == 0) {
                    $validator->errors()->add('color', 'Invalid Color');
                }

                $productSize = product_size_repository()->find($validator->getData()['size'][$index]);
                if ($productSize->product_id != $productColor->product_id) {
                    $validator->errors()->add('color', 'Size not available in selected Product');
                }
            }

            return $validator;
        });
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'quantity.required'  => 'You must add at least one product to the cart to continue',
            'quantity.array'     => 'Quantity is in the wrong format',
            'size.required'      => 'You must add at least one product to the cart to continue',
            'size.array'         => 'Size is in the wrong format',
            'color.required'     => 'You must add at least one color to the cart to continue',
            'color.array'        => 'Color is in the wrong format',
            'quantity.*.integer' => 'Quantity should be an integer',
            'size.*.integer'     => 'Size is in the wrong format',
            'color.*.array'      => 'Color is in the wrong format',
            'quantity.*.min'     => 'Quantity must be at least one',
        ];
    }
}
