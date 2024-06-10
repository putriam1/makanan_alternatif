<?php

namespace App\Http\Controllers;

use App\Models\Konsul;
use App\Models\Makanan;
use App\Models\AhliGizi;
use App\Models\MakananAlternative;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KonsulController extends Controller
{

    public function index()
    {
        if (Auth::user()->role == 'ahligizi') {
            $nip = AhliGizi::where('nama', Auth::user()->name)->first()->nip;
            $data = Konsul::where('id_ahligizi', $nip)->paginate(10);
        } else {
            $data = Konsul::paginate(10);
        }

        // Riwayat Penyakit
        // $group_penyakit = [];
        // $data->each(function ($item) {
        //     $penyakit = explode(',', $item->id_riwayat_penyakit);
        //     foreach ($penyakit as $id_penyakit) {
        //         $penyakit = RiwayatPenyakit::find($id_penyakit);
        //         if ($penyakit) {
        //             // Jika ditemukan, tambahkan nama penyakit ke dalam array
        //             $group_penyakit[] = $penyakit->nama_penyakit;
        //         }
        //     }
        //     $item->group_penyakit = $group_penyakit;
        // });

        // Makanan
        $group_makanan = [];
        $data->each(function ($item) use (&$group_makanan) {
            $makanan = explode(',', $item->kode_makanan);
            foreach ($makanan as $kode_makanan) {
                $makanan = Makanan::find($kode_makanan);
                if ($makanan) {
                    // Jika ditemukan, tambahkan nama makanan ke dalam array
                    $nama_kategori = $makanan->kategori->nama_kategori;
                    $nama_makanan = $makanan->nama_makanan;
                    $group_makanan[$nama_kategori] = $nama_makanan;
                }
            }
            $item->group_makanan = $group_makanan;
        });        

        // dd($group_makanan);

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

        // dd($group_makanan_alternative);

        return view('admin.konsultasi.index', compact('data'));
    }

    public function create()
    {
        session()->forget('input_data');
        $makanan_sayur = Makanan::where('id_kategori', 1)->orderBy('kode_makanan', 'asc')->get();
        $makanan_lauk  = Makanan::where('id_kategori', 2)->orderBy('kode_makanan', 'asc')->get();
        $makanan_buah  = Makanan::where('id_kategori', 4)->orderBy('kode_makanan', 'asc')->get();
        $makanan_pokok = Makanan::where('id_kategori', 3)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_alternative_sayur = MakananAlternative::where('id_kategori', 1)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_alternative_lauk  = MakananAlternative::where('id_kategori', 2)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_alternative_buah  = MakananAlternative::where('id_kategori', 4)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_alternative_pokok = MakananAlternative::where('id_kategori', 3)->orderBy('kode_makanan', 'asc')->get();

        if (Auth::user()->role == 'ahligizi') {
            $nip_ahli_gizi  = AhliGizi::where('nama', Auth::user()->name)->first()->nip;
            $nama_ahli_gizi = AhliGizi::where('nama', Auth::user()->name)->first()->nama;
            return view('admin.konsultasi.create', compact(
                'nip_ahli_gizi', 'nama_ahli_gizi', 'makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', old('id_makanan_sayur'))
                ->with('selected_makanan_lauk' , old('id_makanan_lauk'))
                ->with('selected_makanan_buah' , old('id_makanan_buah'))
                ->with('selected_makanan_pokok', old('id_makanan_pokok'))
                ->with('selected_makanan_alternative_sayur', old('id_makanan_alternative_sayur'))
                ->with('selected_makanan_alternative_lauk' , old('id_makanan_alternative_lauk'))
                ->with('selected_makanan_alternative_buah' , old('id_makanan_alternative_buah'))
                ->with('selected_makanan_alternative_pokok', old('id_makanan_alternative_pokok'));
        } else {
            return view('admin.konsultasi.create', compact(
                'makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', old('id_makanan_sayur'))
                ->with('selected_makanan_lauk' , old('id_makanan_lauk'))
                ->with('selected_makanan_buah' , old('id_makanan_buah'))
                ->with('selected_makanan_pokok', old('id_makanan_pokok'))
                ->with('selected_makanan_alternative_sayur', old('id_makanan_alternative_sayur'))
                ->with('selected_makanan_alternative_lauk' , old('id_makanan_alternative_lauk'))
                ->with('selected_makanan_alternative_buah' , old('id_makanan_alternative_buah'))
                ->with('selected_makanan_alternative_pokok', old('id_makanan_alternative_pokok'));
        }
    }

    private function euclideanDistance($makanan, $makanan_alternative)
    {
        return sqrt(
            pow($makanan->lemak - $makanan_alternative->lemak, 2) +
            pow($makanan->protein - $makanan_alternative->protein, 2) +
            pow($makanan->karbohidrat - $makanan_alternative->karbohidrat, 2)
        );
    }

    public function cekMakanan($referensi_makanan_id, $kategori_id)
    {
        $referensi_makanan = Makanan::where('kode_makanan', $referensi_makanan_id)->where('id_kategori', $kategori_id)->first();
        
        $makanan_alternative = MakananAlternative::where('id_kategori', $kategori_id)->get();

        if($referensi_makanan) {
            $similarities = [];
            foreach ($makanan_alternative as $makanan) {
                $score = $this->euclideanDistance($referensi_makanan, $makanan);
                $similarities[$makanan->kode_makanan] = $score;
            }

            asort($similarities);

            $rekomendasi_makanan_id = array_slice(array_keys($similarities), 0, 3);
            $rekomendasi_makanan = MakananAlternative::whereIn('kode_makanan', $rekomendasi_makanan_id)->get();
        } else {
            $rekomendasi_makanan = $makanan_alternative;
        }

        return $rekomendasi_makanan;
    }

    public function cekMakananSayur(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $makanan_sayur = Makanan::where('id_kategori', 1)->orderBy('kode_makanan', 'asc')->get();
        $makanan_lauk  = Makanan::where('id_kategori', 2)->orderBy('kode_makanan', 'asc')->get();
        $makanan_buah  = Makanan::where('id_kategori', 4)->orderBy('kode_makanan', 'asc')->get();
        $makanan_pokok = Makanan::where('id_kategori', 3)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_sayur = $request->kode_makanan_sayur;
        $rekomendasi_makanan_lauk  = $request->kode_makanan_lauk;
        $rekomendasi_makanan_buah  = $request->kode_makanan_buah;
        $rekomendasi_makanan_pokok = $request->kode_makanan_pokok; 
        $rekomendasi_makanan_alternative_sayur = $this->cekMakanan($rekomendasi_makanan_sayur, 1);
        $rekomendasi_makanan_alternative_lauk  = $this->cekMakanan($rekomendasi_makanan_lauk, 2);
        $rekomendasi_makanan_alternative_buah  = $this->cekMakanan($rekomendasi_makanan_buah, 4);
        $rekomendasi_makanan_alternative_pokok = $this->cekMakanan($rekomendasi_makanan_pokok, 3);
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk  = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah  = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];

        if (Auth::user()->role == 'ahligizi') {
            $nip_ahli_gizi  = AhliGizi::where('nama', Auth::user()->name)->first()->nip;
            $nama_ahli_gizi = AhliGizi::where('nama', Auth::user()->name)->first()->nama;
            return view('admin.konsultasi.create', 
                compact('nip_ahli_gizi', 'nama_ahli_gizi', 'makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        } else {
            return view('admin.konsultasi.create', 
                compact('makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        }
        
    }

    public function cekMakananLauk(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $makanan_sayur = Makanan::where('id_kategori', 1)->orderBy('kode_makanan', 'asc')->get();
        $makanan_lauk  = Makanan::where('id_kategori', 2)->orderBy('kode_makanan', 'asc')->get();
        $makanan_buah  = Makanan::where('id_kategori', 4)->orderBy('kode_makanan', 'asc')->get();
        $makanan_pokok = Makanan::where('id_kategori', 3)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_sayur = $request->kode_makanan_sayur;
        $rekomendasi_makanan_lauk  = $request->kode_makanan_lauk;
        $rekomendasi_makanan_buah  = $request->kode_makanan_buah;
        $rekomendasi_makanan_pokok = $request->kode_makanan_pokok; 
        $rekomendasi_makanan_alternative_sayur = $this->cekMakanan($rekomendasi_makanan_sayur, 1);
        $rekomendasi_makanan_alternative_lauk  = $this->cekMakanan($rekomendasi_makanan_lauk, 2);
        $rekomendasi_makanan_alternative_buah  = $this->cekMakanan($rekomendasi_makanan_buah, 4);
        $rekomendasi_makanan_alternative_pokok = $this->cekMakanan($rekomendasi_makanan_pokok, 3);
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk  = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah  = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];

        if (Auth::user()->role == 'ahligizi') {
            $nip_ahli_gizi  = AhliGizi::where('nama', Auth::user()->name)->first()->nip;
            $nama_ahli_gizi = AhliGizi::where('nama', Auth::user()->name)->first()->nama;
            return view('admin.konsultasi.create', 
                compact('nip_ahli_gizi', 'nama_ahli_gizi', 'makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        } else {
            return view('admin.konsultasi.create', 
                compact('makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        }
    }

    public function cekMakananBuah(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $makanan_sayur = Makanan::where('id_kategori', 1)->orderBy('kode_makanan', 'asc')->get();
        $makanan_lauk  = Makanan::where('id_kategori', 2)->orderBy('kode_makanan', 'asc')->get();
        $makanan_buah  = Makanan::where('id_kategori', 4)->orderBy('kode_makanan', 'asc')->get();
        $makanan_pokok = Makanan::where('id_kategori', 3)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_sayur = $request->kode_makanan_sayur;
        $rekomendasi_makanan_lauk  = $request->kode_makanan_lauk;
        $rekomendasi_makanan_buah  = $request->kode_makanan_buah;
        $rekomendasi_makanan_pokok = $request->kode_makanan_pokok; 
        $rekomendasi_makanan_alternative_sayur = $this->cekMakanan($rekomendasi_makanan_sayur, 1);
        $rekomendasi_makanan_alternative_lauk  = $this->cekMakanan($rekomendasi_makanan_lauk, 2);
        $rekomendasi_makanan_alternative_buah  = $this->cekMakanan($rekomendasi_makanan_buah, 4);
        $rekomendasi_makanan_alternative_pokok = $this->cekMakanan($rekomendasi_makanan_pokok, 3);
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk  = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah  = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];

        if (Auth::user()->role == 'ahligizi') {
            $nip_ahli_gizi  = AhliGizi::where('nama', Auth::user()->name)->first()->nip;
            $nama_ahli_gizi = AhliGizi::where('nama', Auth::user()->name)->first()->nama;
            return view('admin.konsultasi.create', 
                compact('nip_ahli_gizi', 'nama_ahli_gizi', 'makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        } else {
            return view('admin.konsultasi.create', 
                compact('makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        }
    }

    public function cekMakananPokok(Request $request)
    {
        $request->session()->put('input_data', $request->all());
        $makanan_sayur = Makanan::where('id_kategori', 1)->orderBy('kode_makanan', 'asc')->get();
        $makanan_lauk  = Makanan::where('id_kategori', 2)->orderBy('kode_makanan', 'asc')->get();
        $makanan_buah  = Makanan::where('id_kategori', 4)->orderBy('kode_makanan', 'asc')->get();
        $makanan_pokok = Makanan::where('id_kategori', 3)->orderBy('kode_makanan', 'asc')->get();
        $rekomendasi_makanan_sayur = $request->kode_makanan_sayur;
        $rekomendasi_makanan_lauk  = $request->kode_makanan_lauk;
        $rekomendasi_makanan_buah  = $request->kode_makanan_buah;
        $rekomendasi_makanan_pokok = $request->kode_makanan_pokok; 
        $rekomendasi_makanan_alternative_sayur = $this->cekMakanan($rekomendasi_makanan_sayur, 1);
        $rekomendasi_makanan_alternative_lauk  = $this->cekMakanan($rekomendasi_makanan_lauk, 2);
        $rekomendasi_makanan_alternative_buah  = $this->cekMakanan($rekomendasi_makanan_buah, 4);
        $rekomendasi_makanan_alternative_pokok = $this->cekMakanan($rekomendasi_makanan_pokok, 3);
        $makanan_alternative_sayur = $request->kode_makanan_alternative_sayur ?? [];
        $makanan_alternative_lauk  = $request->kode_makanan_alternative_lauk ?? [];
        $makanan_alternative_buah  = $request->kode_makanan_alternative_buah ?? [];
        $makanan_alternative_pokok = $request->kode_makanan_alternative_pokok ?? [];

        if (Auth::user()->role == 'ahligizi') {
            $nip_ahli_gizi  = AhliGizi::where('nama', Auth::user()->name)->first()->nip;
            $nama_ahli_gizi = AhliGizi::where('nama', Auth::user()->name)->first()->nama;
            return view('admin.konsultasi.create', 
                compact('nip_ahli_gizi', 'nama_ahli_gizi', 'makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        } else {
            return view('admin.konsultasi.create', 
                compact('makanan_sayur', 'makanan_lauk', 'makanan_buah', 'makanan_pokok', 'rekomendasi_makanan_alternative_sayur', 'rekomendasi_makanan_alternative_lauk', 'rekomendasi_makanan_alternative_buah', 'rekomendasi_makanan_alternative_pokok'))
                ->with('selected_makanan_sayur', $rekomendasi_makanan_sayur)
                ->with('selected_makanan_lauk' , $rekomendasi_makanan_lauk)
                ->with('selected_makanan_buah' , $rekomendasi_makanan_buah)
                ->with('selected_makanan_pokok', $rekomendasi_makanan_pokok)
                ->with('selected_makanan_alternative_sayur', $makanan_alternative_sayur)
                ->with('selected_makanan_alternative_lauk' , $makanan_alternative_lauk)
                ->with('selected_makanan_alternative_buah' , $makanan_alternative_buah)
                ->with('selected_makanan_alternative_pokok', $makanan_alternative_pokok);
        }
    }

    public function store(Request $request)
    {
        $data = new Konsul;
        $data->id_pasien = $request->id_pasien;
        $data->id_ahligizi = $request->id_ahli_gizi;
        // $data->id_riwayat_penyakit = implode(',', $request->riwayat_penyakit);
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
