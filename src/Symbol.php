<?php

declare(strict_types=1);

namespace Olekhy\Spiel;

use MabeEnum\Enum;

/**
 * @method static Symbol ROCK()
 * @method static Symbol SCISSOR()
 * @method static Symbol PAPER()
 */
final class Symbol extends Enum
{
    public const ROCK    = 'rock';
    public const SCISSOR = 'scissor';
    public const PAPER   = 'paper';
}
