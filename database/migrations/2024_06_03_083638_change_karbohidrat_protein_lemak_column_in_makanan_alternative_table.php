<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('makanan_alternative', function (Blueprint $table) {
            $table->double('karbohidrat')->change();
            $table->double('protein')->change();
            $table->double('lemak')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('makanan_alternative', function (Blueprint $table) {
            //
        });
    }
};
