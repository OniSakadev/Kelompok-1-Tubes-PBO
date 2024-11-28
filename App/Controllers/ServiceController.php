<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Service;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class ServiceController extends DB
{

    public function create(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $service = new Service($this->db);

        try {
            $service->id_freelancer = $data['id_freelancer'];
            $service->id_category = $data['id_category'];
            $service->sub_category = $data['sub_category'];
            $service->title = $data['title'];
            $service->description = $data['description'];
            $service->industry = $data['industry'];
            $service->skills = $data['skills'];
            $service->deadline = $data['deadline'];
            $service->price = $data['price'];
            $result = $service->create();
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
            $id_service = $args['id'];
            $service = new Service($this->db);
            $service->find($id_service);
            $response->getBody()->write(json_encode($service));
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
        $id_service = $args['id'];
        $service = new Service($this->db);
        try {
            $service->id_service = $id_service;
            $service->sub_category = $data['sub_category'];
            $service->title = $data['title'];
            $service->description = $data['description'];
            $service->industry = $data['industry'];
            $service->skills = $data['skills'];
            $service->deadline = $data['deadline'];
            $service->price = $data['price'];
            $result = $service->update();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function delete(Request $request, Response $response, $args): Response
    {
        try {
            $id_service = $args['id'];
            $service = new Service($this->db);
            $service->delete($id_service);
            $response->getBody()->write(json_encode(["message" => "Service Dihapus"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
