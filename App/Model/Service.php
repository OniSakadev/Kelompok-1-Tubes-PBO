<?php

namespace App\Model;

use App\Model\DB;
use PDOException;

class Service extends DB
{
    private $conn;
    private $table_name = "service";

    public int $id_service;
    public int $id_freelancer;
    public int $id_category;
    public $sub_category;
    public $title;
    public $description;
    public $industry;
    public $skills;
    public $deadline;
    public $price;


    // Create Service
    public function create()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO service (id_freelancer, id_category, sub_category, title, description, industry, skills, deadline, price) VALUES (:id_freelancer, :id_category, :sub_category, :title, :description, :industry, :skills, :deadline, :price)");
            $stmt->bindParam(":id_freelancer", $this->id_freelancer);
            $stmt->bindParam(":id_category", $this->id_category);
            $stmt->bindParam(":sub_category", $this->sub_category);
            $stmt->bindParam(":title", $this->title);
            $stmt->bindParam(":description", $this->description);
            $stmt->bindParam(":industry", $this->industry);
            $stmt->bindParam(":skills", $this->skills);
            $stmt->bindParam(":deadline", $this->deadline);
            $stmt->bindParam(":price", $this->price);
            $stmt->execute();
            return ["success" => true];
        } catch (PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    // Get all services
    public function find($id_service)
    {
        $stmt = $this->db->prepare("SELECT * FROM service WHERE id_service = {$id_service}");
        if ($stmt->execute()) {
            $service = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id_service = $service['id_service'];
            $this->id_freelancer = $service['id_freelancer'];
            $this->id_category = $service['id_category'];
            $this->sub_category = $service['sub_category'];
            $this->title = $service['title'];
            $this->description = $service['description'];
            $this->industry = $service['industry'];
            $this->skills = $service['skills'];
            $this->deadline = $service['deadline'];
            $this->price = $service['price'];
        } else {
            $service = null;
        }
    }

    public function update()
    {
        try {
            $stmt = $this->db->prepare("UPDATE service SET sub_category = :sub_category, title = :title, description = :description, industry = :industry, skills = :skills, deadline = :deadline, price = :price WHERE id_service = :id_service");
            $stmt->bindParam(':sub_category', $this->sub_category);
            $stmt->bindParam(':title', $this->title);
            $stmt->bindParam(':description', $this->description);
            $stmt->bindParam(':industry', $this->industry);
            $stmt->bindParam(':skills', $this->skills);
            $stmt->bindParam(':deadline', $this->deadline);
            $stmt->bindParam(':price', $this->price);
            $stmt->bindParam(':id_service', $this->id_service, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    // Delete Service
    public function delete($id_service)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM service WHERE id_service = {$id_service}");
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
