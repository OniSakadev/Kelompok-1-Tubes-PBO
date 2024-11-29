<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Payment;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class PaymentController extends DB
{
    private $payment;

    public function __construct()
    {
        $this->payment = new Payment();
    }

    public function addPayment(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        try {
            $result = $this->payment->addPayment(
                $data["id_order"],
                $data["payment_method"],
                $data["payment_status"],
                $data["payment_date"],
                $data["total_price"]
            );

            $response->getBody()->write(json_encode(["success" => true, "data" => $result]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function getAllPayment(Request $request, Response $response): Response
    {
        try {
            $payments = $this->payment->getAllPayment();
            $response->getBody()->write(json_encode($payments));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function updatePayment(Request $request, Response $response, $args): Response
    {
        $data = $request->getParsedBody();
        $id_payment = $args['id'];
        try {
            $result = $this->payment->updatePayment(
                $id_payment,
                $data["id_order"],
                $data["payment_method"],
                $data["payment_status"],
                $data["payment_date"],
                $data["total_price"]
            );

            if ($result) {
                $response->getBody()->write(json_encode(["success" => true]));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            }
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }

    public function deletePayment(Request $request, Response $response, $args): Response
    {
        $id_payment = $args['id'];
        try {
            $result = $this->payment->deletePayment($id_payment);

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