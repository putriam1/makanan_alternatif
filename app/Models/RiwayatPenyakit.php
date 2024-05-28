<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RiwayatPenyakit extends Model
{
    use HasFactory;

    protected $table = 'riwayat_penyakit';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id_pasien','nama_penyakit',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'nomor_pasien');
    }
}
