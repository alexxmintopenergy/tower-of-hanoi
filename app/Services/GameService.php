<?php

namespace App\Services;

use App\Constants\GameConstants;
use App\Enums\Column;
use Illuminate\Support\Facades\Session;
use Marcosh\LamPHPda\Either;

class GameService
{
    public function getGameState(): Either
    {
        $columns = $this->ensureGameInitialized();

        return Either::right([
            'columns' => $columns,
            'isFinished' => $this->isGameFinished($columns),
        ]);
    }

    public function moveDisk(Column $from, Column $to): Either
    {
        $columns = $this->ensureGameInitialized();

        if ($this->isGameFinished($columns)) {
            return Either::left('Game is already finished');
        }

        try {
            $this->validateMove($columns, $from, $to);
        } catch (\InvalidArgumentException $e) {
            return Either::left($e->getMessage());
        }

        $disk = array_pop($columns[$from->value]);
        $columns[$to->value][] = $disk;

        Session::put(GameConstants::SESSION_KEY, $columns);

        return Either::right([
            'columns' => $columns,
            'isFinished' => $this->isGameFinished($columns),
        ]);
    }

    public function resetGame(): Either
    {
        $initialState = $this->getInitialState();

        Session::put(GameConstants::SESSION_KEY, $initialState);

        return Either::right([
            'columns' => $initialState,
            'isFinished' => false,
        ]);

    }

    private function initializeGame(): array
    {
        $initialState = $this->getInitialState();
        Session::put(GameConstants::SESSION_KEY, $initialState);

        return [
            'columns' => $initialState,
            'isFinished' => false,
        ];
    }

    private function getInitialState(): array
    {

        return [
            Column::FIRST->value => range(GameConstants::NUM_DISKS, GameConstants::SMALLEST_DISK),
            Column::SECOND->value => [],
            Column::THIRD->value => [],
        ];

    }

    private function isGameFinished(array $columns): bool
    {
        return count($columns[Column::THIRD->value]) === GameConstants::NUM_DISKS;
    }

    private function validateMove(array $columns, Column $from, Column $to): void
    {
        if (empty($columns[$from->value])) {
            throw new \InvalidArgumentException('No disks on the source column');
        }

        $disk = end($columns[$from->value]);

        if (! empty($columns[$to->value]) && $disk > end($columns[$to->value])) {
            throw new \InvalidArgumentException('Cannot place a larger disk on top of a smaller one');
        }
    }

    private function ensureGameInitialized(): array
    {
        if (! Session::has(GameConstants::SESSION_KEY)) {
            return $this->initializeGame();
        }

        return Session::get(GameConstants::SESSION_KEY);
    }
}
