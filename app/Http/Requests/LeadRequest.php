<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LeadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $phone = preg_replace('/[^0-9+]/', '', (string)$this->input('phone'));

        if (str_starts_with($phone, '80')) {
            $phone = '+375' . substr($phone, 2);
        }

        $this->merge(['phone' => $phone]);
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'regex:/^\+375(17|25|29|33|44)\d{7}$/'],
            'interest' => ['required', 'string', 'in:subscription,order,question'],
            'comment' => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Пожалуйста, укажите ваше имя.',
            'name.string' => 'Имя должно быть текстом.',
            'name.max' => 'Имя слишком длинное.',

            'phone.required' => 'Пожалуйста, укажите номер телефона.',
            'phone.regex' => 'Введите корректный белорусский номер (например, +375291234567).',

            'interest.required' => 'Пожалуйста, выберите, что вас интересует.',
            'interest.in' => 'Выбрано неверное значение.',

            'comment.max' => 'Комментарий слишком длинный (максимум 1000 символов).',
        ];
    }
}