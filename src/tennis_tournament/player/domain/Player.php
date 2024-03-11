<?php declare(strict_types=1);

namespace tennis_tournament\player\domain;
use tennis_tournament\util\domain\PercentageInteger;

abstract class Player
{
    public string $name;
    public PercentageInteger $level;

    public function __construct(string $name, int $level)
    {
        $this->name = $name;
        $this->level = new PercentageInteger($level);
    }

    public function __toString(): string
    {
        return $this->name;
    }

} 