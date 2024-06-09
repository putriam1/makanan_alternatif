<?php

namespace App\Observers;

use App\Models\Pasien;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PasienObserver
{
    /**
     * Handle the Pasien "created" event.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return void
     */
    public function created(Pasien $pasien)
    {
        $password = strtolower(str_replace(' ', '', $pasien->nama)) . $pasien->nomor_pasien;
        $enkripsi_password = Hash::make($password);

        User::create([
            'name' => $pasien->nama,
            'password' => $enkripsi_password,
            'no_hp' => $pasien->no_tlp,
            'alamat' => $pasien->alamat,
            'jenkel' => $pasien->jk,
            'role' => 'pasien',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the Pasien "updated" event.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return void
     */
    public function updated(Pasien $pasien)
    {
        //
    }

    /**
     * Handle the Pasien "deleted" event.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return void
     */
    public function deleted(Pasien $pasien)
    {
        //
    }

    /**
     * Handle the Pasien "restored" event.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return void
     */
    public function restored(Pasien $pasien)
    {
        //
    }

    /**
     * Handle the Pasien "force deleted" event.
     *
     * @param  \App\Models\Pasien  $pasien
     * @return void
     */
    public function forceDeleted(Pasien $pasien)
    {
        //
    }
}
