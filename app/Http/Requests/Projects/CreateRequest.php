<?php

namespace App\Http\Requests\Projects;

use App\Entities\Projects\Project;
use App\Http\Requests\Request;

class CreateRequest extends Request
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
            'name'           => 'required|max:50',
            'proposal_date'  => 'nullable|date|date_format:Y-m-d',
            'proposal_value' => 'nullable|numeric',
            'customer_id'    => 'nullable|numeric', 
            'description'    => 'nullable|max:255',
        ];
    }

    public function messages()
    {
        return [
            'customer_name.required_without'  => 'Nama Customer.',
            'customer_email.required_without' => 'Email Customer.',
        ];
    }
}
