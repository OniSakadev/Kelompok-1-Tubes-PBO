<?php

namespace App\Model\Akun;

use App\Model\Model;


class Klien extends Model
{
    public int $id;
    public string $email;
    public $password;
    public string $name;
    public string $username;
    public string $phone;

    public function save()
    {
        try {
            $stmt = $this->db->prepare("
            INSERT INTO client
            (email, password, full_name, username, phone_number)
            VALUES
            (:email, :password, :full_name, :username, :phone_number)");
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':full_name', $this->name);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':phone_number', $this->phone);
            $status = $stmt->execute();


            $stmt = $this->db->query("SELECT LAST_INSERT_ID()");
            $last_id = $stmt->fetchColumn();


            $result = [
                'status' => $status,
                'id' => $last_id
            ];
        } catch (\PDOException $e) {
            http_response_code(500);
            $result = ["message" => $e->getMessage()];
        }
        return $result;
    }
}
