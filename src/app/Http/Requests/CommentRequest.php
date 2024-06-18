<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // 必要に応じて認証ロジックを追加
    }

    public function rules()
    {
        return [
            'comment' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'comment.required' => 'コメントを入力してください。',
            'comment.string' => 'コメントは文字列である必要があります。',
            'comment.max' => 'コメントは255文字以内で入力してください。',
        ];
    }
}
