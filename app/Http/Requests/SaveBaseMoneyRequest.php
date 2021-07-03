<?php

namespace App\Http\Requests;

use App\Models\BaseMoney;
use Illuminate\Foundation\Http\FormRequest;

class SaveBaseMoneyRequest extends FormRequest
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
            "action_type" => "required",
            "id_denomination_money" => "required",
            "id_payments" => ""
        ];
    }
}
