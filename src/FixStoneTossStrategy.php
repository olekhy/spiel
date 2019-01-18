<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

final class FixStoneTossStrategy implements TossGameStrategy
{
    public function toss() : SymbolEnum
    {
        return SymbolEnum::STONE();
    }
}
