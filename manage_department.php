<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์ (เฉพาะ Admin และ HR เท่านั้น)
if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

// ดึงข้อมูลพนักงาน
$sql = "SELECT * FROM department";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการแผนก</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">ระบบจัดการแผนก</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">🔙 กลับหน้าหลัก</a>
    <a href="add_department.php" class="btn btn-success mb-3">➕ เพิ่มแผนก</a>

    <table id="departmentTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>รหัสแผนก</th>
                <th>ชื่อแผนก</th>
                <th>หัวหน้าแผนก</th>
                <th>จัดการ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Dept_id"]; ?></td>
                    <td><?php echo $row["Dept_name"]; ?></td>
                    <td><?php echo $row["Dept_head"]; ?></td>
                    <td>
                        <a href="edit_department.php?id=<?php echo $row["Dept_id"]; ?>" class="btn btn-warning btn-sm">✏️ แก้ไข</a>
                        <a href="delete_department.php?id=<?php echo $row["Dept_id"]; ?>" class="btn btn-danger btn-sm" onclick="return confirm('ยืนยันการลบ?')">🗑️ ลบ</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#departmentTable').DataTable();
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
