<?php

namespace App\Model;

use App\Model\DB;
use PDOException;

class Review extends DB
{
    public int $id_review;
    public int $id_freelancer;
    public int $id_client;
    public int $rating;
    public string $comment;

    public function tambah()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO review (id_freelancer, id_client, rating, comment) VALUES (:id_freelancer, :id_client, :rating, :comment)");
            $stmt->bindParam(':id_freelancer', $this->id_freelancer);
            $stmt->bindParam(':id_client', $this->id_client);
            $stmt->bindParam(':rating', $this->rating);
            $stmt->bindParam(':comment', $this->comment);
            $stmt->execute();
            return ["success" => true];
        } catch (PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function find($id_review)
    {
        $stmt = $this->db->prepare("SELECT * FROM review WHERE id_review = {$id_review}");
        if ($stmt->execute()) {
            $review = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id_review = $review['id_review'];
            $this->id_freelancer = $review['id_freelancer'];
            $this->id_client = $review['id_client'];
            $this->rating = $review['rating'];
            $this->comment = $review['comment'];
        } else {
            $review = null;
        }
    }

    public function update()
    {
        try {
            $stmt = $this->db->prepare("UPDATE review SET rating = :rating, comment = :comment WHERE id_review = :id_review");
            $stmt->bindParam(':rating', $this->rating);
            $stmt->bindParam(':comment', $this->comment);
            $stmt->bindParam(':id_review', $this->id_review, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function delete($id_review)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM review WHERE id_review = {$id_review}");
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
