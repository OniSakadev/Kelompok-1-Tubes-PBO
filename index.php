<?php

use App\Controllers\CategoryController;
use App\Model\DB;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;
use App\Controllers\KlienController;
use App\Controllers\FreelanceController;
use App\Controllers\OrderController;
use App\Controllers\ReviewController;
use App\Controllers\ServiceController;
use App\Controllers\PaymentController;

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

$app->delete('/freelance/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new FreelanceController($db);
    return $controller->delete($request, $response, $args);
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

$app->post('/klien/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new KlienController($db);
    return $controller->delete($request, $response, $args);
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

$app->post('/category/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new CategoryController($db);
    return $controller->update($request, $response, $args);
});

$app->post('/category/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new CategoryController($db);
    return $controller->delete($request, $response, $args);
});

$app->post('/service/create', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new ServiceController($db);
    return $controller->create($request, $response);
});

$app->get('/service/getAllServices', function (Request $request, Response $response, $args) {
    $db = new DB();
    $service = new ServiceController($db);
    return $service->getAllServices($request, $response, $args);
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

$app->post('/payment/add', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new PaymentController($db);
    return $controller->addPayment($request, $response);
});

$app->get('/payment/find/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new PaymentController($db);
    return $controller->getAllPayment($request, $response, $args);
});

$app->post('/payment/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new PaymentController($db);
    return $controller->updatePayment($request, $response, $args);
});

$app->delete('/payment/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new PaymentController($db);
    return $controller->deletePayment($request, $response, $args);
});

$app->post('/order/add', function (Request $request, Response $response) {
    $db = new DB();
    $controller = new OrderController($db);
    return $controller->tambah($request, $response);
});

$app->get('/order/find/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new OrderController($db);
    return $controller->find($request, $response, $args);
});

$app->post('/order/update/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new OrderController($db);
    return $controller->update($request, $response, $args);
});
$app->post('/order/delete/{id}', function (Request $request, Response $response, $args) {
    $db = new DB();
    $controller = new OrderController($db);
    return $controller->delete($request, $response, $args);
});

$app->run();