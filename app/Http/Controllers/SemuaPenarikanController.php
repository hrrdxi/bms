<?php

namespace App\Http\Controllers;

use App\Models\Penarikan;
use Illuminate\Http\Request;

class SemuaPenarikanController extends Controller
{
    public function index()
    {
        $penarikans = Penarikan::paginate(8);

        return view('penarikan.cekSemua', compact('penarikans'));
    }
}
