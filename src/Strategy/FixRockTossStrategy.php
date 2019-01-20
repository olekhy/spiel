<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Strategy;

use Olekhy\Spiel\Symbol;

final class FixRockTossStrategy implements TossGameStrategy
{
    public function toss() : Symbol
    {
        return Symbol::ROCK();
    }
}
