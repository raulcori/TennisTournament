<?php declare(strict_types=1);

namespace tennis_tournament\game\domain;
use tennis_tournament\player\domain\Player;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\util\domain\Date;

final class Game
{
    private Player $player1;
    private ?Player $player2;
    private ?Game $game1;
    private ?Game $game2;
    private ?Player $winner;
    private Date $matchDate;
    private int $roundNumber;
    private Tournament $tournament;


    private function __construct(
        Tournament $tournament, 
        int $roundNumber, 
        Date $matchDate, 
        Player $player1, 
        ?Player $player2, 
        ?Game $game1=null, 
        ?Game $game2=null
    ) {
        $this->tournament = $tournament;
        $this->roundNumber = $roundNumber;
        $this->matchDate = $matchDate;
        $this->player1 = $player1;
        $this->player2 = $player2;
        $this->game1 = $game1;
        $this->game2 = $game2;
    }

    public static function createFirstRoundGame(
        Tournament $tournament, 
        Date $matchDate, 
        Player $player1, 
        ?Player $player2
    ) { 
        return new self($tournament, 0, $matchDate, $player1, $player2);
    }

    public static function createGame (
        Tournament $tournament, 
        Game $game1, 
        ?Game $game2, 
        int $roundNumber, 
        Date $matchDate
    ) {
        $player1 = $game1->getWinner();
        $player2 = $game2 ? $game2->getWinner() : null;
        return new self($tournament, $roundNumber, $matchDate, $player1, $player2, $game1, $game2);
    }

    public function playMatch() : void
    {
        $this->tournament->calculateMatchWinner($this);
    }

    public function setWinner(Player $winner) : void
    {
        if ($this->player1 != $winner &&  $this->player2 != $winner) {
            throw new GameException("$winner must be one of the two ones players ($this->player1, $this->player2)");
        }
        $this->winner = $winner;
    }

    public function getWinner() : ?Player
    {
        return $this->winner;
    }

    public function getPlayer1() : ?Player
    {
        return $this->player1;
    }
    public function getPlayer2() : ?Player
    {
        return $this->player2;
    }
    
}
