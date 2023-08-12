<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //For employee table
            'im' => ['required', 'integer'],
            'lastName' => ['required', 'string'],
            'firstName' => ['required', 'string'],
            'address' => ['required', 'string'],
            'contact' => ['required', 'string'],
            'gender' => ['required', 'string'],
            'lastDegree' => ['required', 'string'],

            //For advancement table
            'class' => ['required', 'string'],
            'echelon' => ['required', 'integer'],
            'indice' => ['required', 'integer'],
            'category' => ['required', 'integer'],

            //For contract table
            'contractNumber' => ['required', 'string'],
            'contractType' => ['required', 'string'],
            'startDate' => ['required', 'date_format:d-m-Y'],
            'endDate' => ['required', 'date_format:d-m-Y'],
            'projectContractFilePath' => ['required', 'image'],

            //For avenants table
            'avenantNumber' => ['string', 'nullable'],
            'date' => ['nullable', 'date_format:d-m-Y'],
            'avenantFilePath' => ['image', 'nullable']
        ];
    }
}
