<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
        CREATE TRIGGER after_pasien_insert
        AFTER INSERT ON pasien
        FOR EACH ROW
        BEGIN
            DECLARE password VARCHAR(255);
            SET @password = CONCAT(LOWER(REPLACE(NEW.nama, " ", "")), NEW.nomor_pasien);
            INSERT INTO pengguna (name, password, no_hp, alamat, jenkel, role, created_at, updated_at)
            VALUES (NEW.nama, @password, NEW.no_tlp, NEW.alamat, NEW.jk, "pasien", NOW(), NOW());
        END;
    ');


    DB::unprepared('
        CREATE TRIGGER after_ahli_gizi_insert
        AFTER INSERT ON ahli_gizi
        FOR EACH ROW
        BEGIN
            DECLARE password VARCHAR(255);
            SET @password = CONCAT(LOWER(REPLACE(NEW.nama, " ", "")), NEW.nip);
            INSERT INTO pengguna (name, password, no_hp, alamat, jenkel, role, created_at, updated_at)
            VALUES (NEW.nama, @password, NEW.no_tlp, NEW.alamat, "-", "ahli_gizi", NOW(), NOW());
        END;
    ');

    DB::unprepared('
        CREATE TRIGGER after_chef_insert
        AFTER INSERT ON chef
        FOR EACH ROW
        BEGIN
            DECLARE password VARCHAR(255);
            SET @password = CONCAT(LOWER(REPLACE(NEW.nama, " ", "")), NEW.nip);
            INSERT INTO pengguna (name, password, no_hp, alamat, jenkel, role, created_at, updated_at)
            VALUES (NEW.nama, @password, NEW.no_tlp, NEW.alamat, "-", "chef", NOW(), NOW());
        END;
    ');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_pasien_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_ahligizi_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_chef_insert');
    }
};
