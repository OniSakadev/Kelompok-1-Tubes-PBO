<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Order;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Exception;
use PDO; 
use PDOException; // Pastikan ini ditambahkan jika belum ada

class OrderController extends DB
{
    public function tambah(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $order = new Order($this->db);

        try {
            $order->id_freelancer = $data['id_freelancer'];
            $order->id_client = $data['id_client'];
            $order->id_service = $data['id_service'];
            $order->order_detail = $data['order_detail'];
            $order->supported_file = $data['supported_file'];
            $order->order_date = $data['order_date'];
            $result = $order->tambah();
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
            $id_order = $args['id'];
            $order = new Order($this->db);
            $order->find($id_order);
            $response->getBody()->write(json_encode($order));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
    
    public function addRequirement(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_order = $args['id'];
        $order = new Order($this->db);

        try {
            // Validasi input
            if (!isset($data['requirement'])) {
                throw new Exception('Requirement is required');
            }

            $order->id_order = $id_order;
            $result = $order->addRequirement($data['requirement']);

            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PDOException $e) {
            $error = ["message" => "Database error: " . $e->getMessage()];
        } catch (Exception $e) {
            $error = ["message" => $e->getMessage()];
        }

        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }

    public function submitDelivery(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_order = $args['id'];
        $order = new Order($this->db);

        try {
            // Validasi input
            if (!isset($data['delivered_file'])) {
                throw new Exception('Delivered file is required');
            }

            $order->id_order = $id_order;
            $result = $order->submitDelivery($data['delivered_file']);

            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PDOException $e) {
            $error = ["message" => "Database error: " . $e->getMessage()];
        } catch (Exception $e) {
            $error = ["message" => $e->getMessage()];
        }

        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }

    public function acceptDelivery(Request $request, Response $response, $args): Response
    {
        $id_order = $args['id'];
        $order = new Order($this->db);

        try {
            $order->id_order = $id_order;
            $result = $order->acceptDelivery();

            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PDOException $e) {
            $error = ["message" => "Database error: " . $e->getMessage()];
        } catch (Exception $e) {
            $error = ["message" => $e->getMessage()];
        }

        $response->getBody()->write(json_encode($error));
        return $response->withHeader('content-type', 'application/json')->withStatus(500);
    }
}
