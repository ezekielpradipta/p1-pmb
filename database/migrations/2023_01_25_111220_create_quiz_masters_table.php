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
        Schema::create('quiz_masters', function (Blueprint $table) {
            $table->id();
            $table->string('judul_quiz');
            $table->string('gambar_quiz')->nullable();
            $table->string('deskripsi_quiz')->nullable();
            $table->string('jenis_quiz');
            $table->text('option_1');
            $table->text('option_2');
            $table->text('option_3');
            $table->text('option_4');
            $table->string('jawaban_benar')->nullable();
            $table->enum('is_active',['0','1'])->default('0');
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
        Schema::dropIfExists('quiz_masters');
    }
};
