<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'telephone' => 'required|string|max:255',
            'area' => 'required|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'address' => 'required|string',
            'layanan_id' => 'required|exists:layanans,id',
            'sub_layanan_id' => 'nullable|exists:sub_layanans,id',
            'booking_date' => 'required|date|after_or_equal:today',
            'booking_time' => 'required',
            'booking_end_time' => 'required|after:booking_time',
            'universitas' => 'required|string|max:255',
            'lokasi_photo' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi',
            'telephone.required' => 'Nomor telepon wajib diisi',
            'area.required' => 'Area wajib diisi',
            'address.required' => 'Alamat wajib diisi',
            'layanan_id.required' => 'Layanan wajib dipilih',
            'layanan_id.exists' => 'Layanan tidak valid',
            'sub_layanan_id.exists' => 'Sub layanan tidak valid',
            'booking_date.required' => 'Tanggal booking wajib diisi',
            'booking_date.after_or_equal' => 'Tanggal booking tidak boleh kurang dari hari ini',
            'booking_time.required' => 'Waktu mulai wajib diisi',
            'booking_end_time.required' => 'Waktu selesai wajib diisi',
            'booking_end_time.after' => 'Waktu selesai harus setelah waktu mulai',
            'universitas.required' => 'Universitas wajib diisi',
            'lokasi_photo.required' => 'Lokasi photo wajib diisi',
        ];
    }
}
