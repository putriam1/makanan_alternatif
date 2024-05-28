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

        return redirect('/create-penyakit')->with('success', 'Data riwayat penyakit berhasil ditambahkan');
    }

    public function getRiwayatPenyakit($nomor_pasien){
        $riwayat_penyakit = RiwayatPenyakit::where('id_pasien', $nomor_pasien)->pluck('nama_penyakit');

        if ($riwayat_penyakit) {
            return response()->json($riwayat_penyakit);
        } else {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }
    }

    public function getRiwayat($id_pasien)
    {
        $riwayatpenyakit = RiwayatPenyakit::where('id_pasien', $id_pasien)->first();

        if ($riwayatpenyakit) {
            return response()->json($riwayatpenyakit);
        } else {
            return response()->json(['message' => 'Riwayat Penyakit tidak ditemukan'], 404);
        }
    }
}

