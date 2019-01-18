<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

final class Reporter
{
    /** @var int[] */
    private $lines;

    public function reset(Gambler $gambler, Gambler $other) : void
    {
        $this->lines = [
            'DRAW' => 0,
            $gambler->name() => 0,
            $other->name() => 0,
        ];
    }

    public function note(?Gambler $gambler) : void
    {
        if ($gambler === null) {
            $this->lines['DRAW']++;
        } else {
            $this->lines[$gambler->name()]++;
        }
    }

    public function print() : void
    {
        echo $this;
    }

    public function __toString() : string
    {
        $lines  = [];
        $labels = [];
        $values = [];
        $games  = \array_sum($this->lines);
        $draw   = $this->lines['DRAW'];
        unset($this->lines['DRAW']);

        $lines[]  = 'Stone scissor and paper the game of the year 2018';
        $lines[]  = '=================================================';
        $labels[] =  'Game rounds: ';
        $values[] = $games;
        $labels[] =  'Game' . ($draw > 1 || $draw === 0 ? 's' : '') . ' with draw: ';
        $values[] = $draw;

        \asort($this->lines);

        foreach ($this->lines as $name => $winsCount) {
            $labels[] = $name . ' wins: ';
            $values[] = $winsCount;
        }

        $max = \strlen(\max($labels));

        foreach ($labels as $label) {
            $line    = \str_pad($label, $max) . \array_shift($values);
            $lines[] = $line;
            $lines[] = \str_pad('', \strlen($line), '-');
        }

        return \implode(\PHP_EOL, $lines) . \PHP_EOL;
    }
}
