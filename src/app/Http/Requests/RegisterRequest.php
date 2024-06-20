<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|string|max:255',
            'password' => 'required|string|min:8|max:255|confirmed',
        ];
    }
    /**
     * バリデーションエラーメッセージをカスタマイズします。
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'お名前は必須です。',
            'name.string' => 'お名前は文字列である必要があります。',
            'name.max' => 'お名前は255文字以内である必要があります。',
            'email.required' => 'メールアドレスは必須です。',
            'email.email' => '有効なメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは既に登録されています。',
            'email.string' => 'メールアドレスは文字列である必要があります。',
            'email.max' => 'メールアドレスは255文字以内である必要があります。',
            'password.required' => 'パスワードは必須です。',
            'password.min' => 'パスワードは8文字以上である必要があります。',
            'password.max' => 'パスワードは255文字以内である必要があります。',
            'password.confirmed' => '確認用パスワードが一致しません。',
        ];
    }
}
