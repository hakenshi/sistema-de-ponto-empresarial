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
        Schema::table('pontos', function (Blueprint $table) {
            $table->renameColumn('data_hora_batida', 'data_hora_entrada');
            $table->dateTime('data_hora_saida')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_hora_entrada_on_pontos', function (Blueprint $table) {
            //
        });
    }
};
