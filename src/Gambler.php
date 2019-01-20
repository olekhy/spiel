<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

use Olekhy\Spiel\Strategy\TossGameStrategy;

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

    public function toss() : Symbol
    {
        return $this->strategy->toss();
    }

    public function name() : string
    {
        return $this->name;
    }
}
