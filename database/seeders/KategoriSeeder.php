<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Kategori::insert([
            ['nama_kategori' => 'Sayur'],
            ['nama_kategori' => 'Lauk'],
            ['nama_kategori' => 'Makanan Pokok'],
            ['nama_kategori' => 'Buah'],
        ]);
    }
}
