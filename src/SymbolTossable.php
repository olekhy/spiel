<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

interface SymbolTossable
{
    public function toss() : Symbol;
}
