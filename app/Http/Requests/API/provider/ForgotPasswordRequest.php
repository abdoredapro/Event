<?php

namespace App\Http\Requests\API\provider;

use App\Http\Requests\API\BaseRequest;
use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

final class ForgotPasswordRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'phone' => ['required', 'string', Rule::exists(Provider::class, 'phone')],
        ];
    }
}