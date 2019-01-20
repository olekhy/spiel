<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Olekhy\Spiel\Gambler;
use Olekhy\Spiel\Game;
use Olekhy\Spiel\Report\ReporterConsole;
use Olekhy\Spiel\Rule\RockScissorPaperRules;
use Olekhy\Spiel\Strategy\FixRockTossStrategy;
use Olekhy\Spiel\Strategy\RandomSymbolTossStrategy;

$bobStrategy   = new FixRockTossStrategy();
$aliceStrategy = new RandomSymbolTossStrategy();

$bob   = new Gambler($bobStrategy, 'Bob');
$alice = new Gambler($aliceStrategy, 'Alice');

$reporter = new ReporterConsole($bob, $alice);
$rules    = new RockScissorPaperRules();
$game     = new Game($bob, $alice, $reporter);
$result   = $game->play(100, $rules);

\system('clear');
$result->print();
