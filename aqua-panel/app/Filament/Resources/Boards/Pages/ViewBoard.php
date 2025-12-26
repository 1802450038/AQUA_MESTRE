<?php

namespace App\Filament\Resources\Boards\Pages;

use App\Filament\Resources\Boards\BoardResource;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewBoard extends ViewRecord
{
    protected static string $resource = BoardResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),

            // Adiciona o seu botão de Download JSON
            Action::make('download_json')
                ->label('Baixar JSON')
                ->icon('heroicon-o-arrow-down-tray') // Ícone de download
                ->color('info') // Cor do botão (pode ser 'success', 'warning', etc)
                ->action(function () {
                    // Pega o registro atual (a Board que você está visualizando)
                    $record = $this->getRecord();
                    
                    // Carrega os relacionamentos para evitar queries extras
                    $record->load(['sensors', 'apiKeys']); 

                    // 1. Formata os sensores para o formato "nome" : { dados }
                    $sensoresFormatados = $record->sensors->mapWithKeys(function ($sensor) {
                        return [
                            $sensor->name => [
                                'id' => $sensor->id,
                                'type' => $sensor->type ?? 'genérico', 
                                'port_number' => $sensor->port_number,
                                'is_analog' => $sensor->is_analog,
                                'unit' => $sensor->unit,
                                'min_value' => $sensor->min_value,
                                'max_value' => $sensor->max_value,
                                'reading' => '', // Campo para leitura atual (vazio por enquanto)
                            ]
                        ];
                    });

                    // 2. Tenta pegar a API Key (pega a primeira encontrada ou define null)
                    $apiKey = $record->apiKeys->first()?->key ?? 'N/A';

                    // 3. Monta o array final
                    $dados = [
                        'id' => $record->id,
                        'name' => $record->name,
                        'api_key' => $apiKey,
                        'location' => $record->location, 
                        'sensores' => $sensoresFormatados,
                    ];

                    // 4. Gera o arquivo para download
                    $nomeArquivo = 'board-'.now()."-" . $record->id . '.json';
                    
                    return response()->streamDownload(function () use ($dados) {
                        echo json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
                    }, $nomeArquivo);
                }),
        
        ];
    }
}
