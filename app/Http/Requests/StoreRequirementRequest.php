<?php

namespace App\Http\Requests;

use App\Models\RequirementType;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequirementRequest extends FormRequest
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
        $rules = [
            'status' => 'required|in:1,2,3',
            'enrollment_id' => 'required|exists:enrollments,id',
            'semester_id' => 'required|exists:semesters,id',
            'requirement_type_id' => 'required|exists:requirement_types,id',
            'weekdays.*' => 'exists:weekdays,id'
        ];

        if ($this->requirement_type_id == RequirementType::where('description', 'Segunda via')->first()->id)
            $rules['justification'] = 'required';

        return $rules;
    }
}
