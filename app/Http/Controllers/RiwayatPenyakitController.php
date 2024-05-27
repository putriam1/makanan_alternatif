<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPenyakit; 

class RiwayatPenyakitController extends Controller
{
    public function index()
    {
        $data = RiwayatPenyakit::with('pasien')->paginate(10);
        return view('riwayat_penyakit.index', compact('data'));
    }

    public function create()
    {
        return view('admin.riwayat-penyakit.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_pasien' => 'required|exists:pasien,nomor_pasien',
            'penyakit' => 'required|string|max:255',
        ]);

        $data = new RiwayatPenyakit();
        $data->id_pasien = $request->nomor_pasien; 
        $data->nama_penyakit = $request->penyakit; 
        $data->save();

        return redirect('/ahli-gizi')->with('success', 'Data riwayat penyakit berhasil ditambahkan');
    }
}

