<?php

namespace Modules\Frontend\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;


class RegisterRequest extends FormRequest
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

    public function prepareForValidation()
    {
        // $this->merge([
        //     'phone_number' => preg_replace('/\D+/', '', $this->phone_number),
        // ]);
        if ($this->has('phone_number')) {
            $this->merge([
                'phone_number' => str_replace('+', '', $this->phone_number),
            ]);
        }
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $method = strtolower($this->method());
        $rules = [];
        switch ($method) {
            case 'post':
                $rules = [
                    'phone_number' => 'nullable|max:20|unique:users,phone_number',
                    'email' => 'required|max:191|email|unique:users',
                    'gender' => 'required',
                    'password' => 'required|string|min:6|confirmed',
                    'password_confirmation' => 'required|min:6|string',   
                    'age' => 'required|integer',
                    'weight' => 'required|numeric|min:0',
                    'weight_unit' => 'required|in:kg,lbs',
                    'height' => 'required|numeric|min:0',
                    'height_unit' => 'required|in:cm,feet',
                ];
            break;
        }

        return $rules;
    }

    public function messages()
    {
        return [
            
        ];
    }

     /**
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator){
        $data = [
            'status' => true,
            'message' => $validator->errors()->first(),
            'all_message' =>  $validator->errors()
        ];

        if ($this->ajax()) {
            throw new HttpResponseException(response()->json($data,422));
        } else {
            throw new HttpResponseException(redirect()->back()->withInput()->with('errors', $validator->errors()));
        }
    }


}
