<?php
session_start();
require 'db.php';

// ตรวจสอบสิทธิ์
if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dept_id = $_POST["Dept_id"];
    $dept_name = $_POST["Dept_name"];
    $dept_head = $_POST["Dept_head"];
    
    $stmt = $conn->prepare("INSERT INTO department (Dept_id, Dept_name, Dept_head) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $dept_id, $dept_name, $dept_name);

    if ($stmt->execute()) {
        header("Location: manage_department.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
}
?>

<form method="POST">
    <label>รหัสแผนก:</label>
    <input type="text" name="Dept_id" required>
    <label>ชื่อแผนก:</label>
    <input type="text" name="Dept_name" required>
    <label>หัวหน้าแผนก:</label>
    <input type="text" name="Dept_head" required>
    <button type="submit">เพิ่มพนักงาน</button>
</form>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มแผนก</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
            background: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input, select, button {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button {
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
