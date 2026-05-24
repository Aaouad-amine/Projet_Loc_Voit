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
        // database/migrations/xxxx_create_factures_table.php
Schema::create('factures', function (Blueprint $table) {
    $table->id();
    $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
    $table->decimal('montant_total', 10, 2);
    $table->date('date_emission');
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('factures');
    }
};
