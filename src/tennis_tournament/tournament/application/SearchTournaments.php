<?php declare(strict_types=1);

namespace tennis_tournament\tournament\application;

use tennis_tournament\tournament\domain\TournamentRepositoryInterface;
use tennis_tournament\util\domain\Date;
use tennis_tournament\util\domain\GenderEnum;
use tennis_tournament\util\application\UseCaseResponse;
use tennis_tournament\game\domain\GameException;
use tennis_tournament\player\domain\PlayerException;
use tennis_tournament\tournament\domain\TournamentException;
use tennis_tournament\util\domain\InputFormatException;

final class SearchTournaments
{
    private TournamentRepositoryInterface $tournamentRepository;

    public function __construct(TournamentRepositoryInterface $tournamentRepository)
    {
        $this->tournamentRepository = $tournamentRepository;
    }

    public function execute(string $startDate, string $gender): UseCaseResponse
    {
        try {
            $all = $this->tournamentRepository->findByAll(new Date($startDate), GenderEnum::fromValue($gender));
            return UseCaseResponse::success($all);
        } catch (GameException $th) {
            return UseCaseResponse::error('Game error: ' . $th->getMessage());
        } catch (TournamentException $th) {
            return UseCaseResponse::error('Tournament error: ' . $th->getMessage());
        } catch (PlayerException $th) {
            return UseCaseResponse::error('Player error: ' . $th->getMessage());
        } catch (InputFormatException $th) {
            return UseCaseResponse::error('Input data error: ' . $th->getMessage());
        } catch (\PDOException $th) {
            return UseCaseResponse::error('Persistence error: ' . $th->getMessage());
        } catch (\Throwable $th) {
            return UseCaseResponse::error('Unknow error: ' . $th->getMessage() . ' : ' . $th->getTraceAsString());
        }
    }
}
