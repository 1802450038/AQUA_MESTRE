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
        Schema::create('sensors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('board_id')->constrained()->cascadeOnDelete();
            $table->string('name'); // Ex: Temperatura Ambiente
            $table->string('type'); // Ex: 'temp', 'ph', 'turbidity', 'relay'
            $table->string('model')->nullable(); // Ex: DS18B20, DHT22
            $table->integer('port_number'); // 1 a 6
            $table->boolean('is_analog')->default(false);
            $table->json('calibration_data')->nullable(); // Para calibrar pH ou Turbidez
            $table->boolean('is_active')->default(true);
            $table->string('unit')->nullable(); // Ex: °C, pH, NTU
            $table->float('min_value')->nullable(); // Valor mínimo esperado
            $table->float('max_value')->nullable(); // Valor máximo esperado
            $table->string('last_error')->nullable(); // Último erro reportado pelo sensor
            $table->timestamp('last_calibrated_at')->nullable(); // Última calibração
            $table->timestamp('last_read_at')->nullable(); // Última leitura
            $table->enum('status', ['active', 'inactive', 'error', 'maintenance'])->default('active'); // Status do sensor
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sensors');
    }
};
