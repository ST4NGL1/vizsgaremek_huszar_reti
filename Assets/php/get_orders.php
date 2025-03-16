<?php
session_start();
include 'db_connection.php'; // Include your database connection file

if (!isset($_SESSION['USERID'])) {
    echo json_encode([]);
    exit();
}

$userid = $_SESSION['USERID'];

// Retrieve orders for the user
$sql = "SELECT o.ORDERID, o.ORDERDATE, o.TOTALPRICE
        FROM orders o
        WHERE o.USERID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();

$orders = [];
while ($row = $result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode($orders);
?>