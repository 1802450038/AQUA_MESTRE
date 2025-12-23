<?php

namespace App\Http\Controllers;

use App\Models\Apikey;
use App\Models\Board;
use Illuminate\Http\Request;

class BoardController extends Controller
{

    public function checkApiKey(Request $request)
    {
        // 1. Pega a chave enviada (pelo Header ou Body)
        $token = $request->input('api_key'); // ou $request->input('api_key')

        // 2. Busca o registro no banco
        $apikey = Apikey::where('key', $token)->first();

        // 3. Validação: Verifica se a chave existe
        if (!$apikey) {
            return response()->json(['error' => 'API Key inválida.'], 401);
        }

        // 4. NOVA VALIDAÇÃO: Verifica se a chave está ativa
        // Como na sua tabela o campo é 'is_active' (provavelmente 0 ou 1)
        if (!$apikey->is_active) {
            return response()->json(['error' => 'Esta API Key está desativada.'], 403);
        }

        // --- Se passou daqui, o código segue normal ---

        // Se precisar pegar o board dono da chave:
        $board = $apikey->board;

        return response()->json(
            [
                'message' => 'Dados recebidos com sucesso!',
                'board' => $board // Se quiser retornar dados do board
            ]
        );
    }

    public function getBoardByApiKey($key)
    {
        $apikey = Apikey::where('key', $key)->first();
        $board = $apikey->board;
        if (!$apikey || !$apikey->is_active) {
            return response()->json(['error' => 'API Key inválida ou inativa.'], 401);
        }
        return response()->json(['board' => $board]);
    }



    /*
    Atualiza os valores da placa com base na API Key fornecida.
    Payload esperado body (exemplo):
    {
    "api_key": "Chave API-Placa",
    "uid": "34:25:C9:D3:B9",
    "wifi_ssid": "wifi_teste",
    "wifi_password":"Senha do wifi",
    "battery_level": "40",
    "last_error": "Erro 32",
    "signal_strength": "-24",
    "firmware_version" : "v1.0.3",
    "hardware_version" : "v1.0.0"
    }
    */
    public function updateBoardValues(Request $request)
    {
        $apiKey = $request->input('api_key');
        $board = $this->getBoardByApiKey($apiKey)->original['board'];

        if (!$board) {
            return response()->json(['error' => 'Placa não encontrada.'], 404);
        }

        // Atualiza os valores da placa com os dados recebidos
        $board->uid = $request->input('uid', $board->uid);
        $board->wifi_ssid = $request->input('wifi_ssid', $board->wifi_ssid);
        $board->wifi_password = $request->input('wifi_password', $board->wifi_password);
        $board->battery_level = $request->input('battery_level', $board->battery_level);
        $board->signal_strength = $request->input('signal_strength', $board->signal_strength);
        $board->last_error = $request->input('last_error', $board->last_error);
        $board->last_seen_at = now();
        $board->ip_address = $request->ip();
        // Adicione outros campos conforme necessário

        $board->save();

        return response()->json(['message' => 'Valores da placa atualizados com sucesso.']);
    }


    public function getBoardValues(Request $request)
    {
        $apiKey = $request->input('api_key');
        $board = $this->getBoardByApiKey($apiKey)->original['board'];


        if (!$board) {

            return response()->json(['error' => 'Placa não encontrada.'], 404);
        }

        $boardReturnValues = [
            'wifi_ssid' => $board->wifi_ssid,
            'wifi_password' => $board->wifi_password,
            'data_interval' => $board->data_interval,
            'ota_enabled' => $board->ota_enabled,
            'firmware_file_path' => $board->firmware_file_path,
        ];

        return response()->json(['board_values' => $boardReturnValues]);
    }

    public function getBoardSensors(Request $request)
    {
        $apiKey = $request->input('api_key');
        $board = $this->getBoardByApiKey($apiKey)->original['board'];

        if (!$board) {
            return response()->json(['error' => 'Placa não encontrada.'], 404);
        }

        $sensors = $board->sensors; // Supondo que você tenha uma relação 'sensors' definida no modelo Board

        return response()->json(['sensors' => $sensors]);
    }


    /* Atualiza o valor de um sensor específico da placa.
    Payload esperado body (exemplo):
    {
    "api_key": "01e0423be215ad9942f3ca91b64e6cac3d5b6474e6b545cded4c4c8f36ea67a6",
    "sensor_id" : "1",
    "is_active" : "true",
    "last_error" : "Erro 0",
    "reading" : "3"
    }
    */
    public function updateSensorValue(Request $request)
    {
        $apiKey = $request->input('api_key');
        $sensorId = $request->input('sensor_id');

        $board = $this->getBoardByApiKey($apiKey)->original['board'];
        if (!$board) {
            return response()->json(['error' => 'Placa não encontrada.'], 404);
        }

        $sensor = $board->sensors->where('id', $sensorId)->first();
        if (!$sensor) {
            return response()->json(['error' => 'Sensor não encontrado.'], 404);
        }

        $sensor->is_active = $request->input('is_active', $sensor->is_active);
        $sensor->last_error = $request->input('last_error', $sensor->last_error);
        $sensor->last_read_at = now();
        $sensor->save();

        if ($request->has('reading')) {
            $sensor->measurements()->create([
                'value' => $request->input('reading'),
            ]);
        }


        return response()->json(['message' => 'Valor do sensor atualizado com sucesso.']);
    }
}
