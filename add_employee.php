<?php
session_start();
require 'db.php';

// ตรวจสอบสิทธิ์
if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $em_id = $_POST["em_id"];
    $first_name = $_POST["First_name"];
    $last_name = $_POST["Last_name"];
    $department = $_POST["Department"];
    $job_position = $_POST["Job_position"];
    $address = $_POST["Address"];
    $salary = $_POST["Salary"];
    $email = $_POST["Email"];
    $phone = $_POST["Phone"];
    $gender = $_POST["Gender"];

    $stmt = $conn->prepare("INSERT INTO Employee (Em_id, First_name, Last_name, Department, Job_position, address ,Salary,Email,Phone,Gender) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssss", $em_id, $first_name, $last_name, $department, $job_position,$address,$salary,$email,$phone,$gender);

    if ($stmt->execute()) {
        header("Location: manage_employee.php");
        exit();
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    $stmt->close();
}
?>

<form method="POST">
    <label>รหัสพนักงาน:</label>
    <input type="text" name="em_id" required>
    <label>ชื่อ:</label>
    <input type="text" name="First_name" required>
    <label>นามสกุล:</label>
    <input type="text" name="Last_name" required>
    <label>แผนก:</label>
    <select name="Department" required>
        <?php
        $dept_query = "SELECT Dept_id, Dept_name FROM department";
        $dept_result = $conn->query($dept_query);
        while ($dept_row = $dept_result->fetch_assoc()) {
        echo "<option value='" . $dept_row['Dept_id'] . "'>" . $dept_row['Dept_name'] . "</option>";
    }
    ?>
    </select>
    <label>ตำแหน่ง:</label>
    <input type="text" name="Job_position" required>
    <label>ที่อยู่:</label>
    <input type="text" name="Address" required>
    <label>เงินเดือน:</label>
    <input type="text" name="Salary" required>
    <label>อีเมล:</label>
    <input type="text" name="Email" required>
    <label>เบอร์โทร:</label>
    <input type="text" name="Phone" required>
    <label>เพศ:</label>
    <input type="text" name="Gender" required>
    <button type="submit">เพิ่มพนักงาน</button>
</form>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>เพิ่มข้อมูลพนักงาน</title>
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
