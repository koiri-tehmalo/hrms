<?php
session_start();
require 'db.php';

// ตรวจสอบสิทธิ์
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["Username"];
$role = $_SESSION["Role"];

// ดึงข้อมูลการลาของพนักงาน
if ($role == 'Admin' || $role == 'HR') {
    $sql = "SELECT * FROM Leave_Record";
} else {
    $sql = "SELECT * FROM Leave_Record WHERE Em_id = '$username'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบจัดการการลา</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
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
<body>

<div class="container mt-5">
    <h2 class="text-center">ระบบจัดการการลา</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">🔙 กลับหน้าหลัก</a>

    <table id="leaveTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>รหัสพนักงาน</th>
                <th>ประเภทการลา</th>
                <th>วันที่เริ่ม</th>
                <th>วันที่สิ้นสุด</th>
                <th>เหตุผล</th>
                <th>สถานะ</th>
                <?php if ($role == 'Admin' || $role == 'HR') { echo "<th>จัดการ</th>"; } ?>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Em_id"]; ?></td>
                    <td><?php echo $row["Leave_type"]; ?></td>
                    <td><?php echo $row["Start_date"]; ?></td>
                    <td><?php echo $row["End_date"]; ?></td>
                    <td><?php echo $row["Leave_reason"]; ?></td>
                    <td><?php echo $row["Leave_status"]; ?></td>
                    <?php if ($role == 'Admin' || $role == 'HR') { ?>
                        <td>
                            <a href="approve_leave.php?id=<?php echo $row["Leave_id"]; ?>&status=อนุมัติ" class="btn btn-success btn-sm">✅ อนุมัติ</a>
                            <a href="approve_leave.php?id=<?php echo $row["Leave_id"]; ?>&status=ปฏิเสธ" class="btn btn-danger btn-sm">❌ ปฏิเสธ</a>
                        </td>
                    <?php } ?>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h3 class="mt-4">ยื่นคำขอลา</h3>
    <form action="request_leave.php" method="POST">
        <label>ประเภทการลา:</label>
        <select name="leave_type" required>
            <option value="ลาป่วย">ลาป่วย</option>
            <option value="ลากิจ">ลากิจ</option>
            <option value="ลาพักร้อน">ลาพักร้อน</option>
            <option value="อื่นๆ">อื่นๆ</option>
        </select>
        <label>วันที่เริ่ม:</label>
        <input type="date" name="start_date" required>
        <label>วันที่สิ้นสุด:</label>
        <input type="date" name="end_date" required>
        <label>เหตุผล:</label>
        <textarea name="leave_reason" required></textarea>
        <button type="submit">ยื่นคำขอลา</button>
    </form>

</div>

<script>
    $(document).ready(function() {
        $('#leaveTable').DataTable();
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
