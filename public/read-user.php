<?php
require_once realpath(__DIR__ . "/../src/controllers/UserController.php");


if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (!isset($_GET["user-id"])) {
        http_response_code(400);
        echo json_encode(["error" => "User ID parameter missing."]);
        exit();
    }
    $id = $_GET["user-id"];

    $ctrl = new UserController();

    try {
        $user = $ctrl->read($id);
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }

    if ($user) {
        $userData = [
            "id" => $user->id,
            "photoName" => $user->photoName,
            "name" => $user->name,
            "email" => $user->email,
            "phone" => $user->phone,
        ];
        echo json_encode($userData);
    } else {
        http_response_code(404);
        echo json_encode(["error" => "User not found."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["error" => "User ID parameter missing."]);
}
