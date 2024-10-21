<?php

namespace App\Http\Controllers;

use App\Enums\Column;
use App\Services\GameService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GameController extends Controller
{
    private GameService $gameService;

    public function __construct(GameService $gameService)
    {
        $this->gameService = $gameService;
    }

    public function getState(Request $request): JsonResponse
    {
        return $this->gameService->getGameState()->eval(
            fn ($error) => response()->json(['error' => $error], 400),
            fn ($state) => response()->json([
                'columns' => $state['columns'],
                'isFinished' => $state['isFinished'],
                'status' => 'Game state retrieved successfully',
            ])
        );
    }

    public function move(Request $request, int $from, int $to): JsonResponse
    {
        return $this->gameService->moveDisk(Column::from($from), Column::from($to))->eval(
            fn ($error) => response()->json(['error' => $error], 400),
            fn ($state) => response()->json([
                'columns' => $state['columns'],
                'isFinished' => $state['isFinished'],
                'status' => 'Move successful',
            ])
        );
    }

    public function reset(Request $request): JsonResponse
    {
        return $this->gameService->resetGame()->eval(
            fn ($error) => response()->json(['error' => $error], 400),
            fn ($state) => response()->json([
                'columns' => $state['columns'],
                'isFinished' => $state['isFinished'],
                'status' => 'Game has been reset',
            ])
        );
    }
}
