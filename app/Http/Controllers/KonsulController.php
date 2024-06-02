<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use App\Models\Konsul;
use App\Models\Makanan;
use App\Models\RiwayatPenyakit;
use App\Models\MakananAlternative;
use Illuminate\Http\Request;

class KonsulController extends Controller
{

    public function index()
    {
        $data = Konsul::paginate(10);

        // Riwayat Penyakit
        $group_penyakit = [];
        $data->each(function ($item) {
            $penyakit = explode(',', $item->id_riwayat_penyakit);
            foreach ($penyakit as $id_penyakit) {
                $penyakit = RiwayatPenyakit::find($id_penyakit);
                if ($penyakit) {
                    // Jika ditemukan, tambahkan nama penyakit ke dalam array
                    $group_penyakit[] = $penyakit->nama_penyakit;
                }
            }
            $item->group_penyakit = $group_penyakit;
        });

        // Makanan
        $group_makanan = [];
        $data->each(function ($item) {
            $makanan = explode(',', $item->kode_makanan);
            foreach ($makanan as $kode_makanan) {
                $makanan = Makanan::find($kode_makanan);
                if ($makanan) {
                    // Jika ditemukan, tambahkan nama makanan ke dalam array
                    $nama_kategori = $makanan->kategori->nama_kategori;
                    $nama_makanan = $makanan->nama_makanan;
                    $group_makanan[$nama_kategori][] = $nama_makanan;
                }
            }
            $item->group_makanan = $group_makanan;
        });

        // Makanan Alternatif
        $group_makanan_alternative = [];
        
        $data->each(function ($item) {
            // Pisahkan kode makanan alternatif berdasarkn '|'
            $makanan_alternative = explode('|', $item->kode_makanan_alternative);
            
            // Loop melalui setiap makanan alternatif
            foreach ($makanan_alternative as $makanan) {
                // Pisahkan makanan alternatif berdasarkan ','
                $data_makanan_alternative = explode(',', $makanan);

                // Cari makanan alternatif
                foreach ($data_makanan_alternative as $kode_makanan_alternative) {
                    $makanan_alternatif = MakananAlternative::find($kode_makanan_alternative);
                    if ($makanan_alternatif) {
                        // Jika ditemukan, tambahkan nama makanan ke dalam array
                        $nama_kategori = $makanan_alternatif->kategori->nama_kategori;
                        $nama_makanan = $makanan_alternatif->nama_makanan;
                        $group_makanan_alternative[$nama_kategori][] = $nama_makanan;
                    }
                }
            }
            $item->group_makanan_alternative = $group_makanan_alternative;
        });

        return view('admin.konsultasi.index', compact('data'));
    }

    public function create()
    {
        session()->forget('input_data');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();
        return view('admin.konsultasi.create', compact(
            'makananBuah', 'makananSayur', 'makananLauk', 'makananPokok', 'makananAlternativeBuah', 'makananAlternativeSayur', 'makananAlternativeLauk', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', old('id_makanan_sayur'))
            ->with('selected_makanan_lauk', old('id_makanan_lauk'))
            ->with('selected_makanan_buah', old('id_makanan_buah'))
            ->with('selected_makanan_pokok', old('id_makanan_pokok'))
            ->with('selected_makanan_alternative_sayur', old('id_makanan_alternative_sayur'))
            ->with('selected_makanan_alternative_lauk', old('id_makanan_alternative_lauk'))
            ->with('selected_makanan_alternative_buah', old('id_makanan_alternative_buah'))
            ->with('selected_makanan_alternative_pokok', old('id_makanan_alternative_pokok'));
    }

    public function cekProteinSayur(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $protein_makanan = Makanan::where('kode_makanan', $kode_makanan_sayur)->pluck('protein');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeSayur = MakananAlternative::where('protein', '<', $protein_makanan)
            ->where('id_kategori', $idKategoriSayur)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekKarbohidratSayur(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $karbo_makanan = Makanan::where('kode_makanan', $kode_makanan_sayur)->pluck('karbohidrat');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeSayur = MakananAlternative::where('karbohidrat', '<', $karbo_makanan)
            ->where('id_kategori', $idKategoriSayur)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekLemakSayur(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $lemak_makanan = Makanan::where('kode_makanan', $kode_makanan_sayur)->pluck('lemak');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeSayur = MakananAlternative::where('lemak', '<', $lemak_makanan)
            ->where('id_kategori', $idKategoriSayur)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekProteinLauk(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $protein_makanan = Makanan::where('kode_makanan', $kode_makanan_lauk)->pluck('protein');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeLauk = MakananAlternative::where('protein', '<', $protein_makanan)
            ->where('id_kategori', $idKategoriLauk)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekKarbohidratLauk(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $karbo_makanan = Makanan::where('kode_makanan', $kode_makanan_lauk)->pluck('karbohidrat');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeLauk = MakananAlternative::where('karbohidrat', '<', $karbo_makanan)
            ->where('id_kategori', $idKategoriLauk)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekLemakLauk(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $lemak_makanan = Makanan::where('kode_makanan', $kode_makanan_lauk)->pluck('lemak');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeLauk = MakananAlternative::where('lemak', '<', $lemak_makanan)
            ->where('id_kategori', $idKategoriLauk)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekProteinBuah(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $protein_makanan = Makanan::where('kode_makanan', $kode_makanan_lauk)->pluck('protein');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeBuah = MakananAlternative::where('protein', '<', $protein_makanan)
            ->where('id_kategori', $idKategoriBuah)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekKarbohidratBuah(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $karbo_makanan = Makanan::where('kode_makanan', $kode_makanan_buah)->pluck('karbohidrat');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeBuah = MakananAlternative::where('karbohidrat', '<', $karbo_makanan)
            ->where('id_kategori', $idKategoriBuah)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekLemakBuah(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $lemak_makanan = Makanan::where('kode_makanan', $kode_makanan_buah)->pluck('lemak');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativeBuah = MakananAlternative::where('lemak', '<', $lemak_makanan)
            ->where('id_kategori', $idKategoriBuah)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativePokok = MakananAlternative::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekProteinPokok(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $protein_makanan = Makanan::where('kode_makanan', $kode_makanan_pokok)->pluck('protein');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativePokok = MakananAlternative::where('protein', '<', $protein_makanan)
            ->where('id_kategori', $idKategoriPokok)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekKarbohidratPokok(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $karbo_makanan = Makanan::where('kode_makanan', $kode_makanan_pokok)->pluck('karbohidrat');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativePokok = MakananAlternative::where('karbohidrat', '<', $karbo_makanan)
            ->where('id_kategori', $idKategoriPokok)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function cekLemakPokok(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $lemak_makanan = Makanan::where('kode_makanan', $kode_makanan_pokok)->pluck('lemak');
        $idKategoriSayur = Kategori::where('nama_kategori', 'Sayur')->pluck('id')->first();
        $idKategoriLauk = Kategori::where('nama_kategori', 'Lauk')->pluck('id')->first();
        $idKategoriBuah = Kategori::where('nama_kategori', 'Buah')->pluck('id')->first();
        $idKategoriPokok = Kategori::where('nama_kategori', 'Makanan Pokok')->pluck('id')->first();
        $makananAlternativePokok = MakananAlternative::where('lemak', '<', $lemak_makanan)
            ->where('id_kategori', $idKategoriPokok)
            ->orderBy('kode_makanan', 'asc')
            ->get();
        $makananAlternativeLauk = MakananAlternative::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeBuah = MakananAlternative::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananAlternativeSayur = MakananAlternative::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();

        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact(
            'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
    }

    public function store(Request $request)
    {
        $data = new Konsul;
        $data->id_pasien = $request->id_pasien;
        $data->id_ahligizi = $request->id_ahli_gizi;
        $data->id_riwayat_penyakit = implode(',', $request->riwayat_penyakit);
        $data->kode_makanan = implode(',', [
            $request->kode_makanan_sayur,
            $request->kode_makanan_lauk,
            $request->kode_makanan_buah,
            $request->kode_makanan_pokok
        ]);
        $kodeMakananSayur = implode(',', $request->input('kode_makanan_alternative_sayur', []));
        $kodeMakananLauk = implode(',', $request->input('kode_makanan_alternative_lauk', []));
        $kodeMakananBuah = implode(',', $request->input('kode_makanan_alternative_buah', []));
        $kodeMakananPokok = implode(',', $request->input('kode_makanan_alternative_pokok', []));
        $data->kode_makanan_alternative = implode('|', [
            $kodeMakananSayur,
            $kodeMakananLauk,
            $kodeMakananBuah,
            $kodeMakananPokok
        ]);
        $data->tgl_konsultasi = $request->tgl_konsultasi;
        $data->save();

        return redirect('/konsul');
    }

}
