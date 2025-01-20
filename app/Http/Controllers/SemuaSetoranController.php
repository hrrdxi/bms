<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use Illuminate\Http\Request;

class SemuaSetoranController extends Controller
{
    public function index()
    {
        $setorans = Setoran::paginate(8);

        return view('setoran.cekSemua', compact('setorans'));
    }
}
