<?php
require_once "db_connect.php";

if (isset($_SESSION["user_id"])) {
    echo json_encode([
        "status" => "logged_in",
        "user_id" => $_SESSION["user_id"],
        "email" => $_SESSION["email"]
    ]);
} else {
    echo json_encode(["status" => "logged_out"]);
}
?>
