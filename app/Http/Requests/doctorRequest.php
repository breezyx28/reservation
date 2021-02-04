<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class doctorRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'fullName' => 'required|string',
            'gender' => ['required', Rule::in(['ذكر', 'انثى'])],
            'phone' => 'required|unique:doctor,phone|digits:10',
            'email' => 'nullable|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/',
        ];
    }

    /**
     * If validator fails return the exception in json form
     * @param Validator $validator
     * @return array
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'errors' => $validator->errors()], 200));
    }

    public function messages()
    {
        return [
            'fullName.required' => 'حقل الإسم مطلوب',
            'phone.required' => 'حقل رقم الهاتف مطلوب',
            'gender.required' => 'حقل النوع مطلوب',
        ];
    }
}
