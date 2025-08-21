<?php

class UserModel
{
    public $conn;

    public function __construct()
    {
        $this->conn = connectDB();
    }

    public function findByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':email', $email);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function createUser($name, $gender, $dob, $email, $hash)
    {
        $sql = "INSERT INTO users (ho_ten, gioi_tinh, ngay_sinh, email, mat_khau, role) VALUES (:name, :gender, :dob, :email, :hash, 'user')";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':name', $name);
        $stmt->bindValue(':gender', $gender);
        $stmt->bindValue(':dob', $dob);
        $stmt->bindValue(':email', $email);
        $stmt->bindValue(':hash', $hash);
        $stmt->execute();
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function updatePasswordHash(int $id, string $hash): bool
    {
        $stmt = $this->conn->prepare("UPDATE users SET mat_khau = :hash WHERE id = :id");
        $stmt->bindValue(':hash', $hash);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}


