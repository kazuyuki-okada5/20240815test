<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\ShippingChange;

class ShippingChangeRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'post_code' => 'required|numeric|digits:7',
            'address' => 'required|string|max:255',
            'building' => 'nullable|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'post_code.required' => '郵便番号は必須です。',
            'post_code.numeric' => '郵便番号は数値で入力してください。',
            'post_code.digits' => '郵便番号は7桁で入力してください。',
            'address.required' => '住所は必須です。',
            'address.string' => '住所は文字列で入力してください。',
            'address.max' => '住所は255文字以内で入力してください。',
            'building.string' => '建物名は文字列で入力してください。',
            'building.max' => '建物名は255文字以内で入力してください。'
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $user = Auth::user();
            $address = $this->input('address');
            $post_code = $this->input('post_code');

            $existingShipping = ShippingChange::where('item_id', $item_id)
                                              ->where('address', $address)
                                              ->where('post_code', $post_code)
                                              ->first();

            if ($existingShipping) {
                $validator->errors()->add('address', 'この配送先は既に登録されています。');
            }
        });
    }
}
