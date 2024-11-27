<?php

namespace App\Model\Akun;

use App\Model\Akun\User;


class Freelance extends User
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

    public function register()
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

    public function find($id_freelancer)
    {
        $stmt = $this->db->prepare("SELECT * FROM freelancer WHERE id_freelancer = {$id_freelancer}");
        if ($stmt->execute()) {
            $freelancer = $stmt->fetch(\PDO::FETCH_ASSOC);
            $this->id = $freelancer['id_freelancer'];
            $this->email = $freelancer['email'];
            $this->password = $freelancer['password'];
            $this->name = $freelancer['full_name'];
            $this->username = $freelancer['user_name'];
            $this->phone = $freelancer['phone_number'];
            $this->birth = $freelancer['birth_date'];
            $this->place = $freelancer['place_of_birth'];
            $this->gender = $freelancer['gender'];
            $this->job = $freelancer['job_position'];
            $this->skill = $freelancer['skills'];
            $this->about = $freelancer['about_you'];
        } else {
            $freelancer = null;
        }
    }

    public function update()
    {
        try {
            $stmt = $this->db->prepare("
                UPDATE freelancer SET
                email = :email,
                full_name = :full_name,
                user_name = :user_name,
                phone_number = :phone_number,
                birth_date = :birth_date,
                place_of_birth = :place_of_birth,
                gender = :gender,
                job_position = :job_position,
                skills = :skills,
                about_you = :about_you
                WHERE id_freelancer = :id_freelancer
            ");
            $stmt->bindParam(':email', $this->email);
            $stmt->bindParam(':full_name', $this->name);
            $stmt->bindParam(':user_name', $this->username);
            $stmt->bindParam(':phone_number', $this->phone);
            $stmt->bindParam(':birth_date', $this->birth);
            $stmt->bindParam(':place_of_birth', $this->place);
            $stmt->bindParam(':gender', $this->gender);
            $stmt->bindParam(':job_position', $this->job);
            $stmt->bindParam(':skills', $this->skill);
            $stmt->bindParam(':about_you', $this->about);
            $stmt->bindParam(':id_freelancer', $this->id, \PDO::PARAM_INT);
            return $stmt->execute();
        } catch (\PDOException $e) {
            http_response_code(500);
            return ["message" => $e->getMessage()];
        }
    }
}
