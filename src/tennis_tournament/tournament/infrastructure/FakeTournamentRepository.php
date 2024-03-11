<?php declare(strict_types=1);

namespace tennis_tournament\tournament\application;

use tennis_tournament\tournament\domain\TournamentRepositoryInterface;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\util\domain\GenderEnum;
use tennis_tournament\util\domain\Date;

/**
 * A fake persistence only for testing.
 */
final class FakeTournamentRepository implements TournamentRepositoryInterface
{

    public function findByAll(Date $startDate, GenderEnum $gender): array
    {
        return []; 
    }

    public function save(Tournament $tournament): bool
    {
        return true;
    }   

}
