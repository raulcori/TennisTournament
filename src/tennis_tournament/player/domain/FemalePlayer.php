<?php declare(strict_types=1);


namespace tennis_tournament\player\domain;
use tennis_tournament\player\domain\Player;

final class FemalePlayer extends Player 
{
    // TODO: check reactionTime is not negative
    /** Reaction time expressed in milliseconds */
    public int $reactionTime;
    
    public function __construct(string $name, int $level, int $reactionTime)
    {
        parent::__construct($name, $level);
        $this->reactionTime = $reactionTime;
    }
} 
