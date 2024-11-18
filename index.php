<?php

use App\Model\Akun\Freelance;
use App\Model\Akun\Klien;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use Selective\BasePath\BasePathMiddleware;


require __DIR__ . '/vendor/autoload.php';

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
    $req_freelancer = $request->getParsedBody();
    $freelancer = new Freelance();
    $freelancer->email = $req_freelancer['email'];
    $freelancer->password = $req_freelancer['password'];
    $freelancer->name = $req_freelancer['full_name'];
    $freelancer->username = $req_freelancer['user_name'];
    $freelancer->phone = $req_freelancer['phone_number'];
    $freelancer->birth = $req_freelancer['birth_date'];
    $freelancer->place = $req_freelancer['place_of_birth'];
    $freelancer->gender = $req_freelancer['gender'];
    $freelancer->job = $req_freelancer['job_position'];
    $freelancer->skill = $req_freelancer['skills'];
    $freelancer->about = $req_freelancer['about_you'];
    $response->getBody()->write(json_encode($freelancer->save()));
    return $response;
});

$app->post('/klien/add', function (Request $request, Response $response) {
    $req_freelancer = $request->getParsedBody();
    $freelancer = new Klien();
    $freelancer->email = $req_freelancer['email'];
    $freelancer->password = $req_freelancer['password'];
    $freelancer->name = $req_freelancer['full_name'];
    $freelancer->username = $req_freelancer['username'];
    $freelancer->phone = $req_freelancer['phone_number'];
    $response->getBody()->write(json_encode($freelancer->save()));
    return $response;
});


$app->run();
