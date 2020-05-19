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
            'parent_fio' => 'required|regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u',
            'child_fio'  => 'required|regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u',
            'phone'      => 'required|unique:procreators|regex:/^\+?[0-9]{11}$/',
            'age'        => 'required|numeric|min:4|max:14',
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
