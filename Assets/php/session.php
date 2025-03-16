<?php
require_once "db_connect.php";
session_start(); // Start the session

if (isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "logged_in",
        "user_id" => $_SESSION["user_id"]
    ]);
} else {
    echo json_encode(["status" => "logged_out"]);
}
?>
