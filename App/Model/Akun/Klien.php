<?php

namespace App\Model\Akun;

use App\Model\Akun\User;


class Klien extends User
{
    public int $id;
    public string $email;
    public $password;
    public string $name;
    public string $username;
    public string $phone;

    public function register()
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

    public function find($id_client)
    {
        $stmt = $this->db->prepare("SELECT * FROM client WHERE id_client = {$id_client}");
        if ($stmt->execute()) {
            $client = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id = $client['id_client'];
            $this->email = $client['email'];
            $this->password = $client['password'];
            $this->name = $client['full_name'];
            $this->username = $client['username'];
            $this->phone = $client['phone_number'];
        } else {
            $client = null;
        }
    }

    public function update()
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE client SET
                email = :email,
                full_name = :full_name,
                username = :username,
                phone_number = :phone_number
                WHERE id_client = :id_client
            ");
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':full_name', $this->name);
            $stmt->bindParam(':username', $this->username);
            $stmt->bindParam(':phone_number', $this->phone);
            $stmt->bindParam(':id_client', $this->id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
