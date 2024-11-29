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

    public function update(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_order = $args['id'];
        $order = new Order($this->db);
        try {
            $order->id_order = $id_order;
            $order->order_detail = $data['order_detail'];
            $result = $order->update();
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
            $id_order = $args['id'];
            $order = new Order($this->db);
            $order->delete($id_order);
            $response->getBody()->write(json_encode(["message" => "order Dihapus"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
