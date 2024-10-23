<?php

namespace App\Http\Requests\API\provider;

use App\Enum\GenderStatus;
use App\Http\Requests\API\BaseRequest;
use App\Models\Area;
use App\Models\City;
use App\Models\Country;
use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use function PHPSTORM_META\type;

class UpdateProfileRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth('provider')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = auth('provider')->user()->id;

        return [
            'image' => ['sometimes', 'image', 'mimes:png,jpg,jpeg'],
            'name' => ['sometimes', 'string', 'min:5', 'max:255'],
            'username' => ['sometimes', 'string', Rule::unique(Provider::class, 'username')->ignore($id), 'max:255'],
            'email' => ['sometimes', 'email', Rule::unique(Provider::class, 'email')->ignore($id)], 
            'phone' => ['sometimes', 'string', Rule::unique(Provider::class, 'phone')->ignore($id)],
            'birthdate' => ['sometimes', 'date'],
            'country_id' => ['sometimes', 'int', Rule::exists(Country::class, 'id')], 
            'city_id' => ['sometimes', 'int', Rule::exists(City::class, 'id')], 
            'area_id' => ['sometimes', 'int', Rule::exists(Area::class, 'id')], 
            'gender' => ['sometimes', 'string', Rule::enum(GenderStatus::class)], 
            
        ];
    }
}
