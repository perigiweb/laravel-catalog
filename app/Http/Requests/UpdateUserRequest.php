<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
      return (($this->route('account') && $this->user()->id == $this->route('account')->id) || $this->user()->role == 'admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
          'email' => ['required', 'email', Rule::unique(User::class)->ignore($this->route('account'))],
          'name' => ['required']
        ];
    }

    public function updateUser(User $user)
    {
      $formData = $this->safe();

      $user->name = $formData['name'];
      $user->email = $formData['email'];
      if (isset($formData['password']) && $formData['password'] != ''){
        $user->password = $formData['password'];
      }

      return $user->save();
    }
}
