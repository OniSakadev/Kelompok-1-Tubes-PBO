<?php


namespace App\Model;


header('Content-Type: application/json; charset=utf-8');


use PDO;
use PDOException;


class DB
{
    protected $db;


    public function __construct()
    {
        try {
            $conn = new PDO("mysql:host=localhost;dbname=pbo2024", 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $conn;
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
}
