<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Dompdf\Options;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Dompdf;
use Dompdf\Options as DompdfOptions;

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

    $fotoKartuPelajarPath = $request->file('foto_kartu_pelajar')->store('path/to/student_card', 'public');
    if ($request->hasFile('foto_kartu_pelajar')) {
        $fotoKartuPelajarPath = $request->file('foto_kartu_pelajar')->store('foto_kartu_pelajar', 'public');
    } else {
        return redirect()->back()->withErrors(['foto_kartu_pelajar' => 'Gagal mengunggah foto.']);
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
    // Set PDF options with dompdf
    $options = new Options();
    $dompdf = new Dompdf($options);
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'dejavu sans');

    // Create PDF instance with options
    PDF::setOptions([
        'isHtml5ParserEnabled' => true,
        'isRemoteEnabled' => true,
        'defaultFont' => 'dejavu sans'
    ]);

    // Generate verification URL
    $verificationUrl = route('nasabah.verify', ['id' => base64_encode($nasabah->id)]);
    
    // Generate QR Code with proper size and format
    $qrCode = QrCode::format('svg')
                    ->size(300)  // Increased size for better scanning
                    ->margin(1)  // Minimal margin
                    ->errorCorrection('H') // High error correction
                    ->generate($verificationUrl);

    // Convert SVG QR code to base64
    $qrCode = base64_encode($qrCode);

    // Get and encode logo
    $logoPath = public_path('images/smk-logo.png');
    $logoData = '';
    if (file_exists($logoPath)) {
        $logoData = base64_encode(file_get_contents($logoPath));
    }

    // Load view and generate PDF
    $pdf = Pdf::loadView('nasabah.identity-card', [
        'nasabah' => $nasabah,
        'qrCode' => $qrCode,
        'logoData' => $logoData,
        'verificationUrl' => $verificationUrl
    ]);

    // Configure PDF size and orientation
    $pdf->setPaper([0, 0, 242.64, 153.07], 'landscape');
    $pdf->setOption('enable-local-file-access', true);
    $pdf->setOption('margin-top', 0);
    $pdf->setOption('margin-right', 0);
    $pdf->setOption('margin-bottom', 0);
    $pdf->setOption('margin-left', 0);

    // Generate filename
    $filename = 'kartu-nasabah-' . $nasabah->id_nasabah . '.pdf';

    // Return PDF for download
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
