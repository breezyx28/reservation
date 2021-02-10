<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class UserReservForm extends FormRequest
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

    public function rules()
    {
        return [
            'labID' => 'required|exists:lab,id|integer',
            'labDiagnosisID' => 'required|exists:lab_diagnosis,id|integer',
            'services' => 'nullable|array',
            'note' => 'nullable|string|max:191'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['success' => false, 'errors' => $validator->errors()], 200));
    }

    public function messages()
    {
        return [
            'labID.required' => 'lab id is required!',
            'labDiagnosisID.required' => 'labDiagnosisID id is required!',
        ];
    }
}
