<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Review;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class ReviewController extends DB
{

    public function tambah(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $review = new Review($this->db);

        try {
            $review->id_freelancer = $data['id_freelancer'];
            $review->id_client = $data['id_client'];
            $review->rating = $data['rating'];
            $review->comment = $data['comment'];
            $result = $review->tambah();
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
            $id_review = $args['id'];
            $review = new Review($this->db);
            $review->find($id_review);
            $response->getBody()->write(json_encode($review));
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
        $id_review = $args['id'];
        $review = new Review($this->db);
        try {
            $review->id_review = $id_review;
            $review->rating = $data['rating'];
            $review->comment = $data['comment'];
            $result = $review->update();
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
            $id_review = $args['id'];
            $review = new Review($this->db);
            $review->delete($id_review);
            $response->getBody()->write(json_encode(["message" => "Review Dihapus"]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }
}
