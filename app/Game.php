<?php

declare(strict_types=1);

namespace App;

final readonly class Game
{
    /** 3x3 array with X or O elements */
    private array $game;

    public function __construct(string $game)
    {
        $this->game = (array_map(function (string $gameLine) {
            return str_split($gameLine);
        }, explode("\n", $game)));
    }

    public function isValid(): bool
    {
        if (!$this->isBoard3x3()) {
            return false;
        }

        if (!$this->hasProperOrderOfMoves()) {
            return false;
        }

        if ($this->hasRowWin("X") && $this->hasRowWin("O")) {
            return false;
        }
        if ($this->hasColWin("X") && $this->hasColWin("O")) {
            return false;
        }

        return true;
    }

    private function isBoard3x3(): bool
    {
        if (count($this->game[0]) !== 3 || count($this->game[1]) !== 3 || count($this->game[2]) !== 3) {
            return false;
        }

        return true;
    }

    public function hasProperOrderOfMoves(): bool
    {
        list($countX, $countO) = $this->countElements();

        if (!in_array($countX, [$countO, $countO + 1])) {
            return false;
        }

        return true;
    }

    /** returns array for simplicity, in real world I would prefer DTO with known properties */
    private function countElements(): array
    {
        $countO = 0;
        $countX = 0;

        foreach ($this->game as $line) {
            foreach ($line as $item) {
                if ($item === "X") {
                    $countX++;
                }
                if ($item === "O") {
                    $countO++;
                }
            }
        }

        return [$countX, $countO];
    }

    public function hasRowWin(string $player): bool
    {
        foreach ($this->game as $lineIndex => $line) {
            if ($this->game[$lineIndex][0] === $player && $this->game[$lineIndex][1] === $player && $this->game[$lineIndex][2] === $player) {
                return true;
            }
        }

        return false;
    }

    public function hasColWin(string $player): bool
    {
        //3 is hardcoded, it should be const somewhere, I am not sure if it is prepared to handle different sizes of a game :)
        for ($i = 0; $i < 3; $i++) {
            $countedValues = array_count_values(array_column($this->game, $i));
            if (isset($countedValues[$player]) && $countedValues[$player] === 3) {
                return true;
            }
        }

        return false;
    }

    //maybe not needed
    public function hasDiagWin(string $player): bool
    {
        if ($this->game[0][0] === $player && $this->game[1][1] === $player && $this->game[2][2] === $player) {
            return true;
        }

        if ($this->game[0][2] === $player && $this->game[1][1] === $player && $this->game[2][0] === $player) {
            return true;
        }

        return false;
    }
}