<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Strategy;

use Olekhy\Spiel\Symbol;

final class RandomSymbolTossStrategy implements TossGameStrategy
{
    public function toss() : Symbol
    {
        try {
            $int = \random_int(1, \count(Symbol::getOrdinals()));
            return Symbol::byOrdinal($int - 1);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Couldn\'t ramdomize the symbols.', -100, $exception);
        }
    }
}
