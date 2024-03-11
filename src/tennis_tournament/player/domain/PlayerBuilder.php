<?php declare(strict_types=1);

namespace tennis_tournament\player\domain;
use tennis_tournament\player\domain\Player;
use tennis_tournament\player\domain\FemalePlayer;
use tennis_tournament\player\domain\MalePlayer;
use tennis_tournament\player\domain\PlayerException;
use tennis_tournament\util\domain\GenderEnum;

final class PlayerBuilder
{
    private function __construct()
    {
        //
    }

    public static function build(GenderEnum $gender, array $attributes): Player
    {
        $className = $gender->name.'Player';
        $methodName = 'build'.$className;
        if (!method_exists(self::class, $methodName)) {
            throw new PlayerException("Exception ocured in player building: Method $methodName doesn't exist");
        }
        return self::$methodName($attributes);
    }

    private static function buildFemalePlayer(array $attributes): FemalePlayer
    {
        $name = (string) $attributes['name'];
        $level = (int) $attributes['level'];
        $reactionTime = (int) $attributes['reactionTime'];
        return new FemalePlayer($name, $level, $reactionTime);
    }

    private static function buildMalePlayer(array $attributes): MalePlayer
    {
        $name = (string) $attributes['name'];
        $level = (int) $attributes['level'];
        $force = (int) $attributes['force'];
        $displacementSpeed = (int) $attributes['displacementSpeed'];
        return new MalePlayer($name, $level, $force, $displacementSpeed);
    }
}
