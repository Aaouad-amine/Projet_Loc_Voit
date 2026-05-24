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
        // database/migrations/xxxx_create_voitures_table.php
Schema::create('voitures', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->string('marque');
    $table->string('modele');
    $table->year('annee');
    $table->decimal('prix_par_jour', 8, 2);
    $table->string('image')->nullable();
    $table->enum('carburant', ['Essence', 'Diesel', 'Hybride', 'Électrique'])->default('Essence');
    $table->enum('transmission', ['Manuelle', 'Automatique'])->default('Manuelle');
    $table->boolean('disponibilite')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voitures');
    }
};
