<?php

namespace App\Controllers;

use App\Model\DB;
use App\Model\Category;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use PDOException;

class CategoryController extends DB
{


    public function tambah(Request $request, Response $response): Response
    {
        $data = $request->getParsedBody();
        $category= new Category($this->db);

        try {
            $category->category_name = $data['category_name'];
            $category->description= $data['description'];
            $result = $category->tambah();
            $response->getBody()->write(json_encode($result));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('content-type', 'application/json')->withStatus(500);
        }
    }


    // Menampilkan semua kategori
    public function getAllCategories(Request $request, Response $response): Response
    {
        try {
            $category = new Category($this->db);
            $categories = $category->getAllCategories();

            $response->getBody()->write(json_encode($categories));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    // Menampilkan kategori berdasarkan ID
    public function getCategoryById(Request $request, Response $response, $args): Response
    {
        try {
            $id_category = $args['id'];
            $category = new Category($this->db);
            $categoryData = $category->getCategoryById($id_category);

            // Jika kategori ditemukan
            if (isset($categoryData['id_category'])) {
                $response->getBody()->write(json_encode($categoryData));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
            } else {
                // Jika kategori tidak ditemukan
                $response->getBody()->write(json_encode($categoryData));
                return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
            }
        } catch (PDOException $e) {
            $error = ["message" => $e->getMessage()];
            $response->getBody()->write(json_encode($error));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
}
