<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlanUpdateRequest extends FormRequest
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
            'id'          => 'required|integer',
            'title'       => 'required|string',
            'description' => 'nullable|string',
            'start'       => 'required|date',
            'end'         => 'required|date|after_or_equal:start',
            'status'      => 'required|string|in:Ongoing,Failed,Pending,Completed',
            'project'     => 'nullable|integer',
            'category'    => 'required|integer',
            'subcategory' => 'required|integer',
            'important'   => 'nullable|in:on',
        ];
    }
}
