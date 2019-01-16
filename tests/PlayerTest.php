<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Tests;

use PHPUnit\Framework\TestCase;

final class PlayerTest extends TestCase
{
    public function testItAPlayerThrownASymbolByStrategy() : void
    {
        $symbol         = SymbolEnum::STONE();
        $playerStrategy = $this->createMock(PlayerStrategy::class);
        $playerStrategy->expects(self::once())->method('throw')->willReturn($symbol);
        $player = new Player($playerStrategy, 'Bob');
        $actual = $player->pull();
        self::assertSame($symbol, $actual);
    }

    public function testItAGame() : void
    {
        $symbol         = SymbolEnum::STONE();
        $playerStrategy = $this->createMock(PlayerStrategy::class);
        $playerStrategy->expects(self::exactly(2))->method('throw')->willReturn($symbol);
        $reporter = $this->createMock(Reporter::class);
        $bob      = new Player($playerStrategy, 'Bob');
        $alice    = new Player($playerStrategy, 'Alice');
        $game     = new Game($bob, $alice, $reporter);
        $game->play(1);
        $actual = $reporter->result();
        self::assertSame('Bob wins: 0, Alice wins :0, Draw: 1', $actual);
    }

    public function testItAPlayerWins() : void
    {
        $symbolStone         = SymbolEnum::STONE();
        $symbolScissor       = SymbolEnum::SCISSOR();
        $playerStrategyStone = $this->createMock(PlayerStrategy::class);
        $playerStrategyStone->expects(self::exactly(2))->method('throw')->willReturn($symbolStone);

        $playerStrategyScissor = $this->createMock(PlayerStrategy::class);
        $playerStrategyScissor->expects(self::exactly(2))->method('throw')->willReturn($symbolScissor);

        $rules = new GameRules();
        $rules->add(SymbolEnum::STONE(), SymbolEnum::STONE() | SymbolEnum::SCISSOR());

        $reporter = $this->createMock(Reporter::class);
        $bob      = new Player($playerStrategyStone, 'Bob');
        $alice    = new Player($playerStrategyScissor, 'Alice');
        $game     = new Game($bob, $alice, $rules, $reporter);
        $game->play(1);
        $actual = $reporter->result();
        self::assertSame('Bob wins: 1, Alice wins: 0, Draw: 0', $actual);
    }

    public function testGameRules() : void
    {
        $gameRules = new GameRules();
        $gameRules->add(SymbolEnum::STONE(), SymbolEnum::STONE(), SymbolEnum::SCISSOR());
        $gameRules->add(SymbolEnum::SCISSOR(), SymbolEnum::PAPER(), SymbolEnum::SCISSOR());
        $gameRules->add(SymbolEnum::PAPER(), SymbolEnum::STONE(), SymbolEnum::PAPER());

        $stoneActual = $gameRules->verfify(SymbolEnum::STONE(), SymbolEnum::SCISSOR());
        self::assertSame($stoneActual, SymbolEnum::STONE());

        $scissorActual = $gameRules->verfify(SymbolEnum::PAPER(), SymbolEnum::SCISSOR());
        self::assertSame($scissorActual, SymbolEnum::SCISSOR());

        $paperActual = $gameRules->verfify(SymbolEnum::STONE(), SymbolEnum::PAPER());
        self::assertSame($paperActual, SymbolEnum::PAPER());
    }

    public function testItThrownAnExceptionWhenAddedInvalidRule() : void
    {
        $this->expectException(\InvalidArgumentException::class);
        $gameRules = new GameRules();
        $gameRules->add(SymbolEnum::STONE(), SymbolEnum::STONE(), SymbolEnum::STONE());
    }
}
