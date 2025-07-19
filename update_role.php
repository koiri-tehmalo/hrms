<?php
session_start();
require 'db.php';

// ✅ ตรวจสอบสิทธิ์ (เฉพาะ Admin เท่านั้น)
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] != 'Admin') {
    header("Location: dashboard.php");
    exit();
}

// รับค่าจากฟอร์ม
$em_id = $_POST["em_id"];
$new_role = $_POST["new_role"];

// อัปเดต Role ในฐานข้อมูล
$stmt = $conn->prepare("UPDATE Users SET Role = ? WHERE Em_id = ?");
$stmt->bind_param("ss", $new_role, $em_id);

if ($stmt->execute()) {
    echo "<script>alert('อัปเดตสิทธิ์สำเร็จ!'); window.location='manage_users.php';</script>";
} else {
    echo "เกิดข้อผิดพลาด: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
