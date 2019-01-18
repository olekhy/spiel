<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

final class Gambler implements SymbolTossable
{
    /** @var TossGameStrategy */
    private $strategy;
    /** @var string */
    private $name;

    public function __construct(TossGameStrategy $strategy, string $name)
    {
        $this->strategy = $strategy;
        $this->name     = $name;
    }

    public function tossSymbol() : SymbolEnum
    {
        return $this->strategy->toss();
    }

    public function name() : string
    {
        return $this->name;
    }
}
