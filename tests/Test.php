<?php

namespace Tests;

use App\Game;
use PHPUnit\Framework\Attributes\DataProvider;

final class Test extends \PHPUnit\Framework\TestCase
{

    public static function validCases(): array
    {
        return [
            [<<<GAME
            ...
            ...
            ...
            GAME],
            [<<<GAME
            ..X
            OOO
            X.X
            GAME],
            [<<<GAME
            X..
            OX.
            O.X
            GAME],
            [<<<GAME
            .XO
            .OX
            O.X
            GAME],
            [<<<GAME
            .XO
            OXX
            OX.
            GAME],
        ];
    }

    public static function invalidCases(): array
    {
        return [
            [''],
            [<<<GAME
            XXX
            XXX
            XXX
            GAME],

            [<<<GAME
            XXX
            OOO
            ...
            GAME],
            [<<<GAME
            XXX
            OXO
            ..X
            GAME],
            [<<<GAME
            XXX
            XXO
            XOO
            GAME],
            [<<<GAME
            X.O
            X.O
            X.O
            GAME],
            ];
    }

    #[DataProvider('validCases')]
    public function testValidCases(string $game): void
    {
        $gameService = new Game($game);

        self::assertTrue($gameService->isValid());
    }

    #[DataProvider('invalidCases')]
    public function testInvalidCases(string $game): void
    {
        $gameService = new Game($game);

        self::assertFalse($gameService->isValid());
    }


}