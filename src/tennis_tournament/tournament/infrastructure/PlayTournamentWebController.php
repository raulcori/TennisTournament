<?php declare(strict_types=1);

namespace tennis_tournament\tournament\infrastructure;

use tennis_tournament\tournament\application\PlayTournament;
use tennis_tournament\util\infrastructure\HttpResponse;
use tennis_tournament\util\infrastructure\WebControllerInterface;
use tennis_tournament\util\infrastructure\PersistenceFactory;

final class PlayTournamentWebController implements WebControllerInterface
{
    private readonly PlayTournament $playTournament;

    public function __construct()
    {
        $this->playTournament = new PlayTournament(PersistenceFactory::create());
    }

    public function execute(array $request, HttpResponse &$response): void
    {
        $genderStr     = $request['gender']     ?? '';
        $playersArray  = $request['players']    ?? [];
        $luckFactorInt = $request['luckFactor'] ??  0;
        $startDateStr  = $request['startDate']  ?? '';

        $userCase = $this->playTournament->execute(
            (string) $genderStr,
            (array) $playersArray,
            (int) $luckFactorInt,
            (string) $startDateStr
        );

        if ($userCase->success) {
            $response->body = $userCase->data;
        } else {
            $response->statusCode = 400;// TODO: set the correct status code generated in the corresponding use case
            $response->body['errorMessage'] = $userCase->message;
        }
    }

}
