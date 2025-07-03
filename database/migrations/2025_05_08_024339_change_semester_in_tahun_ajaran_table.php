<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->dropColumn('semester');
        });

        Schema::table('tahun_ajaran', function (Blueprint $table) {
            $table->enum('semester', ['Ganjil', 'Genap'])
                ->after('tahun_ajaran')
                ->default('Ganjil');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kelas', function (Blueprint $table) {
            $table->enum('semester', ['Ganjil', 'Genap'])->default('Ganjil');
        });
        Schema::table('tahun_ajaran', function (Blueprint $table) {
            $table->dropColumn('semester');
        });
    }
};
