<?php declare(strict_types=1);


use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use tennis_tournament\tournament\application\FakeTournamentRepository;
use tennis_tournament\tournament\application\PlayTournament;

final class TournamentTest extends TestCase
{

    // TODO: Add unit tests to check luckFactor:
    //       By putting a very strong player against weaker players, you would expect the strong player to win most of the time.
    //       If the luck factor is increased then the weaker players may have a better chance of winning.

    #[Test]
    #[DataProvider("dataProvider")]
    #[TestDox('Tournament playing')]
    public function tournamentPlaying($genderStr, $playersArray, $luckFactorInt, $startDateStr, bool $spectedStatus): void
    {
        $playTournament = new PlayTournament(new FakeTournamentRepository());
        $useCaseResponse = $playTournament->execute($genderStr, $playersArray, $luckFactorInt, $startDateStr);
        $status = $useCaseResponse->success;
        // TODO: Differentiate the causes of it failures
        $this->assertSame($spectedStatus, $status);
    }

    public static function dataProvider()
    {
        return [
            // Varying the number of players
            "Normal set 01" => ['M', self::getNormalPlayersArray( 0), 50, '2020-01-01', false],
            "Normal set 02" => ['F', self::getNormalPlayersArray( 1), 50, '2020-01-01', true],
            "Normal set 03" => ['M', self::getNormalPlayersArray( 2), 50, '2020-01-01', true],
            "Normal set 04" => ['F', self::getNormalPlayersArray( 3), 50, '2020-01-01', true],
            "Normal set 05" => ['M', self::getNormalPlayersArray( 4), 50, '2020-01-01', true],
            "Normal set 06" => ['F', self::getNormalPlayersArray( 7), 50, '2020-01-01', true],
            "Normal set 07" => ['M', self::getNormalPlayersArray( 8), 50, '2020-01-01', true],
            "Normal set 08" => ['F', self::getNormalPlayersArray( 9), 50, '2020-01-01', true],
            "Normal set 09" => ['M', self::getNormalPlayersArray(23), 50, '2020-01-01', true],
            // Bad gender
            "Bad gender set 01" => ['m', self::getNormalPlayersArray(4), 50, '2020-01-01', false],
            "Bad gender set 02" => ['', self::getNormalPlayersArray(4), 50, '2020-01-01', false],
            "Bad gender set 03" => ['X', self::getNormalPlayersArray(4), 50, '2020-01-01', false],
            "Bad gender set 04" => ['FM', self::getNormalPlayersArray(4), 50, '2020-01-01', false],
        ];
    }

    public static function getNormalPlayersArray(int $quantity): array
    {
        $players = [];
        for ($i=0; $i < $quantity; $i++) { 
            $players[] = ["name" => "Jugador $i", "level" => 10, "force" => 20, "displacementSpeed" => 20, "reactionTime" => 10];    
        }
        return $players;
        
    }

}
