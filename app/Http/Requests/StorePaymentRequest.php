<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'jenis_payment' => 'required|string|max:255',
            'nominal' => 'required|string|max:255',
            'bukti_transfer' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'jenis_payment.required' => 'Jenis payment wajib diisi',
            'nominal.required' => 'Nominal wajib diisi',
            'bukti_transfer.required' => 'Bukti transfer wajib diupload',
            'bukti_transfer.image' => 'Bukti transfer harus berupa gambar',
            'bukti_transfer.mimes' => 'Format gambar harus jpg, jpeg, atau png',
            'bukti_transfer.max' => 'Ukuran gambar maksimal 2MB',
        ];
    }
}
