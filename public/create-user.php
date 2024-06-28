<?php
require "functions.php";
require_once realpath(__DIR__ . "/../src/controllers/UserController.php");


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];

    // check if all fields including the photo were provided
    if (empty($name) || empty($email) || empty($phone)) {
        http_response_code(400);
        echo json_encode(["error" => "Required fields are missing."]);
        exit();
    } else if (!isset($_FILES["photo"]) || $_FILES["photo"]["error"] !== UPLOAD_ERR_OK) {
        http_response_code(400);
        echo json_encode(["error" => "An image must be uploaded when creating a user."]);
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

    // checks if photo is valid
    list($ok, $error) = checkImageFile($_FILES["photo"]);
    if (!$ok) {
        http_response_code(400);
        echo json_encode(["error" => $error]);
        exit();
    }

    // uses the e-mail address as the filename
    $normalizedEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
    $normalizedEmail = preg_replace("/[^a-zA-Z0-9\.]/", "", $normalizedEmail);
    $photoName =  $normalizedEmail . "." . pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);

    $ctrl = new UserController();
    
    try {
        $user = $ctrl->create($name, $email, $phone, $photoName);
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }

    $targetDir = "../uploads/" . $user->id . "/";

    $uploadedFile = moveFile($_FILES["photo"], $targetDir, $photoName);
    if ($uploadedFile && file_exists($uploadedFile)) {
        http_response_code(200);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "Couldn't load photo to server."]);
        $ctrl->delete($user->id);
        deleteUserFolder($user->id);
    }
}
