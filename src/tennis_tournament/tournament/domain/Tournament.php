<?php declare(strict_types=1);

namespace tennis_tournament\tournament\domain;
use tennis_tournament\game\domain\Game;
use tennis_tournament\player\domain\Player;
use tennis_tournament\util\domain\GenderEnum;
use tennis_tournament\util\domain\PercentageInteger;
use tennis_tournament\util\domain\Date;


abstract class Tournament
{
    private array $players;
    private GenderEnum $gender;
    private PercentageInteger $luckFactor;
    private Date $startDate;
    private ?Player $winner;


    public function __construct(array $players, GenderEnum $gender, PercentageInteger $luckFactor, Date $startDate) 
    {
        $this->players = $players;
        $this->gender = $gender;
        $this->luckFactor = $luckFactor;
        $this->startDate = $startDate;
    }

    public function calculateMatchWinner(Game $game): Player
    {
        $player1 = $game->getPlayer1();
        $player2 = $game->getPlayer2();
        $performance1 = $this->playerMatchPerformance($player1, $this->luckFactor);
        $performance2 = $this->playerMatchPerformance($player2, $this->luckFactor);
        $winner = $performance1 > $performance2 ? $player1 : $player2;
        $game->setWinner($winner);
        return $winner;
    }

    /**
     * Rounds are played every 7 days.
     */
    public function getDate(int $roundNumber) : Date
    {
        $date = new Date($this->startDate->value());
        $days = 7 * $roundNumber;
        $date->addDays($days);
        return $date;
    }

    public function getPlayers() : array
    {
        return $this->players;
    }

    public function setWinner(Player $winner) : void
    {
        $this->winner = $winner;
    }

    public function getWinner() : Player
    {
        return $this->winner;
    }

    public function getStartDate() : Date
    {
        return $this->startDate;
    }

    public function getGender() : GenderEnum
    {
        return $this->gender;
    }

    protected abstract function playerMatchPerformance(Player $player, PercentageInteger $luckFactor) : float;

}
