<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MakananAlternative;
use PDF; // Pastikan sudah diimport
use App\Models\Konsul; // Pastikan model Konsul sudah diimport

class PDFController extends Controller
{
    public function generatePDF($id)
    {
        \Log::info('Attempting to generate PDF for Konsul ID: ' . $id); // Log pernyataan awal

        try {
            // Ambil data konsultasi dari database berdasarkan ID
            $konsul = Konsul::findOrFail($id);

            $data = [
                'pasien' => $konsul->pasien->nama ?? 'Data tidak tersedia',
                'ahli_gizi' => $konsul->ahligizi->nama ?? 'Data tidak tersedia',
                'riwayat' => $konsul->riwayat_penyakit->nama_penyakit ?? 'Data tidak tersedia',
                'makanan' => $konsul->makanan ? $konsul->makanan->nama_makanan : 'Data tidak tersedia',
                'makanan_alternative' => collect(explode(',', $konsul->kode_makanan_alternative))
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
                    ->toArray(), // Mengubah koleksi ke dalam bentuk array
                'tanggal_konsultasi' => $konsul->tgl_konsultasi ?? 'Data tidak tersedia',
            ];

            // Load view pdf.blade.php dengan data konsultasi yang diambil
            $pdf = PDF::loadView('admin.histori.pdf', $data);
        
            \Log::info('PDF generated successfully'); // Log jika PDF berhasil dibuat

            // Download file PDF dengan nama 'document.pdf'
            return $pdf->download('document.pdf');
        } catch (\Exception $e) {
            \Log::error('Failed to generate PDF: ' . $e->getMessage()); // Log jika terjadi kesalahan

            // Mengembalikan respon atau melakukan penanganan kesalahan lainnya
            return back()->withErrors(['error' => 'Failed to generate PDF']);
        }
    }
}
