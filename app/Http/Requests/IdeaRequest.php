<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\IdeaStatus;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class IdeaRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::enum(IdeaStatus::class)],
            'links' => ['nullable', 'array'],
            'links.*' => ['max:255', 'url'],
            'steps' => ['nullable', 'array'],
            'steps.*.id' => ['nullable', 'integer'],
            'steps.*.description' => ['max:255', 'string'],
            'steps.*.completed' => ['required', 'boolean'],
            'image' => ['nullable', 'image', 'max:5120'],
        ];
    }
}
