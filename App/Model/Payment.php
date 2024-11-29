<?php

namespace App\Model;

use App\Model\DB;
use PDO;
use PDOException;

class Payment extends DB
{
    public int $id;
    public int $id_order;
    public string $payment_method;
    public string $payment_status;
    public string $payment_date;
    public float $price;

    public function addPayment()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO payment (id_order, payment_method, payment_status, payment_date, total_price) VALUES (:id_order, :payment_method, :payment_status, :payment_date, :total_price)");
            $stmt->bindParam(':id_order', $this->id_order);
            $stmt->bindParam(':payment_method', $this->payment_method);
            $stmt->bindParam(':payment_status', $this->payment_status);
            $stmt->bindParam(':payment_date', $this->payment_date);
            $stmt->bindParam(':price', $this->price);
            $stmt->execute();
            return ["success" => true];
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function getAllPayment($payment_status)
    {
        $stmt = $this->db->prepare("SELECT * FROM payment WHERE payment_status = {$payment_status}");
        if ($stmt->execute()) {
            $payment = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id = $payment['id_payment'];
            $this->id_order = $payment['id_order'];
            $this->payment_method = $payment['payment_method'];
            $this->payment_status = $payment['payment_status'];
            $this->payment_date = $payment['payment_date'];
        } else {
            $payment = null;
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