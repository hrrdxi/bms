<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class NasabahController extends Controller
{
    /**
     * Display a listing of the nasabahs.
     */
    public function index()
{
    $nasabahs = Nasabah::paginate(5); // Sesuaikan pagination jika perlu
    foreach ($nasabahs as $nasabah) {
        $nasabah->kelas_jurusan = $nasabah->kelas . ' ' . $nasabah->jurusan;
        // Pastikan angka_kelas hanya ditambahkan jika ada nilainya
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
    $request->validate([
        'nama' => 'required|string|max:255',
        'foto_kartu_pelajar' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        'no_identitas' => 'required|string|max:255|unique:nasabahs,no_identitas', // Tambahkan `unique`
        'jenis_kelamin' => 'required|string',
        'tempat_lahir' => 'required|string|max:255',
        'tanggal_lahir' => 'required|date',
        'no_telepon' => 'required|string|max:15',
        'kelas' => 'required|string',
        'jurusan' => 'required|string',
        'angka_kelas' => 'required',
        'saldo' => 'required|numeric',
    ]);

    // Lakukan pengecekan jika `no_identitas` sudah ada
    $existingNasabah = Nasabah::where('no_identitas', $request->no_identitas)->first();
    if ($existingNasabah) {
        return redirect()->back()->withErrors(['no_identitas' => 'Nomor identitas sudah digunakan!']);
    }

    if ($request->hasFile('foto_kartu_pelajar')) {
        $fotoKartuPelajarPath = $request->file('foto_kartu_pelajar')
            ->store('foto_kartu_pelajar', 'public');
        
        // Simpan path relatif tanpa 'public/'
        $data['foto_kartu_pelajar'] = str_replace('public/', '', $fotoKartuPelajarPath);
    }

    // Tentukan prefix ID Nasabah berdasarkan jurusan
    $jurusanPPLG = ['PPLG', 'AN', 'TJKT', 'DKV'];
    $prefix = in_array($request->jurusan, $jurusanPPLG) ? 'AM1' : 'AM2';
    $lastFourDigits = substr($request->no_telepon, -4);
    $yearAndMonth = date('Ymd', strtotime($request->tanggal_lahir));
    $id_nasabah = $prefix . '-' . $lastFourDigits . $yearAndMonth;

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

    // Update foto_kartu_pelajar if a new file is uploaded
    if ($request->hasFile('foto_kartu_pelajar')) {
        $fotoPath = $request->file('foto_kartu_pelajar')->store('public/foto_kartu_pelajar');
        $validated['foto_kartu_pelajar'] = basename($fotoPath);
    }

    // Tambahkan logika angka_kelas di sini
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

    public function downloadCard(Nasabah $nasabah)
{
    // Generate verification URL
    $verificationUrl = route('nasabah.verify', ['id' => base64_encode($nasabah->id)]);
    
    // Generate QR Code
    $qrCode = QrCode::format('svg')
                    ->size(300)
                    ->margin(1)
                    ->errorCorrection('H')
                    ->generate($verificationUrl);

    // Convert SVG QR code to base64
    $qrCode = base64_encode($qrCode);

    // Get and encode logo
    $logoPath = public_path('images/smk-logo.png');
    $logoData = '';
    if (file_exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
    }

    // Create PDF dengan options yang benar
    $pdf = PDF::loadView('nasabah.identity-card', [
        'nasabah' => $nasabah,
        'qrCode' => $qrCode,
        'logoData' => $logoData,
        'verificationUrl' => $verificationUrl
    ])->setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'dejavu sans',
        'enable-local-file-access' => true,
        'chroot' => public_path(),
        'margin-top' => 0,
        'margin-right' => 0,
        'margin-bottom' => 0,
        'margin-left' => 0
    ]);

    // Set paper size untuk kartu ID (dalam mm)
    $pdf->setPaper([0, 0, 242.64, 153.07], 'landscape');

    // Generate filename
    $filename = 'kartu-nasabah-' . $nasabah->id_nasabah . '.pdf';

    // Return PDF untuk download
    return $pdf->stream($filename);
}
public function showQRDetail($encrypted_id)
{
    try {
        $id = decrypt($encrypted_id);
        $nasabah = Nasabah::findOrFail($id);
        
        return view('nasabah.qr-detail', compact('nasabah'));
    } catch (\Exception $e) {
        abort(404);
    }
}
public function verify($encodedId)
{
    try {
        $id = base64_decode($encodedId);
        $nasabah = Nasabah::findOrFail($id);
        
        return view('nasabah.verify', [
            'nasabah' => $nasabah,
            'verificationTime' => now()->format('d M Y H:i:s')
        ]);
    } catch (\Exception $e) {
        abort(404, 'Data nasabah tidak ditemukan');
    }
}

}
