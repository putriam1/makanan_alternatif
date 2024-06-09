<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    use HasFactory;

    protected $table = 'chef';

    public $keyType = 'string';

    protected $fillable = [
        'nip',
        'nama',
        'no_tlp',
        'alamat',
    ];
}
