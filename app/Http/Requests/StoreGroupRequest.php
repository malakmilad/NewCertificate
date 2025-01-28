<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGroupRequest extends FormRequest
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
            'name'=>'required|unique:groups,name',
            'file'=>'required|file|mimes:xlsx'
        ];
    }
    public function messages():array
    {
        return
        [
            'name.required'=>'group name is required',
            'name.unique'=>'change group name',
            'file.required'=>'file is required',
            'file.file'=>'file must be a file',
            'file.mimes'=>'file must be an xlsx file'
        ];
    }
}
