<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Tests;

use Olekhy\Spiel\Gambler;
use Olekhy\Spiel\Game;
use Olekhy\Spiel\Report\Reportable;
use Olekhy\Spiel\Rule\RockScissorPaperRules;
use Olekhy\Spiel\Strategy\TossGameStrategy;
use Olekhy\Spiel\Symbol;
use PHPUnit\Framework\TestCase;

final class GameTest extends TestCase
{
    public function testItAPlayerThrownASymbolByStrategy() : void
    {
        $symbol         = Symbol::ROCK();
        $playerStrategy = $this->createMock(TossGameStrategy::class);
        $playerStrategy->expects(self::once())->method('toss')->willReturn($symbol);
        $player = new Gambler($playerStrategy, 'Bob');
        $actual = $player->toss();
        self::assertSame($symbol, $actual);
    }

    public function testItAGameDraw() : void
    {
        $symbol         = Symbol::ROCK();
        $playerStrategy = $this->createMock(TossGameStrategy::class);
        $playerStrategy
            ->expects(self::exactly(2))
            ->method('toss')
            ->willReturn($symbol);

        $reporter = $this->createMock(Reportable::class);
        $reporter
            ->expects(self::once())
            ->method('record')
            ->with(null);
        $reporter
            ->expects(self::once())
            ->method('toString')
            ->willReturn('draw');

        $bob      = new Gambler($playerStrategy, 'Bob');
        $alice    = new Gambler($playerStrategy, 'Alice');
        $game     = new Game($bob, $alice, $reporter);
        $rules    = new RockScissorPaperRules();
        $reporter = $game->play(1, $rules);
        $actual   = $reporter->toString();
        self::assertSame('draw', $actual);
    }

    public function testItAPlayerWins() : void
    {
        $symbolStone         = Symbol::ROCK();
        $symbolScissor       = Symbol::SCISSOR();
        $playerStrategyStone = $this->createMock(TossGameStrategy::class);
        $playerStrategyStone->expects(self::once())->method('toss')->willReturn($symbolStone);

        $playerStrategyScissor = $this->createMock(TossGameStrategy::class);
        $playerStrategyScissor->expects(self::once())->method('toss')->willReturn($symbolScissor);

        $reporter = $this->createMock(Reportable::class);
        $reporter
            ->expects(self::once())
            ->method('toString')
            ->willReturn('Bob');

        $rules = new RockScissorPaperRules();
        $bob   = new Gambler($playerStrategyStone, 'Bob');
        $alice = new Gambler($playerStrategyScissor, 'Alice');
        $game  = new Game($bob, $alice, $reporter);

        $game->play(1, $rules);

        $actual = $reporter->toString();
        self::assertSame(
            'Bob',
            $actual
        );
    }

    public function testGameRulesRockWinsWhenTossRockAndScissor() : void
    {
        $gameRules     = new RockScissorPaperRules();
        $strategyStone = $this->createMock(TossGameStrategy::class);
        $strategyStone->expects(self::once())->method('toss')->willReturn(Symbol::ROCK());
        $gamblerStone = new Gambler($strategyStone, 'Steiner');

        $strategyScissor = $this->createMock(TossGameStrategy::class);
        $strategyScissor->expects(self::once())->method('toss')->willReturn(Symbol::SCISSOR());
        $otherScissor = new Gambler($strategyScissor, 'Friseur');

        $actual = $gameRules->verify($gamblerStone, $otherScissor);
        self::assertSame($gamblerStone, $actual);
    }

    public function testGameRulesScissorWinsWhenTossPaperAndScissor() : void
    {
        $gameRules     = new RockScissorPaperRules();
        $strategyPaper = $this->createMock(TossGameStrategy::class);
        $strategyPaper->expects(self::once())->method('toss')->willReturn(Symbol::PAPER());
        $gamblerPaper = new Gambler($strategyPaper, 'Author');

        $strategyScissor = $this->createMock(TossGameStrategy::class);
        $strategyScissor->expects(self::once())->method('toss')->willReturn(Symbol::SCISSOR());
        $otherScissor = new Gambler($strategyScissor, 'Friseur');

        $actual = $gameRules->verify($gamblerPaper, $otherScissor);
        self::assertSame($otherScissor, $actual);
    }

    public function testGameRulesPaperWinsWhenTossPaperAndRock() : void
    {
        $gameRules     = new RockScissorPaperRules();
        $strategyPaper = $this->createMock(TossGameStrategy::class);
        $strategyPaper->expects(self::once())->method('toss')->willReturn(Symbol::PAPER());
        $gamblerPaper = new Gambler($strategyPaper, 'Printer');

        $strategyStone = $this->createMock(TossGameStrategy::class);
        $strategyStone->expects(self::once())->method('toss')->willReturn(Symbol::ROCK());
        $otherStone = new Gambler($strategyStone, 'Steiner');

        $actual = $gameRules->verify($gamblerPaper, $otherStone);
        self::assertSame($gamblerPaper, $actual);
    }
}
