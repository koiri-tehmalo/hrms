<?php
session_start();
require 'db.php';

// ✅ ตรวจสอบว่าผู้ใช้ล็อกอินอยู่หรือไม่
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["Username"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // ✅ ดึงรหัสผ่านปัจจุบันจากฐานข้อมูล
    $stmt = $conn->prepare("SELECT Password FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();

    // ✅ ตรวจสอบว่ารหัสผ่านปัจจุบันถูกต้องหรือไม่
    if (!password_verify($current_password, $hashed_password)) {
        echo "<script>alert('รหัสผ่านปัจจุบันไม่ถูกต้อง!'); window.location='change_password.php';</script>";
        exit();
    }

    // ✅ ตรวจสอบว่ารหัสผ่านใหม่และยืนยันตรงกันหรือไม่
    if ($new_password !== $confirm_password) {
        echo "<script>alert('รหัสผ่านใหม่ไม่ตรงกัน!'); window.location='change_password.php';</script>";
        exit();
    }

    // ✅ เข้ารหัสรหัสผ่านใหม่และอัปเดตในฐานข้อมูล
    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE Users SET Password = ? WHERE Username = ?");
    $stmt->bind_param("ss", $new_hashed_password, $username);

    if ($stmt->execute()) {
        echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ! กรุณาเข้าสู่ระบบใหม่'); window.location='logout.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด! กรุณาลองใหม่อีกครั้ง'); window.location='change_password.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เปลี่ยนรหัสผ่าน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; width: 100%; background: blue; color: white; }
    </style>
</head>
<body>
    <h2>🔑 เปลี่ยนรหัสผ่าน</h2>
    <form action="change_password.php" method="POST">
        <input type="password" name="current_password" placeholder="รหัสผ่านปัจจุบัน" required>
        <input type="password" name="new_password" placeholder="รหัสผ่านใหม่" required>
        <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่านใหม่" required>
        <button type="submit">เปลี่ยนรหัสผ่าน</button>
    </form>
    <br>
    <a href="dashboard.php">⬅️ กลับหน้าหลัก</a>
</body>
</html>
