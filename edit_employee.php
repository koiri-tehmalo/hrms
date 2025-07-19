<?php
session_start();
require 'db.php';

// ตรวจสอบสิทธิ์
if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

// ดึงข้อมูลพนักงานจากฐานข้อมูล
$em_id = $_GET["id"];
$result = $conn->query("SELECT * FROM Employee WHERE Em_id = '$em_id'");
$employee = $result->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST["first_name"];
    $last_name = $_POST["last_name"];
    $department = $_POST["department"];
    $job_position = $_POST["job_position"];

    // อัพเดทข้อมูลพนักงานในฐานข้อมูล
    $stmt = $conn->prepare("UPDATE Employee SET First_name=?, Last_name=?, Department=?, Job_position=?, address=? ,Salary=?,Email=?,Phone=?,Gender=? WHERE Em_id=?");
    $stmt->bind_param("sssss", $first_name, $last_name, $department, $job_position, $em_id,$address,$salary,$email,$phone,$gender);

    if ($stmt->execute()) {
        header("Location: manage_employee.php");
        exit();
    }
}
?>

<form method="POST">
    <label>ชื่อ:</label>
    <input type="text" name="first_name" value="<?= $employee['First_name']; ?>" required>

    <label>นามสกุล:</label>
    <input type="text" name="last_name" value="<?= $employee['Last_name']; ?>" required>

    <label>แผนก:</label>
    <select name="department" required>
        <?php
        // ดึงรายการแผนกจากตาราง Department
        $dept_query = "SELECT Dept_id, Dept_name FROM department";
        $dept_result = $conn->query($dept_query);
        while ($dept_row = $dept_result->fetch_assoc()) {
            // ตรวจสอบว่าแผนกที่พนักงานอยู่ตรงกับแผนกในระบบหรือไม่
            $selected = ($employee['Department'] == $dept_row['Dept_id']) ? 'selected' : '';
            echo "<option value='" . $dept_row['Dept_id'] . "' $selected>" . $dept_row['Dept_name'] . "</option>";
        }
        ?>
    </select>

    <label>ตำแหน่ง:</label>
    <input type="text" name="job_position" value="<?= $employee['Job_position']; ?>" required>
    <label>ที่อยู่:</label>
    <input type="text" name="Address" value="<?= $employee['Address']; ?>"  required>
    <label>เงินเดือน:</label>
    <input type="text" name="Salary" value="<?= $employee['Salary']; ?>"  required>
    <label>อีเมล:</label>
    <input type="text" name="Email" value="<?= $employee['Email']; ?>"  required>
    <label>เบอร์โทร:</label>
    <input type="text" name="Phone" value="<?= $employee['Phone']; ?>"  required>
    <label>เพศ:</label>
    <input type="text" name="Gender" value="<?= $employee['Gender']; ?>"  required>

    <button type="submit">บันทึก</button>
</form>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แก้ไขข้อมูลพนักงาน</title>
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