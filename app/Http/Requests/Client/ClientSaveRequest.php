<?php

namespace App\Http\Requests\Client;

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
            'parent_fio' => 'regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u',
            'child_fio'  => 'regex:/^[А-Яа-я]{3,}\s[А-Яа-я]{3,}\s[А-Яа-я]{3,}$/u',
            'phone'      => 'regex:/^\+\*d{11}$/',
            'age'        => 'numeric|min:4|max:14',
            't'          => 'required'
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

    public function messages()
    {
        return [
            'parent_fio.regex' => ':attr введен неверно',
            'child_fio.regex'  => ':attr введен неверно',
            'phone.regex'      => ':attr введен неверно',
            'age'              => ':attr введен неверно',
        ];
    }

    public function wantsJson()
    {
        return true;
    }
  
}
