<?php

namespace App\Http\Requests;

use App\Models\InstructionPage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File as RuleFile;

class StoreInstructionPageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'title' => ['required', 'string'],
          'picture' => ['nullable', RuleFile::image()]
        ];
    }

    public function createInstructionPage()
    {
      $formData = $this->validated();
      $picture = $this->file('picture');
      if ($picture && $this->file('picture')->isValid()){
        $ext = $picture->extension();
        $formData['picture'] = $picture->storeAs('images', time() . '-' . Str::slug($formData['title']) . '.' . $ext, 'public');
      }

      return InstructionPage::create($formData);
    }
}
