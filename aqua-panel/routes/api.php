<?php

use App\Http\Controllers\BoardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('board')->group(function () {

    // localhost:8000/api/board/serverStatus 
    Route::get('/serverStatus', function () {
        return response()->json([
            'message' => 'Tudo certo por aqui!',
            'status' => 200
        ]);
    });

    // HandShake, execute once on board startup
    // localhost:8000/api/board/check-api-key
    Route::post('/check-api-key', [BoardController::class, 'checkApiKey']);

    // localhost:8000/api/board/update-board-values
    Route::post('update-board-values', [BoardController::class, 'updateBoardValues']);

    // localhost:8000/api/board/get-board-values
    Route::get('get-board-values', [BoardController::class, 'getBoardValues']);

    // localhost:8000/api/board/get-board-sensors
    Route::get('get-board-sensors', [BoardController::class, 'getBoardSensors']);

    // localhost:8000/api/board/update-sensor-value
    Route::post('update-sensor-value', [BoardController::class, 'updateSensorValue']);

    // localhost:8000/api/board/update-board-info?board_id={board_id}&api_key={api_key}
    Route::post('update-board-info?board_id={board_id}&api_key={api_key}', [BoardController::class, 'updateBoardInfo']);

    // localhost:8000/api/board/update-board-status?board_id={board_id}&api_key={api_key}&status={status}
    Route::post('update-board-status?board_id={board_id}&api_key={api_key}&status={status}', [BoardController::class, 'updateBoardStatus']);
});
