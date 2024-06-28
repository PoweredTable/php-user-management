<?php
require_once "Database.php";


class User
{
    public $id;
    public $name;
    public $email;
    public $phone;
    public $photoName;

    public function __construct($id = null, $name = "", $email = "", $phone = null, $photoName = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
        $this->phone = $phone;
        $this->photoName = $photoName;
    }

    public static function create(User $user): User
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "INSERT INTO user (name, email, phone, photo_path) VALUES (:name, :email, :phone, :photo_path)";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":phone", $user->phone);
            $stmt->bindParam(":photo_path", $user->photoName);
            $stmt->execute();

            $user->id = $conn->lastInsertId();
            return $user;
        } catch (PDOException $e) {
            throw new Exception("Database error on create user: " . $e->getMessage());
        }
    }

    public static function read(int $user_id): ?User
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM user WHERE id = :id";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":id", $user_id);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                return null;
            }

            $user = new User($row["id"], $row["name"], $row["email"], $row["phone"], $row["photo_path"]);

            return $user;
        } catch (PDOException $e) {
            throw new Exception("Database error on read user: " . $e->getMessage());
        }
    }

    public static function readAll(): array
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "SELECT * FROM user";
            $stmt = $conn->query($sql);

            $users = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $user = new User($row["id"], $row["name"], $row["email"], $row["phone"], $row["photo_path"]);
                $users[] = $user;
            }

            return $users;
        } catch (PDOException $e) {
            throw new Exception("Database error on read users: " . $e->getMessage());
        }
    }

    public static function update(User $user): void
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "UPDATE user SET name = :name, email = :email, phone = :phone, photo_path = :photo_path WHERE id = :id";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":id", $user->id);
            $stmt->bindParam(":name", $user->name);
            $stmt->bindParam(":email", $user->email);
            $stmt->bindParam(":phone", $user->phone);
            $stmt->bindParam(":photo_path", $user->photoName);

            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database error on update user: " . $e->getMessage());
        }
    }

    public static function delete(int $user_id): void
    {
        $db = new Database();
        $conn = $db->getConnection();

        try {
            $sql = "DELETE FROM user WHERE id = :id";
            $stmt = $conn->prepare($sql);

            $stmt->bindParam(":id", $user_id);
            $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Database error on delete user: " . $e->getMessage());
        }
    }
}
