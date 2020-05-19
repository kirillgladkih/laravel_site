<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientSaveRequest extends FormRequest
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
            'parent_fio' => 'regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u|required',
            'child_fio'  => 'regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u|required',
            'phone'      => 'unique:procreators|regex:/^\+?[0-9]{11}$/|required',
            'age'        => 'numeric|min:4|max:14|required',
        ];
    }

    public function attributes()
    {
        return [
            'parent_fio' => 'фио родителя',
            'child_fio'  => 'фио ребенка',
            'phone'      => 'номер телефона',
            'age'        => 'возраст ребенка',
        ];
    }
}
