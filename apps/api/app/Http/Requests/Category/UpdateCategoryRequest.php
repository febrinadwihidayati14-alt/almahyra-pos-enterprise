<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if user is authorized.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Validation rules.
     */
    public function rules(): array
    {
        $category = $this->route('category');

        $id = is_object($category)
            ? $category->id
            : $category;

        return [

            'code' => [

                'required',

                'string',

                'max:30',

                Rule::unique('categories', 'code')
                    ->ignore($id),

            ],

            'name' => [

                'required',

                'string',

                'max:150',

                Rule::unique('categories', 'name')
                    ->ignore($id),

            ],

            'description' => [
                'nullable',
                'string',
            ],

            'active' => [
                'nullable',
                'boolean',
            ],

        ];
    }

    public function messages(): array
    {
        return [

            'code.required' => 'Kode kategori wajib diisi.',

            'code.unique' => 'Kode kategori sudah digunakan.',

            'name.required' => 'Nama kategori wajib diisi.',

            'name.unique' => 'Nama kategori sudah digunakan.',

        ];
    }
}
