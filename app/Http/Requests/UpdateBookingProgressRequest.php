<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingProgressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check() && in_array(auth()->user()->role, ['admin', 'superadmin']);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jadwal_foto' => 'nullable|boolean',
            'file_jpg_upload' => 'nullable|boolean',
            'file_jpg_link' => 'nullable|string',
            'selected_photos' => 'nullable|boolean',
            'selected_photos_link' => 'nullable|string',
            'file_raw_upload' => 'nullable|boolean',
            'editing_foto' => 'nullable|boolean',
            'foto_edited_upload' => 'nullable|boolean',
        ];
    }
}
