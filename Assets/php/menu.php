<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

require_once('db_connect.php');


$sql = "SELECT * FROM menu ORDER BY CATEGORY DESC";
$result = $conn->query($sql);

$menu = [];
while ($row = $result->fetch_assoc()) {
    $menu[] = $row;
}

echo json_encode($menu);
$conn->close();
?>
