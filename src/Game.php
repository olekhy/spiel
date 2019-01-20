<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

use Olekhy\Spiel\Report\Reportable;
use Olekhy\Spiel\Rule\TwoPlayerGameRuleVerifiable;

final class Game
{
    /** @var Gambler */
    private $gambler;
    /** @var Gambler */
    private $other;
    /** @var Reportable */
    private $reporter;

    public function __construct(Gambler $gambler, Gambler $other, Reportable $reporter)
    {
        $this->gambler  = $gambler;
        $this->other    = $other;
        $this->reporter = $reporter;
    }
    public function play(int $countOfRounds, TwoPlayerGameRuleVerifiable $rules) : Reportable
    {
        $this->reporter->reset();

        for ($i = 0; $i < $countOfRounds; $i++) {
            $result = $rules->verify($this->gambler, $this->other);
            $this->reporter->record($result);
        }

        return $this->reporter;
    }
}
