<?php

namespace App\Http\Requests;

use App\Models\Brand;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File as RuleFile;

class BrandRequest extends FormRequest
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
        'code' => ['required'],
        'name' => ['required', 'string'],
        'logo' => ['nullable', RuleFile::image()]
      ];
    }

    public function attributes(): array
    {
      return [
        'code' => 'Brand Code',
        'name' => 'Brand Name',
        'logo' => 'Brand Logo'
      ];
    }

    public function saveBrand(?Brand $brand = null)
    {
      if ($brand === null){
        $brand = new Brand();
      }
      $formData = $this->validated();
      $picture = $this->file('logo');
      if ($picture && $picture->isValid()){
        $ext = $picture->extension();
        $formData['logo'] = $picture->storeAs('images/brands', Str::slug($formData['name']) . '.' . $ext, 'public');
      }

      $brand->fill($formData);

      return $brand->save() ? $brand:false;
    }
}
