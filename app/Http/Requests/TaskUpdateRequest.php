<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskUpdateRequest extends FormRequest
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
        $task = $this->route('task');

        return [
            'task' => 'required|min:10|max:200',
            'begindate' => 'required|date',
            'enddate' => 'nullable|date',
            'user_id' => 'nullable|exists:users,id',
            'project_id' => 'required|integer|exists:projects,id',
            'activity_id' => 'required|integer|exists:activities,id',
        ];
    }
}
