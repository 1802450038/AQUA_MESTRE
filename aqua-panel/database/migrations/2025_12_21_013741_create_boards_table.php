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
            $table->string('uid')->unique(); // Identificador único do Hardware (MAC Address ou Serial) P->S
            $table->string('ip_address')->nullable(); // Último IP conhecido P->S
            $table->string('api_key', 64)->unique(); // Chave para o ESP32 se autenticar P->S
            $table->string('location')->nullable(); 
            $table->string('wifi_ssid')->nullable(); // Apenas informativo P->S
            $table->string('wifi_password')->nullable(); // Apenas informativo
            $table->integer('battery_level')->nullable(); // Nível de bateria em porcentagem P->S
            $table->timestamp('last_seen_at')->nullable(); // Para saber se está online 
            $table->enum('status', ['active', 'inactive', 'error', 'maintenance'])->default('active'); // Se a placa está ativa ou não S->P
            $table->string('firmware_version')->nullable(); // Versão do firmware instalado P->S
            $table->string('hardware_version')->nullable(); // Versão do hardware P->S
            $table->string('last_error')->nullable(); // Último erro reportado pela placa P->S
            $table->string('firmware_file_path')->nullable(); // Arquivo binário do firmware para atualizações OTA S->P
            $table->boolean('ota_enabled')->default(true); // Se atualizações OTA estão habilitadas S->P
            $table->integer('data_interval')->default(1); // Intervalo de envio de dados em minutos S->P
            $table->integer('signal_strength')->nullable(); // Força do sinal WiFi (RSSI) P->S
            $table->json('settings')->nullable(); // Configurações gerais (Ex: intervalo de envio) S->P
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
