<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Tests;

use Olekhy\Spiel\Gambler;
use Olekhy\Spiel\Report\ReporterConsole;
use Olekhy\Spiel\Strategy\FixRockTossStrategy;
use Olekhy\Spiel\Strategy\TossGameStrategy;
use PHPUnit\Framework\MockObject\BadMethodCallException;
use PHPUnit\Framework\TestCase;

final class ReportConsoleTest extends TestCase
{
    /**
     * @throws \ErrorException
     */
    private function getFixtureData(string $methodName) : string
    {
        if (! \method_exists($this, $methodName)) {
            throw new BadMethodCallException(\sprintf(
                'Try to load fixture for unknown method "%s".',
                $methodName
            ));
        }
        $fixtureFile = __DIR__ . \sprintf('/Fixtures/Printer/%s.txt', $methodName);
        $fixtureData = \file_get_contents($fixtureFile);
        if ($fixtureData === false) {
            throw new \ErrorException(
                'Could not read fixture file "' . $fixtureFile . '"',
                -123
            );
        }
        return $fixtureData;
    }

    public function testReporterGamblerWinsOutput() : void
    {
        $gambler  = new Gambler(new FixRockTossStrategy(), 'name');
        $gamblers = [$gambler];
        $reporter = new ReporterConsole(... $gamblers);
        $reporter->record($gambler);
        $actual = $reporter->toString();

        $expected = $this->getFixtureData(__FUNCTION__);
        self::assertSame($expected, $actual);
    }

    public function testReporterGamblerAndAnotherWinsOutput() : void
    {
        $winStrategy = $this->createMock(TossGameStrategy::class);

        $gamblerA = new Gambler($winStrategy, 'name A');
        $gamblerB = new Gambler($winStrategy, 'name B');
        $gamblers = [
            $gamblerA,
            $gamblerB,
        ];
        $reporter = new ReporterConsole(... $gamblers);
        $reporter->record($gamblerA);
        $reporter->record($gamblerB);
        $actual = $reporter->toString();

        //\file_put_contents(
        //    __DIR__ . '/Fixtures/Printer/' . __FUNCTION__ . '.php',
        //    $actual
        //);
        $expected = $this->getFixtureData(__FUNCTION__);
        self::assertSame($expected, $actual);
    }

    public function testReporterOutputContains2DrawsOneGamblerWins1AnotherGamblerWins2AndGameWas5Rounds() : void
    {
        $winStrategy = $this->createMock(TossGameStrategy::class);

        $gamblerA = new Gambler($winStrategy, 'name A');
        $gamblerB = new Gambler($winStrategy, 'name B');
        $gamblers = [
            $gamblerA,
            $gamblerB,
        ];
        $reporter = new ReporterConsole(... $gamblers);
        $reporter->record($gamblerA);
        $reporter->record($gamblerB);
        $reporter->record($gamblerB);
        $reporter->record(null);
        $reporter->record(null);
        $actual = $reporter->toString();

        \file_put_contents(
            __DIR__ . '/Fixtures/Printer/' . __FUNCTION__ . '.txt',
            $actual
        );
        $expected = $this->getFixtureData(__FUNCTION__);
        self::assertSame($expected, $actual);
    }

    public function testReporterGameDrawOutput() : void
    {
        $gambler  = new Gambler(new FixRockTossStrategy(), 'name');
        $gamblers = [$gambler];
        $reporter = new ReporterConsole(... $gamblers);
        $reporter->record(null);
        $reporter->record(null);
        $reporter->record(null);
        $actual   = $reporter->toString();
        $expected = $this->getFixtureData(__FUNCTION__);
        self::assertSame($expected, $actual);
    }
}
