<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Nama lengkap
     * Tempat / tanggal lahir
     * Pendidikan s1,s2,s3
     * Pengalaman
     * Username
     * Password
     * Email aktif
     * No hp / wa
     * Alamat
     * Essay tentang diri
     * Tempat kerja
     * Foto
     */
    public function up(): void
    {
        Schema::create('counselors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('name');
            $table->enum('education', ['S1', 'S2', 'S3']);
            $table->string('experience');
            $table->string('username');
            $table->string('email');
            $table->string('phone');
            $table->text('address');
            $table->longText('essay');
            $table->string('office');
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
        Schema::dropIfExists('counselors');
    }
};
