<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanRequest extends FormRequest
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
            'id'          => 'sometimes|required|integer',
            'title'       => 'required|string',
            'description' => 'nullable',
            'start'       => 'required|date',
            'end'         => 'required|date|after_or_equal:start',
            'category'    => 'required|integer',
            'assignee'    => 'nullable|integer',
            'project'     => 'nullable|integer'
        ];
    }
}
