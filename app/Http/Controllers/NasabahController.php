<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;

class NasabahController extends Controller
{
    /**
     * Display a listing of the nasabahs.
     */
    public function index()
    {
        $nasabahs = Nasabah::paginate(5); // Pagination untuk 5 data per halaman

        // Format kelas dan jurusan
        foreach ($nasabahs as $nasabah) {
            $nasabah->kelas_jurusan = $nasabah->kelas . ' ' . $nasabah->jurusan;
            if (!empty($nasabah->angka_kelas) && $nasabah->angka_kelas !== 'Tidak Ada') {
                $nasabah->kelas_jurusan .= ' ' . $nasabah->angka_kelas;
            }
        }

        return view('nasabah', compact('nasabahs'));
    }

    /**
     * Show the form for creating a new nasabah.
     */
    public function create()
    {
        $classes = ['X', 'XI', 'XII'];
        $majors = ['PPLG', 'AN', 'TJKT', 'DKV', 'AKL', 'BR', 'LPS', 'DPB', 'MP'];

        return view('nasabah.create', compact('classes', 'majors'));
    }

    /**
     * Store a newly created nasabah in the database.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'foto_kartu_pelajar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'no_identitas' => 'required|string|max:255|unique:nasabahs,no_identitas',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:15',
            'kelas' => 'required|string',
            'jurusan' => 'required|string',
            'angka_kelas' => 'required',
            'saldo' => 'required|numeric',
        ]);

        // Upload foto kartu pelajar
        if ($request->hasFile('foto_kartu_pelajar')) {
            $fotoKartuPelajarPath = $request->file('foto_kartu_pelajar')->store('foto_kartu_pelajar', 'public');
        } else {
            return redirect()->back()->withErrors(['foto_kartu_pelajar' => 'Gagal mengunggah foto.']);
        }

        // Buat ID Nasabah unik
        $jurusanPPLG = ['PPLG', 'AN', 'TJKT', 'DKV'];
        $prefix = in_array($request->jurusan, $jurusanPPLG) ? 'AM1' : 'AM2';
        $lastFourDigits = substr($request->no_telepon, -4);
        $yearAndMonth = date('Ymd', strtotime($request->tanggal_lahir));

        // Pastikan ID Nasabah unik
        do {
            $id_nasabah = $prefix . '-' . $lastFourDigits . $yearAndMonth . '-' . str_pad(rand(1, 999), 3, '0', STR_PAD_LEFT);
        } while (Nasabah::where('id_nasabah', $id_nasabah)->exists());

        // Simpan data nasabah
        Nasabah::create([
            'id_nasabah' => $id_nasabah,
            'nama' => $request->nama,
            'foto_kartu_pelajar' => $fotoKartuPelajarPath,
            'no_identitas' => $request->no_identitas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telepon' => $request->no_telepon,
            'kelas' => $request->kelas,
            'jurusan' => $request->jurusan,
            'angka_kelas' => $request->angka_kelas !== 'Tidak Ada' ? $request->angka_kelas : null,
            'saldo' => $request->saldo,
        ]);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil ditambahkan.');
    }

    /**
     * Display the specified nasabah.
     */
    public function show($id)
    {
        $nasabah = Nasabah::with(['penarikan', 'setorans'])->findOrFail($id);

        return view('nasabah.show', compact('nasabah'));
    }

    /**
     * Show the form for editing the specified nasabah.
     */
    public function edit(Nasabah $nasabah)
    {
        $classes = ['X', 'XI', 'XII'];
        $majors = ['PPLG', 'AN', 'TJKT', 'DKV', 'AKL', 'BR', 'LPS', 'DPB', 'MP'];

        return view('nasabah.edit', compact('nasabah', 'classes', 'majors'));
    }

    /**
     * Update the specified nasabah in the database.
     */
    public function update(Request $request, Nasabah $nasabah)
    {
        $validated = $request->validate([
            'id_nasabah' => 'required|unique:nasabahs,id_nasabah,' . $nasabah->id,
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:15',
            'kelas' => 'required|in:X,XI,XII',
            'jurusan' => 'required|in:PPLG,AN,TJKT,DKV,AKL,BR,LPS,DPB,MP',
            'saldo' => 'required|numeric|min:0',
            'foto_kartu_pelajar' => 'nullable|image|mimes:jpg,png,jpeg|max:2048',
        ]);

        // Update foto kartu pelajar jika ada
        if ($request->hasFile('foto_kartu_pelajar')) {
            $fotoPath = $request->file('foto_kartu_pelajar')->store('foto_kartu_pelajar', 'public');
            $validated['foto_kartu_pelajar'] = $fotoPath;
        }

        // Update angka_kelas
        $validated['angka_kelas'] = $request->angka_kelas !== 'Tidak Ada' ? $request->angka_kelas : null;

        $nasabah->update($validated);

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil diupdate!');
    }

    /**
     * Remove the specified nasabah from the database.
     */
    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();

        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil dihapus!');
    }
}
