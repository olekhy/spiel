<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

use MabeEnum\EnumSet;

final class RandomSymbolTossStrategy implements TossGameStrategy
{
    /** @var EnumSet  */
    private $symbolsSet;

    public function __construct()
    {
        $this->symbolsSet = new EnumSet(SymbolEnum::class);
        $this->symbolsSet->attach(SymbolEnum::PAPER());
        $this->symbolsSet->attach(SymbolEnum::SCISSOR());
        $this->symbolsSet->attach(SymbolEnum::STONE());
    }

    public function toss() : SymbolEnum
    {
        try {
            $int = \random_int(1, $this->symbolsSet->count());
            return SymbolEnum::byOrdinal($int - 1);
        } catch (\Throwable $exception) {
            throw new \RuntimeException('Couldn\'t ramdomize the symbols.', 0, $exception);
        }
    }
}
