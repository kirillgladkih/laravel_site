<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChildSaveRequest extends FormRequest
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
            'procreator_id' => 'required|numeric',
            'fio'           => 'required|regex:/^[А-Яёа-яё]{3,}\s[А-Яёа-яё]{3,}\s[А-Яёа-яё]{3,}$/u',
            'age'           => 'required|numeric|min:4|max:14',
        ];
    }

    public function attributes()
    {
        return [
            'fio'  => 'фио ребенка',
            'phone'      => 'номер телефона',
            'age'        => 'возраст ребенка',
        ];
    }

}
