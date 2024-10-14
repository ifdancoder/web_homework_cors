<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateUserRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'password_confirmation' => ['required', 'string', 'min:8', 'same:password'],
            'remember_me' => [],
        ];
    }


    public function messages(): array
    {
        return [
            'first_name.required' => 'Имя не может быть пустым',
            'first_name.string' => 'Имя должно быть строкой',
            'first_name.max' => 'Имя должно содержать не более 255 символов',

            'last_name.required' => 'Фамилия не может быть пустой',
            'last_name.string' => 'Фамилия должно быть строкой',
            'last_name.max' => 'Фамилия должно содержать не более 255 символов',

            'email.required' => 'Email не может быть пустым',
            'email.string' => 'Email должен быть строкой',
            'email.email' => 'Email должен быть действительным адресом электронной почты',
            'email.max' => 'Email должен содержать не более 255 символов',
            'email.unique' => 'Такой email уже существует',

            'password.required' => 'Пароль не может быть пустым',
            'password.string' => 'Пароль должен быть строкой',
            'password.min' => 'Пароль должен содержать не менее 8 символов',

            'password_confirmation.required' => 'Подтверждение пароля не может быть пустым',
            'password_confirmation.string' => 'Подтверждение пароля должно быть строкой',
            'password_confirmation.min' => 'Подтверждение пароля должен содержать не менее 8 символов',
            'password_confirmation.same' => 'Пароли не совпадают',
        ];
    }
}
