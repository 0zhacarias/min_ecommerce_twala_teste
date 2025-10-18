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
        Schema::create('encomendas', function (Blueprint $table) {
            $table->id();
            $table->string('status')->default('pendente');
            $table->decimal('total_preco', 10, 2);
            $table->string('endereco_entrega');
            $table->string('metodo_pagamento');
            $table->text('observacoes')->nullable();
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->dateTime('data_encomenda');
  $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('encomendas');
    }
};
