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
        Schema::create('boards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // Dono da placa
            $table->string('name');
            $table->string('uid')->unique(); // Identificador único do Hardware (MAC Address ou Serial)
            $table->string('ip_address')->nullable(); // Último IP conhecido
            $table->string('api_key', 64)->unique(); // Chave para o ESP32 se autenticar
            $table->string('location')->nullable();
            $table->string('wifi_ssid')->nullable(); // Apenas informativo
            $table->string('wifi_password')->nullable(); // Apenas informativo
            $table->integer('battery_level')->nullable(); // Nível de bateria em porcentagem
            $table->timestamp('last_seen_at')->nullable(); // Para saber se está online
            $table->enum('status', ['active', 'inactive', 'error', 'maintenance'])->default('active'); // Se a placa está ativa ou não
            $table->string('firmware_version')->nullable(); // Versão do firmware instalado
            $table->string('hardware_version')->nullable(); // Versão do hardware
            $table->string('last_error')->nullable(); // Último erro reportado pela placa
            $table->string('firmware_file_path')->nullable(); // Arquivo binário do firmware para atualizações OTA
            $table->boolean('ota_enabled')->default(true); // Se atualizações OTA estão habilitadas
            $table->integer('data_interval')->default(1); // Intervalo de envio de dados em minutos
            $table->integer('signal_strength')->nullable(); // Força do sinal WiFi (RSSI)
            $table->json('settings')->nullable(); // Configurações gerais (Ex: intervalo de envio)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('boards');
    }
};
