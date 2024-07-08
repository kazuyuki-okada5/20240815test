<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            'payment_method' => 'required|string',
            'shipping_address' => 'required|string',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'payment_method.required' => '支払い方法は必ず指定してください。',
            'payment_method.string' => '支払い方法は文字列で入力してください。',
            'shipping_address.required' => '配送先は必ず指定してください。',
            'shipping_address.string' => '配送先は文字列で入力してください。',
        ];
    }

    
}


