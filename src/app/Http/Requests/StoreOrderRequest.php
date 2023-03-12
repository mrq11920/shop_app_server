<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreOrderRequest extends FormRequest
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
            'user_address_id' => ['required', 'exists:user_addresses,id,deleted_at,NULL'],
            'shopping_session_id' => [
                'required',  Rule::exists('shopping_sessions', 'id')->where(function (Builder $query) {
                    return $query->where('valid', true)
                        ->where('total', '>', 0);
                }),
            ],
        ];
    }
}
