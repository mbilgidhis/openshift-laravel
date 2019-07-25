<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImportUser extends FormRequest
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
            'file'       => 'required|file',
            'password'   => 'required|string|min:8',
            'department' => 'nullable|integer',
            'team'       => 'nullable|integer',
            'role'       => 'nullable|integer',
        ];
    }
}
