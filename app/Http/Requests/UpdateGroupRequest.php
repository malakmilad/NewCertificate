<?php

namespace App\Http\Requests;

use App\Models\Group;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Vinkla\Hashids\Facades\Hashids;

class UpdateGroupRequest extends FormRequest
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
        $name = $this->request->get('name');
        $group   = Group::Where('name',$name)->first();
        $group = Group::find($group->id);
        return [
            'name' => [
            'required',
            Rule::unique('groups')->ignore($group),
        ],
            'file'=>'required|file|mimes:xlsx'
        ];
    }
}
