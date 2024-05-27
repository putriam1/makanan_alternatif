<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pasien;
use App\Models\RiwayatPenyakit;

class PasienController extends Controller
{
    public function index()
    {
        $data = Pasien::paginate(10);
        return view('admin.pasien.index', compact('data'));
    }

    public function create()
    {;
        return view('admin.pasien.create');
    }

    public function store(Request $request)
    {
        $data = new Pasien;
        $data->nomor_pasien = $request->nomor_pasien;
        $data->nama = $request->nama;
        $data->no_tlp = $request->no_tlp;
        $data->alamat = $request->alamat;
        $data->jk = $request->jk;
        $data->save();

        return redirect('/pasien');
    }

    public function getPasien($nomor_pasien)
    {
        $pasien = Pasien::where('nomor_pasien', $nomor_pasien)->first();

        if ($pasien) {
            return response()->json($pasien);
        } else {
            return response()->json(['message' => 'Pasien tidak ditemukan'], 404);
        }
    }

}
