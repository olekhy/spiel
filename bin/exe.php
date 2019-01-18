<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Olekhy\Spiel\FixStoneTossStrategy;
use Olekhy\Spiel\Gambler;
use Olekhy\Spiel\Game;
use Olekhy\Spiel\RandomSymbolTossStrategy;
use Olekhy\Spiel\Reporter;
use Olekhy\Spiel\StoneScissorPaperRules;

$bobStrategy = new FixStoneTossStrategy();
$bob = new Gambler($bobStrategy, 'Bob');
$aliceStrategy = new  RandomSymbolTossStrategy();
$alice = new Gambler($aliceStrategy, 'Alice');

$reporter = new Reporter();
$rules = new StoneScissorPaperRules();
$game = new Game($bob, $alice, $reporter);
$result = $game->play(100, $rules);

$result->print();
