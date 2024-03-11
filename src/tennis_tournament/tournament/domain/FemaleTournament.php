<?php declare(strict_types=1);

namespace tennis_tournament\tournament\domain;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\util\domain\GenderEnum;
use tennis_tournament\util\domain\PercentageInteger;
use tennis_tournament\player\domain\Player;
use tennis_tournament\player\domain\FemalePlayer;
use tennis_tournament\util\domain\Date;

final class FemaleTournament extends Tournament
{

    public function __construct(array $players, PercentageInteger $luckFactor, Date $startDate)
    {
        parent::__construct($players, GenderEnum::Female, $luckFactor, $startDate);
    }

    protected function playerMatchPerformance(?Player $player, PercentageInteger $luckFactor) : float
    {
        /** @var FemalePlayer $player */
        $performance = 0.00;
        if ($player) {
            $performance = $player->reactionTime != 0 ? $player->level->value() / $player->reactionTime : $player->level->value() * 1000;
        }
        $random = mt_rand(0, mt_getrandmax() - 1) / mt_getrandmax();
        return $performance * (1 + $luckFactor->value() * ($random - 0.5) / 100);
    }
}


