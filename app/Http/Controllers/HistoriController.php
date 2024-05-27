<?php

namespace App\Http\Controllers;

use App\Models\AhliGizi;
use App\Models\Konsul;
use App\Models\Pasien;
use App\Models\Makanan;
use App\Models\MakananAlternative;
use Illuminate\Http\Request;

class HistoriController extends Controller
{
    public function index()
    {
        $data = Konsul::paginate(10);

        $data->each(function ($item) {
            $kode_makanan_alternative = explode(',', $item->kode_makanan_alternative);
            $makanan_alternative = MakananAlternative::whereIn('kode_makanan', $kode_makanan_alternative)->pluck('nama_makanan')->toArray();
            
            $item->makanan_alternative = implode(', ', $makanan_alternative); // Menggabungkan nama makanan alternatif menjadi satu string dengan koma sebagai pemisah
        });
 
        return view('admin.histori.index', compact('data'));
    }
}
