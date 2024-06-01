<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RiwayatPenyakit; 

class RiwayatPenyakitController extends Controller
{
    public function index()
    {
        $data = RiwayatPenyakit::with('pasien')->paginate(10);
        return view('admin.riwayat-penyakit.index', compact('data'));
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

        return redirect('/riwayat_penyakit')->with('success', 'Data riwayat penyakit berhasil ditambahkan');
    }

    public function getRiwayatPenyakit($id_pasien)
    {
        $riwayatpenyakit = RiwayatPenyakit::where('id_pasien', $id_pasien)->orderBy('id', 'desc')->get(['id', 'nama_penyakit']);

        if ($riwayatpenyakit) {
            return response()->json($riwayatpenyakit);
        } else {
            return response()->json(['message' => 'Riwayat Penyakit tidak ditemukan'], 404);
        }
    }
}

