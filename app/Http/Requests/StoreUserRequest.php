<?php

namespace App\Http\Requests;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUserRequest extends FormRequest
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
        'email' => ['required', 'email', Rule::unique(User::class)],
        'password' => ['required'],
        'name' => ['required']
      ];
    }

    public function addUser(){
      $formData = $this->validated();
      $formData['role'] = 'admin';
      $formData['email_verified_at'] = Carbon::now();

      return User::create($formData);
    }
}
