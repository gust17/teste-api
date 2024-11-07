<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:pendente,em_andamento,concluída',
            'deadline' => 'nullable|date',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status deve ser um dos seguintes: pendente, em_andamento, concluída.', 
        ];
    }
}
