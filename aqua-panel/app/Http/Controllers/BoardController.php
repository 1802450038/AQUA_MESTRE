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
    "signal_strength": "-24"
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
}
