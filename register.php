<?php
require 'db.php'; // เชื่อมต่อฐานข้อมูล
session_start(); // ใช้ Session เพื่อตรวจสอบสิทธิ์

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $em_id = $_POST["em_id"];
    $username = $_POST["username"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT); // เข้ารหัสรหัสผ่าน
    $role = $_POST["role"];

    // ตรวจสอบว่า Em_id หรือ Username ซ้ำหรือไม่
    $stmt = $conn->prepare("SELECT Em_id FROM Users WHERE Em_id = ? OR Username = ?");
    $stmt->bind_param("ss", $em_id, $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "<script>alert('รหัสพนักงานหรือชื่อผู้ใช้ถูกใช้แล้ว! กรุณากรอกใหม่'); window.location='register.php';</script>";
    } else {
        // ป้องกันพนักงานทั่วไปสมัครเป็น Admin/HR
        if (!isset($_SESSION["Role"]) || $_SESSION["Role"] != "Admin") {
            $role = "Employee"; // ถ้าไม่ใช่ Admin บังคับให้สมัครได้แค่ Employee
        }

        // บันทึกข้อมูลลงฐานข้อมูล
        $stmt = $conn->prepare("INSERT INTO Users (Em_id, Username, Password, Role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $em_id, $username, $password, $role);

        if ($stmt->execute()) {
            echo "<script>alert('สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ'); window.location='login.php';</script>";
        } else {
            echo "เกิดข้อผิดพลาด: " . $stmt->error;
        }
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
    <title>สมัครสมาชิก</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; }
        form { width: 300px; margin: auto; padding: 20px; border: 1px solid #ccc; border-radius: 10px; }
        input, select { width: 100%; padding: 10px; margin: 10px 0; }
        button { padding: 10px; width: 100%; background: green; color: white; }
    </style>
</head>
<body>
    <h2>สมัครสมาชิก</h2>
    <form action="register.php" method="POST">
        <input type="text" name="em_id" placeholder="รหัสพนักงาน" required>
        <input type="text" name="username" placeholder="ชื่อผู้ใช้" required>
        <input type="password" name="password" placeholder="รหัสผ่าน" required>

        <?php if (isset($_SESSION["Role"]) && $_SESSION["Role"] == "Admin") { ?>
        <label>สิทธิ์การใช้งาน:</label>
        <select name="role">
            <option value="Employee">Employee</option>
            <option value="HR">HR</option>
            <option value="Admin">Admin</option>
        </select>
        <?php } else { ?>
        <input type="hidden" name="role" value="Employee">
        <?php } ?>

        <button type="submit">สมัครสมาชิก</button>
    </form>
    <p>มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบ</a></p>
</body>
</html>
