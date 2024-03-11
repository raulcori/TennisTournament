<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// set headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// Check if the url parameter is set
if (!isset($_GET['url'])) {
    http_response_code(404);
    header("HTTP/1.1 404 Not Found");
    exit();
}

$url = explode('/', $_GET['url']);

// Check url base
if (!isset($url[0])) {
    http_response_code(404);
    header("HTTP/1.1 404 Not Found");
    exit();
}

if ($url[0] != 'tournament') {
    http_response_code(404);
    header("HTTP/1.1 404 Not Found");
    exit();
}

// Check uri
if (!isset($url[1])) {
    http_response_code(404);
    header("HTTP/1.1 404 Not Found");
    exit();
}


$loader = require __DIR__ . '/vendor/autoload.php';
Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/')->load();
use tennis_tournament\tournament\infrastructure\PlayTournamentWebController;
use tennis_tournament\tournament\infrastructure\SearchTournamentsWebController;
use tennis_tournament\util\infrastructure\HttpResponse;

$uri = $url[1];
$httpMethod = $_SERVER["REQUEST_METHOD"];
$request = json_decode(file_get_contents('php://input'), true) ?? [];
$request = array_merge($request, $_GET);
$response = new HttpResponse();


// Routes
if ($httpMethod == 'POST' && $uri == 'simulate') {
    (new PlayTournamentWebController())->execute($request, $response);
} else if ($httpMethod == 'GET' && $uri == 'search') {
    (new SearchTournamentsWebController())->execute($request, $response);
} else {
    $response->statusCode = 405;
    $response->header = 'HTTP/1.1 405 Method not allowed';
}

$response->send();
exit();


