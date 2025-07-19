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
        Schema::create('comptebancaires', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("numero_de_compte");
            $table->integer("code_banque");
            $table->integer("code_guichet");
            $table->integer("cle_RIB");
            $table->string("solde");
            $table->string("type_compte");
            $table->string("statut");
            $table->foreignId("user_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comptebancaires');
    }
};
