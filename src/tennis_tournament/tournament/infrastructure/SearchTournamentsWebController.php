<?php declare(strict_types=1);

namespace tennis_tournament\tournament\infrastructure;

use tennis_tournament\tournament\application\SearchTournaments;
use tennis_tournament\util\infrastructure\HttpResponse;
use tennis_tournament\util\infrastructure\WebControllerInterface;
use tennis_tournament\util\infrastructure\PersistenceFactory;

final class SearchTournamentsWebController implements WebControllerInterface
{
    private readonly SearchTournaments $searchTournaments;

    public function __construct()
    {
        $this->searchTournaments = new SearchTournaments(PersistenceFactory::create());
    }

    public function execute(array $request, HttpResponse &$response): void
    {
        $startDateStr = $request['startDate'] ?? '';
        $genderStr = $request['gender'] ?? '';

        $userCase = $this->searchTournaments->execute((string) $startDateStr,(string) $genderStr);

        if ($userCase->success) {
            $response->body = $userCase->data;
        } else {
            $response->statusCode = 400;// TODO: set the correct status code generated in the corresponding use case
            $response->body['errorMessage'] = $userCase->message;
        }
    }

}
