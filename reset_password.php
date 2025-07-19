<?php
session_start();
require 'db.php';

// ✅ ตรวจสอบสิทธิ์ (เฉพาะ HR และ Admin เท่านั้น)
if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $em_id = $_POST["em_id"];
}

// ✅ ดึงข้อมูลพนักงานจากฐานข้อมูล
$stmt = $conn->prepare("SELECT Username FROM Users WHERE Em_id = ?");
$stmt->bind_param("s", $em_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($username);
$stmt->fetch();
$stmt->close();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["new_password"])) {
    $new_password = $_POST["new_password"];
    $confirm_password = $_POST["confirm_password"];

    // ✅ ตรวจสอบว่ารหัสผ่านใหม่และยืนยันตรงกัน
    if ($new_password !== $confirm_password) {
        echo "<script>alert('รหัสผ่านใหม่ไม่ตรงกัน!'); window.location='reset_password.php';</script>";
        exit();
    }

    // ✅ เข้ารหัสรหัสผ่านใหม่
    $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("UPDATE Users SET Password = ? WHERE Em_id = ?");
    $stmt->bind_param("ss", $new_hashed_password, $em_id);

    if ($stmt->execute()) {
        echo "<script>alert('รีเซ็ตรหัสผ่านสำเร็จ!'); window.location='manage_users.php';</script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด! กรุณาลองใหม่อีกครั้ง'); window.location='reset_password.php';</script>";
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
    <title>รีเซ็ตรหัสผ่าน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; text-align: center; margin-top: 50px; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; width: 100%; background: red; color: white; }
    </style>
</head>
<body>
    <h2>🔑 รีเซ็ตรหัสผ่าน</h2>
    <p>เปลี่ยนรหัสผ่านของพนักงาน: <strong><?php echo $username; ?></strong></p>
    <form action="reset_password.php" method="POST">
        <input type="hidden" name="em_id" value="<?php echo $em_id; ?>">
        <input type="password" name="new_password" placeholder="รหัสผ่านใหม่" required>
        <input type="password" name="confirm_password" placeholder="ยืนยันรหัสผ่านใหม่" required>
        <button type="submit">รีเซ็ตรหัสผ่าน</button>
    </form>
    <br>
    <a href="manage_users.php">⬅️ กลับหน้าจัดการผู้ใช้</a>
</body>
</html>
