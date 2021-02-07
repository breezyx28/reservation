<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class ReservationRequest extends FormRequest
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
            'hospitalInfoID' => 'required|exists:hospital_info,id|integer',
            'servicesArray' => 'nullable|array',
            'atDay' => 'required|date',
            'note' => 'nullable|string|max:191',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'errors' => $validator->errors()], 200));
    }

    public function messages()
    {
        return [
            'hospitalInfoID.required' => 'hospitalInfoID name is required!',
            'atDay.required' => 'atDay name is required!',
        ];
    }
}
