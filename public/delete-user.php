<?php
require "functions.php";
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
        $ctrl->delete($id);
        deleteUserFolder($id);
    } catch (Exception $e) {
        http_response_code(404);
        echo json_encode(["error" => $e->getMessage()]);
        exit();
    }
}
