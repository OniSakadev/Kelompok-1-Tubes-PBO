<?php

namespace App\Model;

use App\Model\DB;
use PDO;
use PDOException;

class Payment extends DB
{
    public function addPayment($id_order, $payment_method, $payment_status, $payment_date, $total_price)
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO payment (id_order, payment_method, payment_status, payment_date, total_price) VALUES (:id_order, :payment_method, :payment_status, :payment_date, :total_price)");
            $stmt->bindParam(':id_order', $id_order);
            $stmt->bindParam(':payment_method', $payment_method);
            $stmt->bindParam(':payment_status', $payment_status);
            $stmt->bindParam(':payment_date', $payment_date);
            $stmt->bindParam(':total_price', $total_price);
            $stmt->execute();
            return ["success" => true];
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function getAllPayment($status = 'completed', $offset = 0, $limit = 10)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM payment WHERE payment_status = :status LIMIT :offset, :limit");
            $stmt->bindValue(':status', $status);
            $stmt->bindValue(':offset', (int)$offset);
            $stmt->bindValue(':limit', (int)$limit);

            $stmt->execute();

            $payments = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return [
                "data" => $payments
            ];
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function updatePayment($id_payment, $payment_method)
    {
        try {
            $stmt = $this->db->prepare("UPDATE payment SET payment_method = :payment_method WHERE id_payment = :id_payment");
            $stmt->bindParam(':id_payment', $id_payment);
            $stmt->bindParam(':payment_method', $payment_method);
            $stmt->execute();
            
            if ($stmt->rowCount() > 0) {
                return ["success" => true];
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function deletePayment($id_payment)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM payment WHERE id_payment = :id_payment");
            $stmt->bindParam(':id_payment', $id_payment);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ["success" => true];
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}