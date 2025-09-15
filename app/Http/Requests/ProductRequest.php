<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File as RuleFile;

class ProductRequest extends FormRequest
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
          'brand_id' => ['required', 'integer'],
          'category_id' => ['nullable', 'integer'],
          'price' => ['nullable', 'numeric'],
          'image' => ['nullable', RuleFile::image()]
        ];
    }

    public function attributes(): array
    {
      return [
        'code' => 'Product Code',
        'name' => 'Product Name',
        'brand_id' => 'Brand',
        'category_id' => 'Category',
        'price' => 'Price',
        'image' => 'Product Image'
      ];
    }

    public function saveProduct(?Product $product = null)
    {
      if ($product === null){
        $product = new Product();
      }

      $formData = $this->validated();
      $picture = $this->file('image');
      if ($picture && $picture->isValid()){
        $ext = $picture->extension();
        $formData['image'] = $picture->storeAs('images/products', Str::slug($formData['name']) . '.' . $ext, 'public');
      }

      $formData['price'] = (float) $formData['price'];
      if ( !$formData['price']){
        $formData['price'] = null;
      }

      $product->fill($formData);

      return $product->save() ? $product:false;
    }
}
