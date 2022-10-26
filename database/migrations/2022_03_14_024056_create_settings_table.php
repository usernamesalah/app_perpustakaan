<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->decimal('denda', 10, 2);
            $table->integer('max_pinjam');
            $table->integer('hari_pinjam');
            $table->integer('hari_extend');
            $table->string('alamat');
            $table->string('telpon');
            $table->string('email');
            $table->string('pemangku');
            $table->string('nip_pemangku');
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
        Schema::dropIfExists('settings');
    }
}
