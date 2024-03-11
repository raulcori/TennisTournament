<?php declare(strict_types=1);

namespace tennis_tournament\tournament\application;

use PDO;
use tennis_tournament\tournament\domain\TournamentRepositoryInterface;
use tennis_tournament\tournament\domain\Tournament;
use tennis_tournament\util\domain\GenderEnum;
use tennis_tournament\util\domain\Date;

/**
 * A very very simple MySQL implementation.
 */
final class MySQLTournamentRepository implements TournamentRepositoryInterface
{

    /**
     * Throws PDOException
     */
    public function findByAll(Date $startDate, GenderEnum $gender): array
    {
        $host     = getenv('DB_MYSQL_HOST')     ?? 'localhost';
        $port     = getenv('DB_MYSQL_PORT')     ?? '3306';
        $user     = getenv('DB_MYSQL_USERNAME') ?? 'root';
        $password = getenv('DB_MYSQL_PASSWORD') ?? '123456798';
        $db       = getenv('DB_MYSQL_DATABASE') ?? 'tennis_tournament';

        $result = [];
        
        $dsn = "mysql:host=$host:$port;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $startDate = $startDate->value();
        $gender = $gender->value;
        $query = "SELECT * FROM tournaments where startDate = :startDate and gender = :gender";
        $statement = $pdo->prepare($query);
        $statement->bindParam(':startDate', $startDate);
        $statement->bindParam(':gender', $gender);
        $statement->execute();

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        $pdo = null;

        return $result; // TODO: convert $restult into Tournament domain object list
    }

    /**
     * Throws PDOException
     */
    public function save(Tournament $tournament): bool
    {
        $host     = getenv('DB_MYSQL_HOST')     ?? 'localhost';
        $port     = getenv('DB_MYSQL_PORT')     ?? '3306';
        $user     = getenv('DB_MYSQL_USERNAME') ?? 'root';
        $password = getenv('DB_MYSQL_PASSWORD') ?? '123456798';
        $db       = getenv('DB_MYSQL_DATABASE') ?? 'tennis_tournament';

        $dsn = "mysql:host=$host:$port;dbname=$db;charset=utf8mb4";
        $pdo = new PDO($dsn, $user, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        $gender = $tournament->getGender()->value;
        $winner = $tournament->getWinner()->name;
        $startDate = $tournament->getStartDate()->value();

        $query = "INSERT INTO tournaments (startDate, gender, winner) VALUES (:startDate, :gender, :winner)";
        $statement = $pdo->prepare($query);

        $statement->bindParam(':startDate', $startDate);
        $statement->bindParam(':gender', $gender);
        $statement->bindParam(':winner', $winner);

        $statement->execute();
        return true;
    }   

}
