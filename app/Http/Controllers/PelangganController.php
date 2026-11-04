<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use App\Models\Pelanggan;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['dataPelanggan'] = Pelanggan::all();
        return view('admin.pelanggan.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.pelanggan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'birthday'   => 'required|date',
            'gender'     => 'required|in:Male,Female',
            'email'      => 'required|email|unique:pelanggan,email',
            'phone'      => 'required|numeric',
        ], $this->messages());

        Pelanggan::create($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Penambahan Data Berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data['dataPelanggan'] = Pelanggan::findOrFail($id);
        return view('admin.pelanggan.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'birthday'   => 'required|date',
            'gender'     => 'required|in:Male,Female',
            // email harus unik, kecuali untuk data pelanggan yang sedang diedit
            'email'      => [
                'required',
                'email',
                Rule::unique('pelanggan', 'email')->ignore($pelanggan->pelanggan_id, 'pelanggan_id'),
            ],
            'phone'      => 'required|numeric',
        ], $this->messages());

        $pelanggan->update($validated);

        return redirect()->route('pelanggan.index')->with('success', 'Perubahan Data Berhasil!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $pelanggan->delete();

        return redirect()->route('pelanggan.index')->with('success', 'Data berhasil dihapus');
    }

    /**
     * Pesan error validasi (Bahasa Indonesia).
     */
    private function messages(): array
    {
        return [
            'first_name.required' => 'First name wajib diisi.',
            'last_name.required'  => 'Last name wajib diisi.',
            'birthday.required'   => 'Birthday wajib diisi.',
            'birthday.date'       => 'Birthday harus berupa tanggal.',
            'gender.required'     => 'Gender wajib diisi.',
            'gender.in'           => 'Gender hanya boleh bernilai Male atau Female.',
            'email.required'      => 'Email wajib diisi.',
            'email.email'         => 'Format email tidak valid.',
            'email.unique'        => 'Email sudah digunakan.',
            'phone.required'      => 'Phone wajib diisi.',
            'phone.numeric'       => 'Phone harus berupa angka.',
        ];
    }
}
