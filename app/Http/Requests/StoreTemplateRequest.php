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
            'template_name'=>'required|unique:templates,template_name',
            'template_image'=>'required|dimensions:width=1920,height=1080',
            'student_content'=>'required',
            'student_font_family'=>'required',
            'student_font_size'=>'required',
            'course_content'=>'required',
            'course_font_size'=>'required',
            'course_font_family'=>'required',
            'date_content'=>'required',
            'date_font_size'=>'required',
            'date_font_family'=>'required',
        ];
    }
    public function messages():array
    {
        return
        [
            'template_name.required'=>'required',
            'template_name.unique'=>'please write another name',
            'template_image.required'=>'required',
            'template_image.dimensions'=>'must 1920*1080',
            'student_content.required'=>'required',
            'student_font_family.required'=>'required',
            'student_font_size.required'=>'required',
            'course_content.required'=>'required',
            'course_font_size.required'=>'required',
            'course_font_family.required'=>'required',
            'date_content.required'=>'required',
            'date_font_size.required'=>'required',
            'date_font_family.required'=>'required',
        ];
    }
}
