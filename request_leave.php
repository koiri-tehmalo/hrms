<?php
session_start();
require 'db.php';

if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$em_id = $_SESSION["Username"];
$leave_type = $_POST["leave_type"];
$start_date = $_POST["start_date"];
$end_date = $_POST["end_date"];
$leave_reason = $_POST["leave_reason"];

$stmt = $conn->prepare("INSERT INTO Leave_Record (Em_id, Leave_type, Start_date, End_date, Leave_reason) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("sssss", $em_id, $leave_type, $start_date, $end_date, $leave_reason);

if ($stmt->execute()) {
    echo "<script>alert('ยื่นคำขอลาสำเร็จ!'); window.location='leave.php';</script>";
}

$stmt->close();
$conn->close();
?>
