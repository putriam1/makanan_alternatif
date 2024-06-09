<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Log;
use PDF;
use App\Models\Konsul;
use App\Models\Makanan;
use App\Models\MakananAlternative;
use App\Models\RiwayatPenyakit;

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        Log::info('Attempting to generate PDF for Konsul ID: ' . $id); // Log pernyataan awal

        try {
            // Ambil data konsultasi dari database berdasarkan ID
            $konsul = Konsul::findOrFail($id);

            $data = [
                'pasien' => $konsul->pasien->nama ?? 'Data tidak tersedia',
                'ahli_gizi' => $konsul->ahligizi->nama ?? 'Data tidak tersedia',
                // 'riwayat' => collect(explode(',', $konsul->id_riwayat_penyakit))
                //     ->map(function ($id_riwayat_penyakit) {
                //         $riwayat_penyakit = RiwayatPenyakit::where('id', $id_riwayat_penyakit)->first();
                //         return [
                //             'nama_penyakit' => $riwayat_penyakit->nama_penyakit,
                //         ];
                //     })
                //     ->filter()
                //     ->toArray(),
                'makanan' => collect(explode(',', $konsul->kode_makanan))
                    ->map(function ($kodeMakanan) {
                        $makanan = Makanan::where('kode_makanan', $kodeMakanan)->first();
                        if ($makanan) {
                            return [
                                'nama_makanan' => $makanan->nama_makanan,
                                'protein' => $makanan->protein,
                                'lemak' => $makanan->lemak,
                                'karbo' => $makanan->karbohidrat,
                            ];
                        }
                        return null;
                    })
                    ->filter() // Menghilangkan nilai null dari koleksi
                    ->toArray(), // Mengubah koleksi ke dalam bentuk array
                'makanan_alternative' => collect(explode('|', $konsul->kode_makanan_alternative))
                    ->map(function ($group) {
                        return collect(explode(',', $group))
                            ->map(function ($kodeMakanan) {
                                $makanan = MakananAlternative::where('kode_makanan', $kodeMakanan)->first();
                                if ($makanan) {
                                    return [
                                        'nama_makanan_alternative' => $makanan->nama_makanan,
                                        'protein' => $makanan->protein,
                                        'lemak' => $makanan->lemak,
                                        'karbo' => $makanan->karbohidrat,
                                    ];
                                }
                                return null;
                            })
                            ->filter() // Menghilangkan nilai null dari koleksi
                            ->toArray(); // Mengubah koleksi ke dalam bentuk array
                    })
                    ->toArray(), // Mengubah koleksi ke dalam bentuk array utama
                'tanggal_konsultasi' => $konsul->tgl_konsultasi ?? 'Data tidak tersedia',
            ];

            Log::info('Makanan: ', $data['makanan']); // Tambahkan ini untuk memeriksa struktur $makanan
            Log::info('Makanan Alternative: ', $data['makanan_alternative']); // Tambahkan ini untuk memeriksa struktur $makanan_alternative
        
            // Load view pdf.blade.php dengan data konsultasi yang diambil
            $pdf = PDF::loadView('admin.histori.pdf', $data);
            
            Log::info('PDF generated successfully'); // Log jika PDF berhasil dibuat

            // Download file PDF dengan nama 'document.pdf'
            return $pdf->download('document.pdf');
        } catch (\Exception $e) {
            Log::error('Failed to generate PDF: ' . $e->getMessage()); // Log jika terjadi kesalahan

            // Mengembalikan respon atau melakukan penanganan kesalahan lainnya
            return back()->withErrors(['error' => 'Failed to generate PDF']);
        }
    }
}
