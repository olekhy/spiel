<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Report;

use Olekhy\Spiel\Gambler;

final class ReporterConsole implements Reportable
{
    /** @var int[] */
    private $lines;
    /** @var int */
    private $draws;
    /** @var string */
    private $marginLeft;
    /** @var int */
    private $marginTop;
    /** @var string */
    private $redColor;
    /** @var string */
    private $colorOff;
    /** @var string */
    private $cyanColor;
    /** @var string */
    private $yellowColor;

    public function __construct(Gambler ...$gamblers)
    {
        $this->draws = 0;

        foreach ($gamblers as $gambler) {
            $splHash                       = \spl_object_hash($gambler);
            $this->lines[$splHash]['name'] = $gambler->name();
            $this->lines[$splHash]['wins'] = 0;
        }
        $this->marginTop   = 10;
        $this->marginLeft  = \str_pad('', 22, ' ');
        $this->redColor    = "\033[0;31m";
        $this->yellowColor = "\033[0;33m";
        $this->cyanColor   = "\033[0;35m";
        $this->colorOff    = "\033[0m";
    }

    public function reset() : void
    {
        $this->draws = 0;
        foreach ($this->lines as &$line) {
            $line['name'] = null;
            $line['wins'] = 0;
        }
    }

    public function record(?Gambler $gambler) : void
    {
        if ($gambler === null) {
            $this->draws++;
        } else {
            $this->lines[\spl_object_hash($gambler)]['name'] = $gambler->name();
            $this->lines[\spl_object_hash($gambler)]['wins']++;
        }
    }

    public function print() : void
    {
        echo $this->toString();
    }

    public function toString() : string
    {
        $names = \array_column($this->lines, 'name');
        $wins  = \array_column($this->lines, 'wins');
        $games = \array_sum($wins) + $this->draws;

        $lines  = [];
        $labels = [];
        $values = [];

        $lines[]  = '.==================================================.';
        $lines[]  = '| '
            . $this->redColor
            . 'Rock' . $this->colorOff
            . $this->cyanColor
            . ' scissor'
            . $this->colorOff
            . ' and'
            . $this->yellowColor
            . ' paper'
            . $this->colorOff
            . ' the game of the year'
            . $this->redColor
            . ' 2018'
            . $this->colorOff
            . ' |';
        $lines[]  = '`==================================================\'';
        $labels[] = ' Game rounds: ';
        $values[] = $games;
        $labels[] = ' Game' . ($this->draws > 1 || $this->draws === 0 ? 's' : '') . ' with draw: ';
        $values[] = $this->draws;

        $statistic = \array_combine($names, $wins);

        foreach ((array) $statistic as $name => $winsCount) {
            $labels[] = ' ' . $name . ' wins: ';
            $values[] = $winsCount;
        }

        $max = \strlen(\max($labels)) + \strlen((string) $games) + 27;

        foreach ($labels as $label) {
            $line    = \str_pad($label, $max) . \array_shift($values);
            $lines[] = $line;
            $lines[] = \str_pad(' ', \strlen($line), '-');
        }

        $this->reset();
        $marginTop = \str_pad('', $this->marginTop, \PHP_EOL) . $this->marginLeft;

        return $marginTop
            . \implode(\PHP_EOL . $this->marginLeft, $lines)
            . $marginTop;
    }

    public function __toString() : string
    {
        return $this->toString();
    }
}
