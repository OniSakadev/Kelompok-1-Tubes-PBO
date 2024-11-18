<?php

namespace App\Model\Akun;

use App\Model\Model;


class Freelance extends Model
{
    public int $id;
    public string $email;
    public $password;
    public string $name;
    public string $username;
    public string $phone;
    public string $birth;
    public string $place;
    public string $gender;
    public string $job;
    public string $skill;
    public string $about;

    public function save()
    {
        try {
            $stmt = $this->db->prepare("
            INSERT INTO freelancer
            (email, password, full_name, user_name, phone_number, birth_date, place_of_birth, gender, job_position, skills, about_you)
            VALUES
            (:email, :password, :full_name, :user_name, :phone_number, :birth_date, :place_of_birth, :gender, :job_position, :skills, :about_you)
            ");
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':password', $this->password);
            $stmt->bindParam(':full_name', $this->name);
            $stmt->bindParam(':user_name', $this->username);
            $stmt->bindParam(':phone_number', $this->phone);
            $stmt->bindParam(':birth_date', $this->birth);
            $stmt->bindParam(':place_of_birth', $this->place);
            $stmt->bindParam(':gender', $this->gender);
            $stmt->bindParam(':job_position', $this->job);
            $stmt->bindParam(':skills', $this->skill);
            $stmt->bindParam(':about_you', $this->about);
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
