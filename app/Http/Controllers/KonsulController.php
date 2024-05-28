<?php

namespace App\Http\Controllers;

use App\Models\AhliGizi;
use App\Models\Kategori;
use App\Models\Konsul;
use App\Models\Pasien;
use App\Models\Makanan;
use App\Models\MakananAlternative;
use Illuminate\Http\Request;

class KonsulController extends Controller
{

    public function index()
    {
        $data = Konsul::paginate(10);

        $data->each(function ($item) {
            $kode_makanan_alternative = explode(',', $item->kode_makanan_alternative);
            $makanan_alternative = MakananAlternative::whereIn('kode_makanan', $kode_makanan_alternative)->pluck('nama_makanan')->toArray();
            
            $item->makanan_alternative = collect($makanan_alternative)->map(function ($makanan, $key) {
                return "Makanan " . ($key + 1) . ": " . $makanan;
            })->implode('<br>');
        });

        return view('admin.konsultasi.index', compact('data'));
    }

    public function create()
    {
        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
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
        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananBuah', 'makananSayur', 'makananLauk', 'makananPokok', 'makananAlternativeBuah', 'makananAlternativeSayur', 'makananAlternativeLauk', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', old('id_makanan_sayur'))
            ->with('selected_makanan_lauk', old('id_makanan_lauk'))
            ->with('selected_makanan_buah', old('id_makanan_buah'))
            ->with('selected_makanan_pokok', old('id_makanan_pokok'))
            ->with('selected_makanan_alternative_sayur', old('id_makanan_alternative_sayur'))
            ->with('selected_makanan_alternative_lauk', old('id_makanan_alternative_lauk'))
            ->with('selected_makanan_alternative_buah', old('id_makanan_alternative_buah'))
            ->with('selected_makanan_alternative_pokok', old('id_makanan_alternative_pokok'))
            ->with('selected_pasien', old('id_pasien'))
            ->with('selected_ahligizi', old('id_ahligizi'))
            ->with('tgl_konsultasi', old('tgl_konsultasi'));
    }

    public function cekProteinSayur(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekKarbohidratSayur(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekLemakSayur(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekProteinLauk(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekKarbohidratLauk(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekLemakLauk(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekProteinBuah(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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
        
        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekKarbohidratBuah(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekLemakBuah(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekProteinPokok(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekKarbohidratPokok(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function cekLemakPokok(Request $request)
    {
        $id_pasien     = $request->id_pasien;
        $id_ahligizi   = $request->id_ahligizi;
        $kode_makanan_sayur  = $request->kode_makanan_sayur;
        $kode_makanan_lauk  = $request->kode_makanan_lauk;
        $kode_makanan_buah  = $request->kode_makanan_buah;
        $kode_makanan_pokok  = $request->kode_makanan_pokok;
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];
        $tgl_kosultasi = $request->tgl_konsultasi;
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

        $pasien = Pasien::orderBy('nomor_pasien', 'asc')->get();
        $ahligizi = AhliGizi::orderBy('nip', 'asc')->get();
        $makananSayur = Makanan::where('id_kategori', $idKategoriSayur)->orderBy('kode_makanan', 'asc')->get();
        $makananLauk = Makanan::where('id_kategori', $idKategoriLauk)->orderBy('kode_makanan', 'asc')->get();
        $makananBuah = Makanan::where('id_kategori', $idKategoriBuah)->orderBy('kode_makanan', 'asc')->get();
        $makananPokok = Makanan::where('id_kategori', $idKategoriPokok)->orderBy('kode_makanan', 'asc')->get();

        return view('admin.konsultasi.create', compact('pasien', 'ahligizi', 'makananSayur', 'makananAlternativeSayur', 'makananLauk', 'makananBuah', 'makananPokok', 'makananAlternativeLauk', 'makananAlternativeBuah', 'makananAlternativePokok'))
            ->with('selected_makanan_sayur', $kode_makanan_sayur)
            ->with('selected_makanan_lauk', $kode_makanan_lauk)
            ->with('selected_makanan_buah', $kode_makanan_buah)
            ->with('selected_makanan_pokok', $kode_makanan_pokok)
            ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
            ->with('selected_makanan_alternative_lauk', $makanan_alternative_lauk)
            ->with('selected_makanan_alternative_buah', $makanan_alternative_buah)
            ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok)
            ->with('selected_pasien', $id_pasien)
            ->with('selected_ahligizi', $id_ahligizi)
            ->with('tgl_konsultasi', old('tgl_konsultasi', $tgl_kosultasi));
    }

    public function store(Request $request)
    {
        $data = new Konsul;
        $data->id_pasien = $request->id_pasien;
        $data->id_ahligizi = $request->id_ahligizi;
        dd($request->input('id_riwayat_penyakit'));
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
        dd($data);
        $data->save();

        return redirect('/konsul');
    }

}
