<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Tests;

use Olekhy\Spiel\Strategy\FixRockTossStrategy;
use Olekhy\Spiel\Symbol;
use PHPUnit\Framework\TestCase;

final class TossStrategyTest extends TestCase
{
    public function testFixRockTossStrategy() : void
    {
        $symbol = new FixRockTossStrategy();
        self::assertSame(Symbol::ROCK(), $symbol->toss());
    }
}
