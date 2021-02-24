<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class HospitalRequest extends FormRequest
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
            'name' => 'required|string',
            'password' => 'required|string',
            'phone' => 'required|unique:doa.users_holder,userPhoneNumber|digits:10',
            'email' => 'nullable|regex:/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$/',
            'state' => 'required|string',
            'city' => 'nullable|string',
            'address' => 'nullable|string',
            'lat' => 'nullable|between:-90,90',
            'lng' => 'nullable|between:-180,80',
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
            'name.required' => 'حقل الإسم مطلوب',
            'password.required' => 'حقل كلمة السر مطلوب',
            'phone.required' => 'حقل رقم الهاتف مطلوب',
            'state.required' => 'حقل الولاية مطلوب',
            'city.required' => 'حقل المدينة مطلوب',
            'address.required' => 'حقل العنوان مطلوب',
        ];
    }
}
