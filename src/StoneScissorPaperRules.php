<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

final class StoneScissorPaperRules
{
    /** @var int[] */
    private $rules;

    public function __construct()
    {
        $bitScissor               = 1 << SymbolEnum::SCISSOR()->getOrdinal();
        $bitStone                 = 1 << SymbolEnum::STONE()->getOrdinal();
        $bitPaper                 = 1 << SymbolEnum::PAPER()->getOrdinal();
        $this->rules[$bitScissor] = $bitScissor | $bitPaper;
        $this->rules[$bitStone]   = $bitStone | $bitScissor;
        $this->rules[$bitPaper]   = $bitPaper | $bitStone;
    }

    public function verify(Gambler $gambler, Gambler $other) : ?Gambler
    {
        $gamblerSymbol = $gambler->tossSymbol();
        $otherSymbol   = $other->tossSymbol();

        if ($gamblerSymbol->is($otherSymbol)) {
            return null;
        }

        foreach ($this->rules as $bit => $rule) {
            $bitGambler = 1 << $gamblerSymbol->getOrdinal();
            $bitOther   = 1 << $otherSymbol->getOrdinal();
            $checkA     = (bool) ($bitGambler & $rule) && ($bitOther === $bit);
            $checkB     = (bool) ($bitOther & $rule) && ($bitGambler === $bit);

            if ($checkA || $checkB) {
                return $gamblerSymbol->is(SymbolEnum::byOrdinal($bit >> 1)) ? $gambler : $other;
            }
        }

        throw new \RuntimeException('Unknown runtime error.');
    }
}
