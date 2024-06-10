<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    use HasFactory;

    protected $table = 'pasien';

    protected $keyType = 'string';

    protected $fillable = [
        'nomor_pasien',
        'nama',
        'no_tlp',
        'alamat',
        'jk',
    ];

    public function riwayat()
    {
        return $this->belongsTo(RiwayatPenyakit::class, 'id_riwayat');
    }

    public function konsul()
    {
        return $this->hasMany(Konsul::class, 'id_pasien', 'nomor_pasien');
    }

}
