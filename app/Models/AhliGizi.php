<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AhliGizi extends Model
{
    use HasFactory;

    protected $table = 'ahli_gizi';

    protected $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'no_tlp',
        'alamat',  
    ];

    public function konsul()
    {
        return $this->hasMany(Konsul::class, 'id_ahligizi', 'nip');
    }
}
