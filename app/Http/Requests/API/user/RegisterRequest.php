<?php

namespace App\Http\Requests\API\user;

use App\Enum\GenderStatus;
use App\Enum\UserStatus;
use App\Http\Requests\API\BaseRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class RegisterRequest extends BaseRequest
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
            'name'      => 'required|string|min:4|max:255',
            'email'     => 'required|email|unique:users,email|max:255',
            'phone'     => 'required|string|unique:users,phone|max:255',
            'password'  => 'required|confirmed|min:8',
            'fcm_token'  => 'required',
            'image'     => 'nullable|image|mimes:jpg,jpeg,png,svg',
            'username'  => 'required|string|unique:users,username|max:255',
            'birthdate' => 'required|date',
            'gender'    => ['required', Rule::enum(GenderStatus::class)],
            'country_id' => 'required|int|exists:countries,id',
            'city_id' => 'required|int|exists:cities,id',
            'area_id' => 'required|int|exists:areas,id', 
        ];
    }

    


}
