<?php

namespace App\Http\Requests;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      return $this->user()->role == 'admin';
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'name' => ['required', 'string'],
        ];
    }

    public function attributes(): array
    {
      return [
        'name' => 'Category Name',
      ];
    }

    public function saveCategory(?Category $category = null)
    {
      if ($category === null){
        $category = new Category();
      }
      $formData = $this->validated();
      $category->fill($formData);

      return $category->save() ? $category:false;
    }
}
