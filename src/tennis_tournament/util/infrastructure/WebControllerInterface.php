<?php declare(strict_types=1);

namespace tennis_tournament\util\infrastructure;
use tennis_tournament\util\infrastructure\HttpResponse;

interface WebControllerInterface
{
    public function execute(array $request, HttpResponse &$response) : void;
    
}
