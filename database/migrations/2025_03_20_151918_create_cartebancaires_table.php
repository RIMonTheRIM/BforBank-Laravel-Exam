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
        Schema::create('cartebancaires', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("numero_carte");
            $table->date("date_expiration");
            $table->smallInteger("CVV");
            $table->string("statut");
            $table->foreignId("comptebancaire_id");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartebancaires');
    }
};
