<?php

namespace App\Model;

use App\Model\DB;
use PDOException;
use ReflectionFunctionAbstract;

class Order extends DB
{
    public int $id_order;
    public int $id_freelancer;
    public int $id_client;
    public int $id_service;
    public string $order_detail;
    public string $supported_file;
    public string $order_date;

    /**
     * Tambah order baru ke database
     */
    public function tambah()
    {
        try {
            $order_detail = $this->order_detail;
            $supported_file = $this->supported_file;
            $order_date = $this->order_date;

            $stmt = $this->db->prepare(
                "INSERT INTO `order` (id_freelancer, id_client, id_service, order_detail, supported_file, order_date) 
                 VALUES (:id_freelancer, :id_client, :id_service, :detail, :file, :date)"
            );
            $stmt->bindParam(':id_freelancer', $this->id_freelancer);
            $stmt->bindParam(':id_client', $this->id_client);
            $stmt->bindParam(':id_service', $this->id_service);
            $stmt->bindParam(':detail', $order_detail);
            $stmt->bindParam(':file', $supported_file);
            $stmt->bindParam(':date', $order_date);
            $stmt->execute();

            $this->id_order = $this->db->lastInsertId();
            return ["success" => true];
        } catch (PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function find($id_order)
    {
        $stmt = $this->db->prepare("SELECT * FROM `order` WHERE id_order = {$id_order}");
        if ($stmt->execute()) {
            $order = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id_order = $order['id_order'];
            $this->id_freelancer = $order['id_freelancer'];
            $this->id_client = $order['id_client'];
            $this->id_service = $order['id_service'];
            $this->order_detail = $order['order_detail'];
            $this->supported_file = $order['supported_file'];
            $this->order_date = $order['order_date'];
        } else {
            $order = null;
        }
    }

    public function update()
    {
        try {
            $stmt = $this->db->prepare("UPDATE `order` SET order_detail = :order_detail WHERE id_order = :id_order");
            $stmt->bindParam(':order_detail', $this->order_detail);
            $stmt->bindParam(':id_order', $this->id_order, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
    public function delete($id_order)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM `order` WHERE id_order = {$id_order}");
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
