<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKomposisiObatTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('komposisi_obat', function (Blueprint $table) {
            $table->id('racikan_id');
            $table->integer('racikan_kode');
            $table->string('racikan_nama');
            $table->integer('obatalkes_kode');
            $table->string('obatalkes_nama');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komposisi_obat');
    }
}
