<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

final class Game
{
    /** @var Gambler */
    private $gambler;
    /** @var Gambler */
    private $other;
    /** @var Reporter */
    private $reporter;

    public function __construct(Gambler $gambler, Gambler $other, Reporter $reporter)
    {
        $this->gambler  = $gambler;
        $this->other    = $other;
        $this->reporter = $reporter;
    }
    public function play(int $countOfRounds, StoneScissorPaperRules $rules) : Reporter
    {
        $this->reporter->reset($this->gambler, $this->other);

        for ($i = 0; $i < $countOfRounds; $i++) {
            $result = $rules->verify($this->gambler, $this->other);
            $this->reporter->note($result);
        }

        return $this->reporter;
    }
}
