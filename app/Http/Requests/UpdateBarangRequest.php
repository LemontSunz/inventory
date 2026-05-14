<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBarangRequest extends FormRequest
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
        return [
            'kode_barang' => 'required|string|unique:barang,kode_barang,' . $this->barang->id . '|max:50',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'satuan' => 'required|string|max:50',
            'stok' => 'required|integer|min:0',
            'lokasi_rak' => 'required|string|max:100',
            'deskripsi' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'kode_barang.required' => 'Kode barang harus diisi.',
            'kode_barang.unique' => 'Kode barang sudah tersedia di sistem.',
            'nama_barang.required' => 'Nama barang harus diisi.',
            'nama_barang.max' => 'Nama barang maksimal 255 karakter.',
            'kategori.required' => 'Kategori harus dipilih.',
            'satuan.required' => 'Satuan harus dipilih.',
            'stok.required' => 'Stok harus diisi.',
            'stok.integer' => 'Stok harus berupa angka.',
            'stok.min' => 'Stok tidak boleh kurang dari 0.',
            'lokasi_rak.required' => 'Lokasi rak harus diisi.',
            'deskripsi.max' => 'Deskripsi maksimal 1000 karakter.',
        ];
    }
}
