<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Freelance;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class FreelanceController extends DB
{

    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $freelance = new Freelance($this->db);

        try {
            $freelance->email = $data['email'];
            $freelance->password = $data['password'];
            $freelance->name = $data['full_name'];
            $freelance->username = $data['user_name'];
            $freelance->phone = $data['phone_number'];
            $freelance->birth = $data['birth_date'];
            $freelance->place = $data['place_of_birth'];
            $freelance->gender = $data['gender'];
            $freelance->job = $data['job_position'];
            $freelance->skill = $data['skills'];
            $freelance->about = $data['about_you'];
            $result = $freelance->register();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function find(Request $request, Response $response, $args): Response
    {
        try {
            $id_freelancer = $args['id'];
            $freelance = new Freelance($this->db);
            $freelance->find($id_freelancer);
            $response->getBody()->write(json_encode($freelance));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function update(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_freelancer = $args['id'];
        $freelance = new Freelance($this->db);
        try {
            $freelance->id = $id_freelancer;
            $freelance->email = $data['email'];
            $freelance->name = $data['full_name'];
            $freelance->username = $data['user_name'];
            $freelance->phone = $data['phone_number'];
            $freelance->birth = $data['birth_date'];
            $freelance->place = $data['place_of_birth'];
            $freelance->gender = $data['gender'];
            $freelance->job = $data['job_position'];
            $freelance->skill = $data['skills'];
            $freelance->about = $data['about_you'];
            $result = $freelance->update();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
