<?php

namespace App\Http\Requests\API\provider;

use App\Enum\GenderStatus;
use App\Http\Requests\API\BaseRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Provider;
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
            'name'          => 'required|string|min:4|max:255',
            'email'         => ['required', 'email', Rule::unique(Provider::class, 'email'), 'max:255'],
            'phone'         => ['required', 'string', Rule::unique(Provider::class, 'phone'), 'max:255'],
            'password'      => 'required|confirmed|min:8',
            'fcm_token'     => 'required',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png,svg',
            'username'      => ['required', 'string', Rule::unique(Provider::class, 'username'), 'max:255'],
            'birthdate'     => 'required|date',
            'gender'        => ['required', Rule::enum(GenderStatus::class)],
            'country_id'    => ['required', 'int', Rule::exists(Country::class, 'id')],
            'city_id'       => ['required', 'int', Rule::exists(City::class, 'id')],
            'area_id'       => ['required', 'int', Rule::exists(Area::class, 'id')], 
        ];
    }

}
