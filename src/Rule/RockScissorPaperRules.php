<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Rule;

use Olekhy\Spiel\Gambler;
use Olekhy\Spiel\Symbol;

final class RockScissorPaperRules implements TwoPlayerGameRuleVerifiable
{
    /** @var int[] */
    private $rules;

    public function __construct()
    {
        $bitScissor               = 1 << Symbol::SCISSOR()->getOrdinal();
        $bitStone                 = 1 << Symbol::ROCK()->getOrdinal();
        $bitPaper                 = 1 << Symbol::PAPER()->getOrdinal();
        $this->rules[$bitScissor] = $bitScissor | $bitPaper;
        $this->rules[$bitStone]   = $bitStone | $bitScissor;
        $this->rules[$bitPaper]   = $bitPaper | $bitStone;
    }

    public function verify(Gambler $gambler, Gambler $other) : ?Gambler
    {
        $gamblerSymbol = $gambler->toss();
        $otherSymbol   = $other->toss();

        if ($gamblerSymbol->is($otherSymbol)) {
            return null;
        }

        $winner = null;
        foreach ($this->rules as $bit => $rule) {
            $bitGambler = 1 << $gamblerSymbol->getOrdinal();
            $bitOther   = 1 << $otherSymbol->getOrdinal();

            if (($bitGambler & $rule) > 0 && ($bitOther === $bit)) {
                $winner = $other;
                break;
            }

            if (($bitOther & $rule) > 0 && ($bitGambler === $bit)) {
                $winner = $gambler;
                break;
            }
        }

        return $winner;
    }
}
