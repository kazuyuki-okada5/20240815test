<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemCreateRequest extends FormRequest
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
            'price' => 'required|numeric|min:0|max:9999999999',
            'comment' => 'required|string|min:20',
            'brand' => 'nullable|string|max:255',
            'condition' => 'required|string|exists:conditions,condition',
            'category1' => 'required|integer|exists:categories,id',
            'category2' => 'nullable|integer|exists:categories,id',
            'category3' => 'nullable|integer|exists:categories,id',
            'image_url' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',
            'name.string' => '商品名は文字列で入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',
            'price.required' => '価格は必須です。',
            'price.numeric' => '価格は数値で入力してください。',
            'price.min' => '価格は0以上で入力してください。',
            'price.max' => '価格は9999999999以下で入力してください。',
            'comment.required' => '商品の説明は必須です。',
            'comment.string' => '商品の説明は文字列で入力してください。',
            'comment.min' => '商品の説明は20文字以上で入力してください。',
            'brand.string' => 'ブランドは文字列で入力してください。',
            'brand.max' => 'ブランドは255文字以内で入力してください。',
            'condition.required' => '商品の状態を選択してください。',
            'condition.string' => '商品の状態は文字列で入力してください。',
            'condition.exists' => '選択された商品の状態は無効です。',
            'category1.required' => 'カテゴリーを選択してください。',
            'category1.string' => 'カテゴリーは文字列で入力してください。',
            'category1.exists' => '選択されたカテゴリーは無効です。',
            'category2.required' => 'カテゴリーを選択してください。',
            'category2.string' => 'カテゴリーは文字列で入力してください。',
            'category2.exists' => '選択されたカテゴリーは無効です。',
            'category3.required' => 'カテゴリーを選択してください。',
            'category3.string' => 'カテゴリーは文字列で入力してください。',
            'category3.exists' => '選択されたカテゴリーは無効です。',
            'image_url.required' => '商品画像は必須です。',
            'image_url.image' => '有効な画像ファイルを選択してください。',
            'image_url.mimes' => '画像形式はjpeg、png、jpg、gifのいずれかを選択してください。',
            'image_url.max' => 'アップロード可能な最大サイズは2MBです。',
        ];
    }
}