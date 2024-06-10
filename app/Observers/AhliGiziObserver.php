<?php

namespace App\Observers;

use App\Models\AhliGizi;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AhliGiziObserver
{
    /**
     * Handle the AhliGizi "created" event.
     *
     * @param  \App\Models\AhliGizi  $ahliGizi
     * @return void
     */
    public function created(AhliGizi $ahliGizi)
    {
        $password = strtolower(str_replace(' ', '', $ahliGizi->nama)) . $ahliGizi->nip;
        $enkripsi_password = Hash::make($password);

        User::create([
            'name' => $ahliGizi->nama,
            'password' => $enkripsi_password,
            'no_hp' => $ahliGizi->no_tlp,
            'alamat' => $ahliGizi->alamat,
            'jenkel' => '-',
            'role' => 'ahligizi',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the AhliGizi "updated" event.
     *
     * @param  \App\Models\AhliGizi  $ahliGizi
     * @return void
     */
    public function updated(AhliGizi $ahliGizi)
    {
        //
    }

    /**
     * Handle the AhliGizi "deleted" event.
     *
     * @param  \App\Models\AhliGizi  $ahliGizi
     * @return void
     */
    public function deleted(AhliGizi $ahliGizi)
    {
        //
    }

    /**
     * Handle the AhliGizi "restored" event.
     *
     * @param  \App\Models\AhliGizi  $ahliGizi
     * @return void
     */
    public function restored(AhliGizi $ahliGizi)
    {
        //
    }

    /**
     * Handle the AhliGizi "force deleted" event.
     *
     * @param  \App\Models\AhliGizi  $ahliGizi
     * @return void
     */
    public function forceDeleted(AhliGizi $ahliGizi)
    {
        //
    }
}
