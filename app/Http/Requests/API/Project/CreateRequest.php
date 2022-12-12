<?php

namespace App\Http\Requests\API\Project;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class CreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'project_name' => 'required',
            'project_domain' => 'required',
            'project_description' => 'required',
            'documents.*' => 'required|image|mimes:png,jpg,jpeg'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (!request('documents')) {
            $validator->errors()->add('documents', 'The project documents field is required.');
        }

        $response = new JsonResponse([
            'errors' => $validator->errors(),
            'status_code' => 400
        ], 400);

        throw new ValidationException($validator, $response);
    }
}
