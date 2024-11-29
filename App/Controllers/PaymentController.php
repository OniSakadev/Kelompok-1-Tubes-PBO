<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Payment;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class PaymentController extends DB
{
    public function addPayment(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $payment = new Payment($this->db);

        try {
            $payment->id_order = $data['id_order'];
            $payment->payment_method = $data['payment_method'];
            $payment->payment_status = $data['payment_status'];
            $payment->payment_date = $data['payment_date'];
            $payment->total_price = $data['total_price'];
            $result = $payment->addPayment();
            $response->getBody()->write(json_encode(["success" => true, "data" => $result]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function getAllPayment(Request $request, Response $response, $args): Response
    {
        try {
            $id_payment = $args['id'];
            $payment = new Payment($this->db);
            $payment->getAllPayment($id_payment);

            if (isset($categoryData['id_category'])) {
                $response->getBody()->write(json_encode($payment));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                $response->getBody()->write(json_encode($payment));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function updatePayment(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $payment = new Payment($this->db);
        try {
            $payment->id_payment = $args['id_payment'];
            $payment->id_order = $data['id_order'];
            $payment->payment_method = $data['payment_method'];
            $payment->payment_status = $data['payment_status'];
            $payment->payment_date = $data['payment_date'];
            $payment->total_price = $data['total_price'];
            $result = $payment->updatePayment();

            if ($result['success']) {
                $response->getBody()->write(json_encode($result));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                $response->getBody()->write(json_encode($result));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
            }
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function deletePayment(Request $request, Response $response, $args): Response
    {
        $payment = new Payment($this->db);

        try {
            $id_payment = $args['id'];
            $result = $payment->deletePayment($id_payment);

            if ($result) {
                $response->getBody()->write(json_encode(["message" => "Payment deleted successfully"]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(204);
            } else {
                $response->getBody()->write(json_encode(["message" => "Payment not found"]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
