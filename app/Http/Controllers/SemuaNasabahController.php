<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Nasabah;

class SemuaNasabahController extends Controller
{
    public function index()
{
    $nasabahs = Nasabah::paginate(8); // Pagination, bisa disesuaikan
    return view('nasabah.cekSemua', compact('nasabahs'));
}

}
