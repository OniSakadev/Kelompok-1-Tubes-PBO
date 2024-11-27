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
}
