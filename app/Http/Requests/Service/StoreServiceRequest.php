<?php

namespace App\Http\Requests\Service;

use App\Http\Requests\API\BaseRequest;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreServiceRequest extends BaseRequest
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
        return [
            'category_id' => ['required', 'int', Rule::exists(Category::class, 'id')],
            'sub_category_id' => ['required','int', Rule::exists(SubCategory::class, 'id')],
            'name' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:png,jpg,jpeg'],
            'price' => ['required', 'numeric'],
            'description' => ['required', 'string'], 
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }
}
