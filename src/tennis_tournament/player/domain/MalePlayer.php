<?php declare(strict_types=1);

namespace tennis_tournament\player\domain;
use tennis_tournament\player\domain\Player;


final class MalePlayer extends Player 
{
    public int $force;
    public int $displacementSpeed;

    public function __construct(string $name, int $level, int $force, int $displacementSpeed)
    {
        parent::__construct($name, $level);
        $this->force = $force;
        $this->displacementSpeed = $displacementSpeed;
    }
} 
