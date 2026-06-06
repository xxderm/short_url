<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUrlRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'url' => [
                'required',
                'string',
                'url',
                'max:2048',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $scheme = parse_url($value, PHP_URL_SCHEME);

                    if (!in_array($scheme, ['http', 'https'], true)) {
                        $fail('URL-адрес должен быть допустимым HTTP или HTTPS URL-адресом');
                    }
                }
            ]
        ];
    }
}