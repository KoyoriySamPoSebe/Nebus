<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndexOrganizationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'building_id' => 'nullable|integer|exists:buildings,id',
            'activity_id' => 'nullable|integer|exists:activities,id',
            'name'        => 'nullable|string|max:255',
            'per_page'    => 'nullable|integer|min:1',
        ];
    }
}
