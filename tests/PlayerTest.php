<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Tests;

use Olekhy\Spiel\Gambler;
use Olekhy\Spiel\Game;
use Olekhy\Spiel\Reporter;
use Olekhy\Spiel\StoneScissorPaperRules;
use Olekhy\Spiel\SymbolEnum;
use Olekhy\Spiel\TossGameStrategy;
use PHPUnit\Framework\TestCase;

final class PlayerTest extends TestCase
{
    public function testItAPlayerThrownASymbolByStrategy() : void
    {
        $symbol         = SymbolEnum::STONE();
        $playerStrategy = $this->createMock(TossGameStrategy::class);
        $playerStrategy->expects(self::once())->method('toss')->willReturn($symbol);
        $player = new Gambler($playerStrategy, 'Bob');
        $actual = $player->tossSymbol();
        self::assertSame($symbol, $actual);
    }

    public function testItAGame() : void
    {
        $symbol         = SymbolEnum::STONE();
        $playerStrategy = $this->createMock(TossGameStrategy::class);
        $playerStrategy->expects(self::exactly(2))->method('toss')->willReturn($symbol);

        $reporter = new Reporter();
        $bob      = new Gambler($playerStrategy, 'Bob');
        $alice    = new Gambler($playerStrategy, 'Alice');
        $game     = new Game($bob, $alice, $reporter);
        $rules    = new StoneScissorPaperRules();
        $reporter = $game->play(1, $rules);
        $actual   = (string) $reporter;
        self::assertSame(
            'Stone scissor and paper the game of the year 2018
=================================================
Game rounds:    1
-----------------
Game with draw: 1
-----------------
Bob wins:       0
-----------------
Alice wins:     0
-----------------
',
            $actual
        );
    }

    public function testItAPlayerWins() : void
    {
        $symbolStone         = SymbolEnum::STONE();
        $symbolScissor       = SymbolEnum::SCISSOR();
        $playerStrategyStone = $this->createMock(TossGameStrategy::class);
        $playerStrategyStone->expects(self::once())->method('toss')->willReturn($symbolStone);

        $playerStrategyScissor = $this->createMock(TossGameStrategy::class);
        $playerStrategyScissor->expects(self::once())->method('toss')->willReturn($symbolScissor);

        $rules = new StoneScissorPaperRules();

        $reporter = new Reporter();
        $bob      = new Gambler($playerStrategyStone, 'Bob');
        $alice    = new Gambler($playerStrategyScissor, 'Alice');
        $game     = new Game($bob, $alice, $reporter);
        $game->play(1, $rules);
        $actual = (string) $reporter;
        self::assertSame(
            'Stone scissor and paper the game of the year 2018
=================================================
Game rounds:     1
------------------
Games with draw: 0
------------------
Alice wins:      0
------------------
Bob wins:        1
------------------
',
            $actual
        );
    }

    public function testGameRulesStoneWinsWhenTossStoneAndScissor() : void
    {
        $gameRules     = new StoneScissorPaperRules();
        $strategyStone = $this->createMock(TossGameStrategy::class);
        $strategyStone->expects(self::once())->method('toss')->willReturn(SymbolEnum::STONE());
        $gamblerStone = new Gambler($strategyStone, 'Stone');

        $strategyScissor = $this->createMock(TossGameStrategy::class);
        $strategyScissor->expects(self::once())->method('toss')->willReturn(SymbolEnum::SCISSOR());
        $otherScissor = new Gambler($strategyScissor, 'Scissor');

        $actual = $gameRules->verify($gamblerStone, $otherScissor);
        self::assertSame($gamblerStone, $actual);
    }

    public function testGameRulesScissorWinsWhenTossPaperAndScissor() : void
    {
        $gameRules     = new StoneScissorPaperRules();
        $strategyPaper = $this->createMock(TossGameStrategy::class);
        $strategyPaper->expects(self::once())->method('toss')->willReturn(SymbolEnum::PAPER());
        $gamblerPaper = new Gambler($strategyPaper, 'Paper');

        $strategyScissor = $this->createMock(TossGameStrategy::class);
        $strategyScissor->expects(self::once())->method('toss')->willReturn(SymbolEnum::SCISSOR());
        $otherScissor = new Gambler($strategyScissor, 'Scissor');

        $actual = $gameRules->verify($gamblerPaper, $otherScissor);
        self::assertSame($otherScissor, $actual);
    }

    public function testGameRulesPaperWinsWhenTossPaperAndStone() : void
    {
        $gameRules     = new StoneScissorPaperRules();
        $strategyPaper = $this->createMock(TossGameStrategy::class);
        $strategyPaper->expects(self::once())->method('toss')->willReturn(SymbolEnum::PAPER());
        $gamblerPaper = new Gambler($strategyPaper, 'Paper');

        $strategyStone = $this->createMock(TossGameStrategy::class);
        $strategyStone->expects(self::once())->method('toss')->willReturn(SymbolEnum::STONE());
        $otherStone = new Gambler($strategyStone, 'Stone');

        $actual = $gameRules->verify($gamblerPaper, $otherStone);
        self::assertSame($gamblerPaper, $actual);
    }
}
