<?php

namespace App\Observers;

use App\Models\Chef;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ChefObserver
{
    /**
     * Handle the Chef "created" event.
     *
     * @param  \App\Models\Chef  $chef
     * @return void
     */
    public function created(Chef $chef)
    {
        $password = strtolower(str_replace(' ', '', $chef->nama)) . $chef->nip;
        $enkripsi_password = Hash::make($password);

        User::create([
            'name' => $chef->nama,
            'password' => $enkripsi_password,
            'no_hp' => $chef->no_tlp,
            'alamat' => $chef->alamat,
            'jenkel' => '-',
            'role' => 'chef',
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Handle the Chef "updated" event.
     *
     * @param  \App\Models\Chef  $chef
     * @return void
     */
    public function updated(Chef $chef)
    {
        //
    }

    /**
     * Handle the Chef "deleted" event.
     *
     * @param  \App\Models\Chef  $chef
     * @return void
     */
    public function deleted(Chef $chef)
    {
        //
    }

    /**
     * Handle the Chef "restored" event.
     *
     * @param  \App\Models\Chef  $chef
     * @return void
     */
    public function restored(Chef $chef)
    {
        //
    }

    /**
     * Handle the Chef "force deleted" event.
     *
     * @param  \App\Models\Chef  $chef
     * @return void
     */
    public function forceDeleted(Chef $chef)
    {
        //
    }
}
