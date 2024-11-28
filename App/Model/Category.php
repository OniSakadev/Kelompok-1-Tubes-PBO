<?php

namespace App\Model;

use App\Model\DB;
use PDOException;

class Category extends DB
{
    public int $id_category;
    public string $category_name;
    public string $description;


    public function tambah()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO category (category_name, description) VALUES (:category_name, :description)");
            $stmt->bindParam(':category_name', $this->category_name);
            $stmt->bindParam(':description', $this->description);
            $stmt->execute();
            return ["success" => true];
        } catch (PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    
    public function getAllCategories()
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM category");
            $stmt->execute();
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    
    public function getCategoryById($id_category)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM category WHERE id_category = :id_category");
            $stmt->bindParam(':id_category', $id_category, \PDO::PARAM_INT);
            if ($stmt->execute()) {
                $category = $stmt->fetch(\PDO::FETCH_ASSOC);
                if ($category) {
                    $this->id_category = $category['id_category'];
                    $this->category_name = $category['category_name'];
                    $this->description = $category['description'];
                    return $category;
                } else {
                    return ["message" => "Category not found"];
                }
            }
        } catch (PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
