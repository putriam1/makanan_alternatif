<?php

namespace App\Http\Controllers;

use App\Models\AhliGizi;
use Illuminate\Http\Request;

class AhliGiziController extends Controller
{
    public function index()
    {
        $data = AhliGizi::paginate(10);
        return view('admin.ahli-gizi.index', compact('data'));
    }

    public function create()
    {
        return view('admin.ahli-gizi.create');
    }

    public function store(Request $request)
    {
        $data = new AhliGizi;
        $data->nip    = $request->nip;
        $data->nama   = $request->nama;
        $data->no_tlp = $request->no_tlp;
        $data->alamat = $request->alamat;
        $data->save();

        return redirect('/ahli-gizi');

    }

    public function ubahStatus($id)
    {
        $data = AhliGizi::find($id);
        if ($data) {
            $data->status = $data->status == 'aktif' ? 'tidak aktif' : 'aktif';
            $data->update();
        }
        return redirect('/ahli-gizi');
    }

    public function getAhliGizi($nip)
    {
        $ahli_gizi = AhliGizi::where('nip', $nip)->first();

        if ($ahli_gizi) {
            return response()->json($ahli_gizi);
        } else {
            return response()->json(['message' => 'ahli gizi tidak ditemukan'], 404);
        }
    }
}
