<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

use MabeEnum\Enum;

/**
 * @method static SymbolEnum STONE()
 * @method static SymbolEnum SCISSOR()
 * @method static SymbolEnum PAPER()
 */
final class SymbolEnum extends Enum
{
    public const STONE   = 'stone';
    public const SCISSOR = 'scissor';
    public const PAPER   = 'paper';
}
