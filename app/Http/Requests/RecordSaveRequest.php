<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecordSaveRequest extends FormRequest
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
        $now = date('Y-m-d', strtotime('-1 day'));
        $end = date('Y-m-d', strtotime('+15 day'));

        return [
            'record_date' => "after:$now|before:$end"
        ];
    }

    public function attributes()
    {
        return [
            'record_date' => 'Дата записи'
        ];
    }
}
