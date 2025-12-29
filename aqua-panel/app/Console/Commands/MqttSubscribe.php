<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\Facades\MQTT;
use App\Models\Apikey;
use App\Models\Board;
use Illuminate\Support\Facades\Log;

class MqttSubscribe extends Command
{
    protected $signature = 'mqtt:subscribe';
    protected $description = 'Assina tópicos MQTT para receber dados dos sensores';

    public function handle()
    {
        $this->info('Iniciando o assinante MQTT...');

        // Assina o tópico de todas as placas. 
        // O '+' é um wildcard. Ex: boards/qualquer_coisa/update
        $topic = 'boards/+/update'; 

        MQTT::connection()->subscribe($topic, function (string $topic, string $message) {
            $this->info("Mensagem recebida em [$topic]: $message");
            
            try {
                $payload = json_decode($message, true);
                $this->processMessage($payload);
            } catch (\Exception $e) {
                Log::error("Erro ao processar MQTT: " . $e->getMessage());
            }
        }, 0);

        // Mantém o loop rodando
        MQTT::connection()->loop(true);
    }

    private function processMessage(array $data)
    {
        // 1. Validação da API Key (Reutilizando sua lógica)
        if (!isset($data['api_key'])) {
            $this->error('API Key não fornecida.');
            return;
        }

        $apikey = Apikey::where('key', $data['api_key'])->first();

        if (!$apikey || !$apikey->is_active) {
            $this->error('Chave inválida ou inativa.');
            return;
        }

        $board = $apikey->board;

        if (!$board) {
            $this->error('Placa não encontrada.');
            return;
        }

        // 2. Atualiza status da placa (Reutilizando lógica do updateBoardValues)
        $board->last_seen_at = now();
        if (isset($data['wifi_ssid'])) $board->wifi_ssid = $data['wifi_ssid'];
        if (isset($data['battery_level'])) $board->battery_level = $data['battery_level'];
        // Adicione outros campos se vierem no JSON...
        $board->save();

        // 3. Atualiza Sensores (Reutilizando lógica do updateSensorsValues)
        if (isset($data['sensores']) && is_array($data['sensores'])) {
            foreach ($data['sensores'] as $sensorInfo) {
                // Busca o sensor pelo ID ou outro identificador único enviado pelo ESP
                // Nota: O ESP deve enviar o ID correto do sensor no banco ou um identificador fixo
                $sensor = $board->sensors->where('id', $sensorInfo['id'])->first(); 

                if ($sensor) {
                    $sensor->last_read_at = now();
                    $sensor->save();

                    if (isset($sensorInfo['reading'])) {
                        $sensor->measurements()->create([
                            'value' => $sensorInfo['reading'],
                        ]);
                        $this->info("Leitura salva: Sensor {$sensor->name} = {$sensorInfo['reading']}");
                    }
                }
            }
        }
    }
}