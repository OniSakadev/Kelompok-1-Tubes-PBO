<?php

namespace App\Model;

use App\Model\DB;
use PDOException;

class Payment extends DB
{
    public int $id_payment;
    public int $id_order;
    public string $payment_method;
    public string $payment_status;
    public string $payment_date;
    public float $total_price;

    public function addPayment()
    {
        try {
            $stmt = $this->db->prepare("INSERT INTO payment (id_order, payment_method, payment_status, payment_date, total_price) VALUES (:id_order, :payment_method, :payment_status, :payment_date, :total_price)");
            $stmt->bindParam(':id_order', $this->id_order);
            $stmt->bindParam(':payment_method', $this->payment_method);
            $stmt->bindParam(':payment_status', $this->payment_status);
            $stmt->bindParam(':payment_date', $this->payment_date);
            $stmt->bindParam(':total_price', $this->total_price);
            $stmt->execute();
            return ["success" => true];
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }

    public function getAllPayment($id_payment)
    {
        $stmt = $this->db->prepare("SELECT * FROM payment WHERE id_payment = {$id_payment}");
        if ($stmt->execute()) {
            $payment = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id_payment = $payment['id_payment'];
            $this->id_order = $payment['id_order'];
            $this->payment_method = $payment['payment_method'];
            $this->payment_status = $payment['payment_status'];
            $this->payment_date = $payment['payment_date'];
            $this->total_price = $payment['total_price'];
        } else {
            return ["message" => "Payment not found"];
        }
    }

    public function updatePayment()
    {
        try {
            $stmt = $this->db->prepare("UPDATE payment 
            SET id_order = :id_order, 
                payment_method = :payment_method, 
                payment_status = :payment_status, 
                payment_date = :payment_date, 
                total_price = :total_price 
            WHERE id_payment = :id_payment");

            $stmt->bindParam(':id_order', $this->id_order);
            $stmt->bindParam(':payment_method', $this->payment_method);
            $stmt->bindParam(':payment_status', $this->payment_status);
            $stmt->bindParam(':payment_date', $this->payment_date);
            $stmt->bindParam(':total_price', $this->total_price);
            $stmt->bindParam(':id_payment', $this->id_payment);

            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ["success" => true, "message" => "Payment updated successfully"];
            } else {
                return ["success" => false, "message" => "No changes made"];
            }
        } catch (\PDOException $e) {
            return ["success" => false, "message" => $e->getMessage()];
        }
    }

    public function deletePayment($id_payment)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM payment WHERE id_payment = {$id_payment}");
            if ($stmt->execute()) {
                return ["success" => true, "message" => "Payment deleted successfully"];
            } else {
                return ["success" => false, "message" => "Failed to delete payment"];
            }
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
