<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Data Mahasiswa
     *
     * Nama Lengkap
     * Tempat Tanggal Lahir
     * Alamat
     * Suku/Asal
     * Username (menggunakan NPM/NIM yang akan saya kirimkan sebagai data awal)
     * Password (untuk awal diacak saja nanti dilist)
     * Email (gmail yang tervalidasi)
     * No Telp/Whatsapp
     * Hobi
     * Tentang diri
     * Foto
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name');
            $table->string('place_of_birth');
            $table->date('date_of_birth');
            $table->text('address');
            $table->string('etnic');
            $table->string('username');
            $table->string('email');
            $table->string('phone');
            $table->string('hobby');
            $table->text('bio');
            $table->string('image');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
