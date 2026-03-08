<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DefectRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'status_id' => 'required|exists:statuses,id',
            'product_no' => 'nullable|string|max:255',
            'part_no' => 'nullable|string|max:255',
            'part_name' => 'nullable|string|max:255',
            'serial_number' => 'nullable|string|max:255',
            'work_process' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'department_id' => 'required|exists:departments,id',
            'occurred_department_id' => 'nullable|exists:departments,id',
            'occurred_category_id' => 'nullable|exists:categories,id',
            'occurred_at' => 'required|date',
            // Images
            // 'images.*' => 'nullable|image|max:2048',
            'defect_images.*' => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => __('validation.defect_category_id.required'),
            'status_id.required' => __('validation.defect_status_id.required'),
            'occurred_at.required' => __('validation.defect_occurred_at.required'),
            'defect_images.*.image' => __('validation.defect_images.image'),
            'defect_images.*.max' => __('validation.defect_images.max'),
        ];
    }

}
