<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Rule;

use Olekhy\Spiel\Gambler;

interface TwoPlayerGameRuleVerifiable
{
    public function verify(Gambler $gambler, Gambler $other) : ?Gambler;
}
