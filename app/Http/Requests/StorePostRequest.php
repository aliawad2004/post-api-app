<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Response;

class StorePostRequest extends FormRequest
{
   
    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'The post title is required.',
            'title.string' => 'The post title must be a string.',
            'title.max' => 'The post title cannot exceed 255 characters.',
            'body.required' => 'The post content is required.',
            'body.string' => 'The post content must be a string.',
        ];
    }




    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator): void
    {
        $errors = (new ValidationException($validator))->errors();

        throw new HttpResponseException(
            Response::json([
                'success' => false,
                'message' => 'The submitted data failed validation.',
                'errors' => $errors
            ], 422) 
        );
    }
}