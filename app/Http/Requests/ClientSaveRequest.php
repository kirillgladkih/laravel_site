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
            'parent_fio' => 'required|regex:/^[А-Яёа-яё]{3,}\s[А-Яёа-яё]{2,}\s[А-Яёа-яё]{3,}$/u',
            'child_fio'  => 'required|regex:/^[А-Яёа-яё]{3,}\s[А-Яёа-яё]{2,}\s[А-Яёа-яё]{3,}$/u',
            'phone'      => 'unique:procreators|required|regex:/^\+?[0-9]{11}$/',
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
