<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์ (เฉพาะ Admin และ HR เท่านั้น)
if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

// ดึงข้อมูลพนักงาน
$sql = "SELECT * FROM Employee";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการพนักงาน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">ระบบจัดการพนักงาน</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">🔙 กลับหน้าหลัก</a>
    <a href="add_employee.php" class="btn btn-success mb-3">➕ เพิ่มพนักงาน</a>

    <table id="employeeTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>แผนก</th>
                <th>ตำแหน่ง</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Em_id"]; ?></td>
                    <td><?php echo $row["First_name"]; ?></td>
                    <td><?php echo $row["Last_name"]; ?></td>
                    <td><?php echo $row["Department"]; ?></td>
                    <td><?php echo $row["Job_position"]; ?></td>
                    <td>
                        <a href="edit_employee.php?id=<?php echo $row["Em_id"]; ?>" class="btn btn-warning btn-sm">✏️ แก้ไข</a>
                        <a href="delete_employee.php?id=<?php echo $row["Em_id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">🗑️ ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#employeeTable').DataTable();
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
