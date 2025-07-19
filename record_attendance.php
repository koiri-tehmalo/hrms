
<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล
// ตั้งค่าโซนเวลาเป็นไทย
date_default_timezone_set("Asia/Bangkok");

if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$em_id = $_SESSION["Username"];
$current_time = date("Y-m-d H:i:s");

// กดปุ่ม Check-in
if (isset($_POST["check_in"])) {
    $stmt = $conn->prepare("INSERT INTO Attendance (Em_id, Check_in) VALUES (?, ?)");
    $stmt->bind_param("ss", $em_id, $current_time);
    if ($stmt->execute()) {
        echo "<script>alert('เช็คอินสำเร็จ!'); window.location='attendance.php';</script>";
    }
}

// กดปุ่ม Check-out
if (isset($_POST["check_out"])) {
    $stmt = $conn->prepare("UPDATE Attendance SET Check_out = ?, Work_status = 'Completed' WHERE Em_id = ? AND Check_out IS NULL");
    $stmt->bind_param("ss", $current_time, $em_id);
    if ($stmt->execute()) {
        echo "<script>alert('เช็คเอาต์สำเร็จ!'); window.location='attendance.php';</script>";
    }
}

$conn->close();
?>
