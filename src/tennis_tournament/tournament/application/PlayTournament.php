<?php declare(strict_types=1);

namespace tennis_tournament\tournament\application;

use tennis_tournament\game\domain\Game;
use tennis_tournament\tournament\domain\TournamentBuilder;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\tournament\domain\TournamentRepositoryInterface;
use tennis_tournament\util\application\UseCaseResponse;
use tennis_tournament\util\domain\Date;
use tennis_tournament\game\domain\GameException;
use tennis_tournament\player\domain\PlayerException;
use tennis_tournament\tournament\domain\TournamentException;
use tennis_tournament\util\domain\InputFormatException;
use tennis_tournament\player\domain\Player;


final class PlayTournament
{


    private TournamentRepositoryInterface $tournamentRepository;
    private Tournament $tournament;


    public function __construct(TournamentRepositoryInterface $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }


    public function execute(string $genderStr, array $playersArray, int $luckFactorInt, string $startDateStr): UseCaseResponse
    {
        try {

            // Build the tournament, data validating
            $this->tournament = TournamentBuilder::build($genderStr, $playersArray, $luckFactorInt, $startDateStr);

            // Prepare first round (round zero)
            $players = $this->tournament->getPlayers();
            shuffle($players);
            $roundNumber = 0;
            $startDate = $this->tournament->getDate($roundNumber);
            $round = $this->makeFirstRound($players, $startDate);

            // Play matches until get a winner.
            $this->playMatches($round);
            while (!$this->isTheFinalMatch($round)) {

                // Prepare the next round.
                shuffle($round);
                $roundNumber++;
                $nextDate = $this->tournament->getDate($roundNumber);
                $round = $this->getNextRound($round, $roundNumber, $nextDate);
                $this->playMatches($round);
            }

            $game = $round[0];
            $winner = $game->getWinner();
            $this->tournament->setWinner($winner);

            // Save tournament.
            $this->tournamentRepository->save($this->tournament);

            return UseCaseResponse::success($this->format($winner));
            
        } catch (GameException $th) {
            return UseCaseResponse::error('Game error: ' . $th->getMessage());
        } catch (TournamentException $th) {
            return UseCaseResponse::error('Tournament error: ' . $th->getMessage());
        } catch (PlayerException $th) {
            return UseCaseResponse::error('Player error: ' . $th->getMessage());
        } catch (InputFormatException $th) {
            return UseCaseResponse::error('Input data error: ' . $th->getMessage());
        } catch (\PDOException $th) {
            return UseCaseResponse::error('Persistence error: ' . $th->getMessage() . '. Winner=' . $winner->name);
        } catch (\Throwable $th) {
            return UseCaseResponse::error('Unknow error: ' . $th->getMessage() . ' : ' . $th->getTraceAsString());
        }
    }
    private function makeFirstRound($players, Date $date)
    {
        $round = [];
        $max = count($players);
        for ($i = 0; $i < $max; $i = $i + 2) {
            $player1 = $players[$i];
            $player2 = array_key_exists($i + 1, $players) ? $players[$i + 1] : null;
            $round[] = Game::createFirstRoundGame($this->tournament, $date, $player1, $player2);
        }
        return $round;
    }

    private function playMatches(array $round)
    {
        foreach ($round as $game) {
            /** @var Game $game */
            $game->playMatch();
        }
    }
    private function getNextRound(array $round, int $roundNumber, Date $date)
    {
        $nextRound = [];
        $max = count($round);
        for ($i = 0; $i < $max; $i = $i + 2) {
            $game1 = $round[$i];
            $game2 = array_key_exists($i + 1, $round) ? $round[$i + 1] : null;
            $nextRound[] = Game::createGame($this->tournament, $game1, $game2, $roundNumber, $date);
        }
        return $nextRound;
    }

    private function isTheFinalMatch($round)
    {
        return count($round) <= 1;
    }

    private function format(Player $player)
    {
        $_player = (array) $player;
        $_player['level'] = $player->level->value();
        return $_player;
    }

}
