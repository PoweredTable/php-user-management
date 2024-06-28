<?php
require "functions.php";
require_once realpath(__DIR__ . "/../src/controllers/UserController.php");
require_once realpath(__DIR__ . "/../src/models/User.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isset($_POST["user-id"])) {
        http_response_code(400);
        echo json_encode(["error" => "User ID parameter missing."]);
        exit();
    }
    $id = $_POST["user-id"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // check if all fields but the photo were included
    if (empty($name) || empty($email) || empty($phone)) {
        http_response_code(400);
        echo json_encode(["error" => "Required fields are missing."]);
        exit();
    }

    // sanitizes user input 
    $name = sanitizeInput($_POST["name"]);
    $email = validateEmail($_POST["email"]);
    if ($email === false) {
        http_response_code(400);
        echo json_encode(["error" => "Not a valid email."]);
        exit();
    }
    $phone = sanitizeInput($_POST["phone"]);

    $doFileUpload = false;
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] === UPLOAD_ERR_OK) {
        list($ok, $error) = checkImageFile($_FILES["photo"]);
        if (!$ok) {
            http_response_code(400);
            echo json_encode(["error" => $error]);
            exit();
        }
        $normalizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        $normalizedEmail = preg_replace("/[^a-zA-Z0-9\.]/", "", $normalizedEmail);
        $photoName =  $normalizedEmail . "." . pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $doFileUpload = true;
    } else {
        $photoName = $_POST["photo-name"];
    }

    $ctrl = new UserController();

    try {
        $user = new User($id, $name, $email, $phone, $photoName);
        $ctrl->update($user);
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }

    if (!$doFileUpload) {
        http_response_code(200);
        exit();
    }

    $targetDir = "../uploads/" . $user->id . "/";

    $uploadedFile = moveFile($_FILES["photo"], $targetDir, $photoName);
    if ($uploadedFile && file_exists($uploadedFile)) {
        if ($photoName !== $_POST["photo-name"]) {
            deleteFileInFolder("../uploads/" . $user->id . "/", $_POST["photo-name"]);
        }
        http_response_code(200);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Couldn't load photo to server."]);
    }
}
