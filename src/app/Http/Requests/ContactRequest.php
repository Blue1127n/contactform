<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
    protected function prepareForValidation()
    {
        $this->merge([
            'phone_number' => $this->input('phone_part1') . $this->input('phone_part2') . $this->input('phone_part3'),
            ]);
    }

    public function rules()
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],
            'first_name' => ['required','string','max:255'],
            'last_name' => ['required','string','max:255'],
            'gender' => ['required','in:1,2,3'],
            'email' => ['required','email','max:255'],
            'phone_number' => ['required', 'regex:/^\d{2,5}\d{2,5}\d{2,5}$/'],
            'address' => ['required','string','max:255'],
            'building' => ['nullable','string','max:255'],
            'detail' => ['required','string','max:120'],
        ];
    }

    public function messages()
    {
        return[
            'category_id.required' => 'お問い合わせの種類を選択してください',
            'category_id.exists' => 'お問い合わせの種類を選択してください',
            'first_name.required' => '姓を入力してください',
            'last_name.required' => '名を入力してください',
            'gender.required' => '性別を選択してください',
            'gender.in' => '性別を選択してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => 'メールアドレスはメール形式で入力してください',
            'phone_number.required'  => '電話番号を入力してください',
            'phone_number.regex' => '電話番号は5桁までの数字で入力してください',
            'address.required' => '住所を入力してください',
            'detail.required' => 'お問い合わせ内容を入力してください',
            'detail.max' => 'お問い合わせ内容は120文字以内で入力してください',
        ];
    }
}