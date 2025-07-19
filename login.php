<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT Em_id, Username, Password, Role FROM Users WHERE Username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($em_id, $username, $hashed_password, $role);
    
    if ($stmt->num_rows > 0) {
        $stmt->fetch();
        if (password_verify($password, $hashed_password)) {
            $_SESSION["Em_id"] = $em_id;
            $_SESSION["Username"] = $username;
            $_SESSION["Role"] = $role;

            header("Location: dashboard.php"); // ไปหน้า Dashboard
            exit();
        } else {
            echo "รหัสผ่านไม่ถูกต้อง!";
        }
    } else {
        echo "ไม่พบชื่อผู้ใช้!";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เข้าสู่ระบบ</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; width: 100%; background: blue; color: white; }
    </style>
</head>
<body>
    <h2>เข้าสู่ระบบ</h2>
    <form action="login.php" method="POST">
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
        <input type="password" name="password" placeholder="รหัสผ่าน" required>
        <button type="submit">เข้าสู่ระบบ</button>
    </form>
    <p>ยังไม่มีบัญชี? <a href="register.php">สมัครสมาชิก</a></p>
</body>
</html>
