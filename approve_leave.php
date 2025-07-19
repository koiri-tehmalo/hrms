<?php
session_start();
require 'db.php';

if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: leave.php");
    exit();
}

$leave_id = $_GET["id"];
$status = $_GET["status"];

$stmt = $conn->prepare("UPDATE Leave_Record SET Leave_status = ? WHERE Leave_id = ?");
$stmt->bind_param("si", $status, $leave_id);

if ($stmt->execute()) {
    echo "<script>alert('อัปเดตสถานะสำเร็จ!'); window.location='leave.php';</script>";
}

$stmt->close();
$conn->close();
?>
