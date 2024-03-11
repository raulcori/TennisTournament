<?php declare(strict_types=1);

namespace tennis_tournament\util\infrastructure;

use tennis_tournament\tournament\application\FakeTournamentRepository;
use tennis_tournament\tournament\application\MySQLTournamentRepository;
use tennis_tournament\tournament\domain\TournamentRepositoryInterface;

final class PersistenceFactory
{

    public static function create(): TournamentRepositoryInterface
    {
        $repository = getenv('REPOSITORY') ?? 'MYSQL';

        switch ($repository) {
            case 'MYSQL':
                return new MySQLTournamentRepository();
            case 'FAKE': 
                return new FakeTournamentRepository();

            // case 'X': 
            //    return new XTournamentRepository();

            default:
                throw new \Exception('Invalid repository type');
        }

    }
}