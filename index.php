<?php

use App\Model\DB;
use App\Model\Klien;
use App\Model\Freelance;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\KlienController;
use App\Controllers\FreelanceController;

require_once __DIR__ . '/vendor/autoload.php';

$app = AppFactory::create();
$app->addBodyParsingMiddleware();
$app->addRoutingMiddleware();
$app->add(new BasePathMiddleware($app));
$app->addErrorMiddleware(true, true, true);


$app->get('/', function (Request $request, Response $response) {
    $response->getBody()->write("Silahkan Login");
    return $response;
});

$app->post('/freelance/add', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new FreelanceController($db);
    return $controller->register($request, $response);
});

$app->get('/freelance/find/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new FreelanceController($db);
    return $controller->find($request, $response, $args);
});

$app->post('/freelance/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new FreelanceController($db);
    return $controller->update($request, $response, $args);
});


$app->post('/klien/add', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new KlienController($db);
    return $controller->register($request, $response);
});

$app->get('/klien/find/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new KlienController($db);
    return $controller->find($request, $response, $args);
});

$app->post('/klien/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new KlienController($db);
    return $controller->update($request, $response, $args);
});


$app->run();
