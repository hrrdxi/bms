<?php

namespace App\Http\Controllers;

use App\Models\Nasabah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class NasabahController extends Controller
{
    public function index()
    {
        $nasabahs = Nasabah::paginate(10);
        foreach ($nasabahs as $nasabah) {
            $nasabah->kelas_jurusan = $nasabah->kelas . ' ' . $nasabah->jurusan;
            if (!empty($nasabah->angka_kelas) && $nasabah->angka_kelas !== 'Tidak Ada') {
                $nasabah->kelas_jurusan .= ' ' . $nasabah->angka_kelas;
            }
        }

        return view('nasabah', compact('nasabahs'));
    }

    public function create()
    {
        $classes = ['X', 'XI', 'XII'];
        $majors = ['PPLG', 'AN', 'TJKT', 'DKV', 'AKL', 'BR', 'LPS', 'DPB', 'MP'];
        $jenisTabungan = ['Wadiah', 'Mudharabah', 'Deposito Mudharabah'];
        return view('nasabah.create', compact('classes', 'majors', 'jenisTabungan'));
    }

    public function store(Request $request)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'foto_kartu_pelajar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'no_identitas' => 'required|string|max:255|unique:nasabahs,no_identitas',
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:15',
            'kelas_type' => 'required|in:regular,order',
            'saldo' => 'required|numeric',
            'jenis_tabungan' => 'required|in:Wadiah,Mudharabah,Deposito Mudharabah',
        ];

        if ($request->kelas_type === 'regular') {
            $rules['kelas'] = 'required|string';
            $rules['jurusan'] = 'required|string';
            $rules['angka_kelas'] = 'required';
        } else {
            $rules['kelas_order'] = 'required|string';
        }

        $validated = $request->validate($rules);

        // Logika pembuatan ID nasabah
        $prefix = 'AM'; // Default prefix untuk "order"
        if ($request->kelas_type === 'regular') {
            $jurusanPPLG = ['PPLG', 'AN', 'TJKT', 'DKV'];
            $prefix = in_array($request->jurusan, $jurusanPPLG) ? 'AM1' : 'AM2';
        }

        $lastFourDigits = substr($request->no_telepon, -4);
        $yearAndMonth = date('Ymd', strtotime($request->tanggal_lahir));
        $id_nasabah = $prefix . '-' . $lastFourDigits . $yearAndMonth;

        $data = [
            'id_nasabah' => $id_nasabah,
            'nama' => $request->nama,
            'no_identitas' => $request->no_identitas,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tempat_lahir' => $request->tempat_lahir,
            'tanggal_lahir' => $request->tanggal_lahir,
            'no_telepon' => $request->no_telepon,
            'saldo' => $request->saldo,
            'jenis_tabungan' => $request->jenis_tabungan,
        ];
        
        if ($request->hasFile('foto_kartu_pelajar')) {
            $fotoKartuPelajarPath = $request->file('foto_kartu_pelajar')
                ->store('foto_kartu_pelajar', 'public');
            $data['foto_kartu_pelajar'] = str_replace('public/', '', $fotoKartuPelajarPath);
        }

        if ($request->kelas_type === 'regular') {
            $data['kelas'] = $request->kelas;
            $data['jurusan'] = $request->jurusan;
            $data['angka_kelas'] = $request->angka_kelas !== 'Tidak Ada' ? 
                $request->angka_kelas : null;
        } else {
            $data['kelas'] = $request->kelas_order;
            $data['jurusan'] = null;
            $data['angka_kelas'] = null;
        }

        Nasabah::create($data);

        return redirect()->route('nasabah.index')
            ->with('success', 'Nasabah berhasil ditambahkan.');
    }

    public function show($id)
    {
        $nasabah = Nasabah::with(['penarikan', 'setorans'])->findOrFail($id);
        return view('nasabah.show', compact('nasabah'));
    }

    public function edit(Nasabah $nasabah)
    {
        $classes = ['X', 'XI', 'XII'];
        $majors = ['PPLG', 'AN', 'TJKT', 'DKV', 'AKL', 'BR', 'LPS', 'DPB', 'MP'];
        $jenisTabungan = ['Wadiah', 'Mudharabah', 'Deposito Mudharabah'];
        return view('nasabah.edit', compact('nasabah', 'classes', 'majors', 'jenisTabungan'));
    }

    public function update(Request $request, Nasabah $nasabah)
    {
        $rules = [
            'nama' => 'required|string|max:255',
            'no_identitas' => 'required|string|max:255|unique:nasabahs,no_identitas,' . $nasabah->id,
            'jenis_kelamin' => 'required|string',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'no_telepon' => 'required|string|max:15',
            'kelas_type' => 'required|in:regular,order',
            'saldo' => 'required|numeric|min:0',
            'foto_kartu_pelajar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jenis_tabungan' => 'required|in:Wadiah,Mudharabah,Deposito Mudharabah',
        ];

        if ($request->kelas_type === 'regular') {
            $rules['kelas'] = 'required|string';
            $rules['jurusan'] = 'required|string';
            $rules['angka_kelas'] = 'required';
        } else {
            $rules['kelas_order'] = 'required|string';
        }

        $validated = $request->validate($rules);

        if ($request->hasFile('foto_kartu_pelajar')) {
            $fotoKartuPelajarPath = $request->file('foto_kartu_pelajar')
                ->store('foto_kartu_pelajar', 'public');
            $fotoKartuPelajarPath = str_replace('public/', '', $fotoKartuPelajarPath);
            $validated['foto_kartu_pelajar'] = $fotoKartuPelajarPath;
        }

        // Logika pembuatan ID nasabah
        $prefix = 'AM'; // Default prefix untuk "order"
        if ($request->kelas_type === 'regular') {
            $jurusanPPLG = ['PPLG', 'AN', 'TJKT', 'DKV'];
            $prefix = in_array($request->jurusan, $jurusanPPLG) ? 'AM1' : 'AM2';
        }

        $lastFourDigits = substr($request->no_telepon, -4);
        $yearAndMonth = date('Ymd', strtotime($request->tanggal_lahir));
        $validated['id_nasabah'] = $prefix . '-' . $lastFourDigits . $yearAndMonth;

        $updateData = [
            'id_nasabah' => $validated['id_nasabah'],
            'nama' => $validated['nama'],
            'no_identitas' => $validated['no_identitas'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'tempat_lahir' => $validated['tempat_lahir'],
            'tanggal_lahir' => $validated['tanggal_lahir'],
            'no_telepon' => $validated['no_telepon'],
            'saldo' => $validated['saldo'],
            'jenis_tabungan' => $validated['jenis_tabungan'],
        ];

        if (isset($validated['foto_kartu_pelajar'])) {
            $updateData['foto_kartu_pelajar'] = $validated['foto_kartu_pelajar'];
        }

        if ($request->kelas_type === 'regular') {
            $updateData['kelas'] = $validated['kelas'];
            $updateData['jurusan'] = $validated['jurusan'];
            $updateData['angka_kelas'] = $validated['angka_kelas'] !== 'Tidak Ada' ? 
                $validated['angka_kelas'] : null;
        } else {
            $updateData['kelas'] = $validated['kelas_order'];
            $updateData['jurusan'] = null;
            $updateData['angka_kelas'] = null;
        }

        $nasabah->update($updateData);

        return redirect()->route('nasabah.index')
            ->with('success', 'Data nasabah berhasil diperbarui.');
    }

    public function destroy(Nasabah $nasabah)
    {
        $nasabah->delete();
        return redirect()->route('nasabah.index')->with('success', 'Nasabah berhasil dihapus!');
    }

    public function downloadCard(Nasabah $nasabah)
    {
        $verificationUrl = route('nasabah.verify', ['id' => base64_encode($nasabah->id)]);
        
        $qrCode = QrCode::format('svg')
                        ->size(300)
                        ->margin(1)
                        ->errorCorrection('H')
                        ->generate($verificationUrl);

        $qrCode = base64_encode($qrCode);

        $logoPath = public_path('images/smk-logo.png');
        $logoData = '';
        if (file_exists($logoPath)) {
            $logoData = base64_encode(file_get_contents($logoPath));
        }

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

        $pdf->setPaper([0, 0, 242.64, 153.07], 'landscape');
        $filename = 'kartu-nasabah-' . $nasabah->id_nasabah . '.pdf';

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

    public function searchAjax(Request $request)
    {
        $query = $request->get('query');
        
        \Log::info('Search query received: ' . $query);
        
        $nasabahs = Nasabah::where(function($q) use ($query) {
            $q->where('id_nasabah', 'like', "{$query}%")
              ->orWhere('id_nasabah', 'like', "%{$query}%")
              ->orWhere('nama', 'like', "%{$query}%");
        })
        ->select('id', 'id_nasabah', 'nama', 'kelas', 'jurusan', 'angka_kelas', 'jenis_tabungan')
        ->limit(10)
        ->get();
        
        \Log::info('Search results count: ' . $nasabahs->count());
        
        return response()->json($nasabahs);
    }

    public function search(Request $request)
    {
        $query = Nasabah::query();

        if ($request->has('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama', 'like', "%{$searchTerm}%")
                  ->orWhere('id_nasabah', 'like', "%{$searchTerm}%");
            });
        }

        $nasabahs = $query->paginate(10);

        foreach ($nasabahs as $nasabah) {
            $nasabah->kelas_jurusan = $nasabah->kelas . ' ' . $nasabah->jurusan;
            if (!empty($nasabah->angka_kelas) && $nasabah->angka_kelas !== 'Tidak Ada') {
                $nasabah->kelas_jurusan .= ' ' . $nasabah->angka_kelas;
            }
        }

        return view('nasabah', compact('nasabahs'));
    }
}