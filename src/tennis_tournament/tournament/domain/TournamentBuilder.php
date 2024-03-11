<?php declare(strict_types=1);

namespace tennis_tournament\tournament\domain;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\tournament\domain\FemaleTournament;
use tennis_tournament\tournament\domain\MaleTournament;
use tennis_tournament\tournament\domain\TournamentException;
use tennis_tournament\util\domain\GenderEnum;
use tennis_tournament\util\domain\InputFormatException;
use tennis_tournament\util\domain\PercentageInteger;
use tennis_tournament\util\domain\Date;
use tennis_tournament\player\domain\PlayerBuilder;

final class TournamentBuilder
{
    private function __construct()
    {
        //
    }

    public static function build(string $genderStr, array $playersArray, int $luckFactorInt, string $startDateStr) : Tournament
    {   
        $gender = GenderEnum::fromValue($genderStr);
        $startDate = new Date($startDateStr);
        $luckFactor = new PercentageInteger($luckFactorInt);
        $players = [];
        if (empty($playersArray)) {
            throw new InputFormatException("Player list is empty");
        }
        foreach ($playersArray as $player) {
            $players[] = PlayerBuilder::build($gender, $player);
        }
        $className = $gender->name.'Tournament';
        $methodName = 'build'.$className;
        if (!method_exists(self::class, $methodName)) {
            throw new TournamentException("Exception ocured in tournament building: Method $methodName doesn't exist");
        }
        return self::$methodName($players, $luckFactor, $startDate);
    }

    private static function buildFemaleTournament(array $players, PercentageInteger $luckFactor, Date $startDate) : FemaleTournament
    {
        return new FemaleTournament($players, $luckFactor, $startDate);
    }

    private static function buildMaleTournament(array $players, PercentageInteger $luckFactor, Date $startDate) : MaleTournament
    {
        return new MaleTournament($players, $luckFactor, $startDate);
    }

}
