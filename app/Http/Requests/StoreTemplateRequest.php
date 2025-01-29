<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTemplateRequest extends FormRequest
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
            'template_name'=>'required|unique:templates,name',
            'template_image'=>'required|dimensions:width=1920,height=1080',
            'student_content'=>'required',
            'student_font_family'=>'required',
            'student_font_size'=>'required',
            'course_content'=>'required',
            'course_font_size'=>'required',
            'course_font_family'=>'required',
            'date_content'=>'required',
            'date_font_size'=>'required',
        ];
    }
    public function messages():array
    {
        return
        [
            'template_name.required'=>'title is required',
            'template_name.unique'=>'please write another title',
            'template_image.required'=>'certificate template is required',
            'template_image.dimensions'=>'certificate dimension must be 1920*1080',
            'student_content.required'=>'student field is required',
            'student_font_family.required'=>'student font family is required',
            'student_font_size.required'=>'student font size is required',
            'course_content.required'=>'course field is required',
            'course_font_size.required'=>'course font size is required',
            'course_font_family.required'=>'course font family required',
            'date_content.required'=>'date field required',
            'date_font_size.required'=>'date font size required',
        ];
    }
}
