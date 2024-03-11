<?php declare(strict_types=1);

namespace tennis_tournament\tournament\domain;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\util\domain\Date;
use tennis_tournament\util\domain\GenderEnum;

interface TournamentRepositoryInterface
{
    public function findByAll(Date $startDate, GenderEnum $gender): array;

    public function save(Tournament $tournament): bool;
}
