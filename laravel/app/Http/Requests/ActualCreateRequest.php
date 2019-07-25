<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualCreateRequest extends FormRequest
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
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'actual_date' => 'required|date',
            'start'       => 'required|date_format:H:i',
            'end'         => 'required|date_format:H:i|after:start',
            'site'        => 'nullable|string',
            'pmsales'     => 'nullable|string',
            'category'    => 'required|integer',
            'plan'        => 'required|integer',
        ];
    }
}
