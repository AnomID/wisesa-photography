<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingAdminRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'telephone' => 'required|string|max:20',
            'address' => 'nullable|string',
            'booking_date' => 'required|date',
            'layanan_id' => 'required|exists:layanans,id',
            'sub_layanan_id' => 'nullable|exists:sub_layanans,id',
            'area' => 'nullable|string|max:255',
            'fotografer' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'booking_time' => 'required|string',
            'booking_end_time' => 'nullable|string',
            'biaya' => 'nullable|string|max:255',
            'lokasi_photo' => 'nullable|string|max:255',
            'universitas' => 'nullable|string|max:255',
            'status' => 'required|in:Pending,Ditolak,Diterima,Diproses,Selesai',
            // 'catatan' tidak disertakan karena dikelola via updateStatus method
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama pemesan wajib diisi',
            'telephone.required' => 'Nomor telepon wajib diisi',
            'booking_date.required' => 'Tanggal booking wajib dipilih',
            'booking_date.date' => 'Format tanggal tidak valid',
            'layanan_id.required' => 'Paket wajib dipilih',
            'layanan_id.exists' => 'Paket yang dipilih tidak ditemukan',
            'booking_time.required' => 'Waktu booking wajib diisi',
            'status.required' => 'Status wajib dipilih',
            'status.in' => 'Status tidak valid',
        ];
    }
}
