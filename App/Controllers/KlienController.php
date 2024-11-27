<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Klien;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class KlienController extends DB
{

    public function register(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $klien = new Klien($this->db);

        try {
            $klien->email = $data['email'];
            $klien->password = $data['password'];
            $klien->name = $data['full_name'];
            $klien->username = $data['username'];
            $klien->phone = $data['phone_number'];
            $result = $klien->register();
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
            $id_klien = $args['id'];
            $klien = new Klien($this->db);
            $klien->find($id_klien);
            $response->getBody()->write(json_encode($klien));
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
        $id_klien = $args['id'];
        $klien = new Klien($this->db);
        try {
            $klien->id = $id_klien;
            $klien->email = $data['email'];
            $klien->name = $data['full_name'];
            $klien->username = $data['username'];
            $klien->phone = $data['phone_number'];
            $result = $klien->update();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
