<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('persona_id')->constrained()->onDelete('cascade');
            $table->foreignId('cooperativa_id')->constrained()->onDelete('cascade');
            $table->integer('cantidad_boletos')->default(1);
            $table->decimal('precio_base', 8, 2);
            $table->decimal('comision', 8, 2);
            $table->dateTime('fecha_venta');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
