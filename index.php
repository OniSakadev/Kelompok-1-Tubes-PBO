<?php

use App\Controllers\CategoryController;
use App\Model\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\KlienController;
use App\Controllers\FreelanceController;
use App\Controllers\ReviewController;
use App\Controllers\ServiceController;

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

$app->post('/review/add', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new ReviewController($db);
    return $controller->tambah($request, $response);
});

$app->get('/review/find/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ReviewController($db);
    return $controller->find($request, $response, $args);
});

$app->post('/review/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ReviewController($db);
    return $controller->update($request, $response, $args);
});

$app->post('/review/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ReviewController($db);
    return $controller->delete($request, $response, $args);
});

$app->get('/category/getAllCategories', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new CategoryController($db);
    return $controller->getAllCategories($request, $response, $args);
});

$app->get('/category/getCategoryById/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new CategoryController($db);
    return $controller->getCategoryById($request, $response, $args);
});

$app->post('/category/tambah', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new CategoryController($db);
    return $controller->tambah($request, $response);
});

$app->post('/service/create/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ServiceController($db);
    return $controller->create($request, $response, $args);
});

$app->get('/service/find/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ServiceController($db);
    return $controller->find($request, $response, $args);
});

$app->post('/service/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ServiceController($db);
    return $controller->update($request, $response, $args);
});

$app->delete('/service/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new ServiceController($db);
    return $controller->delete($request, $response, $args);
});

$app->run();
