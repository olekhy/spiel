<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

interface TossGameStrategy
{
    public function toss() : SymbolEnum;
}
