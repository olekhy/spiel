<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Strategy;

use Olekhy\Spiel\Symbol;

interface TossGameStrategy
{
    public function toss() : Symbol;
}
