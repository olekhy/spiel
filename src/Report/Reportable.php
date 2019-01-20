<?php

declare(strict_types=1);

namespace Olekhy\Spiel\Report;

use Olekhy\Spiel\Gambler;

interface Reportable
{
    public function reset() : void;

    public function record(?Gambler $gambler) : void;

    public function print() : void;

    public function toString() : string;
}
