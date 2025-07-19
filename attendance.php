<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบสิทธิ์ผู้ใช้
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["Username"];
$role = $_SESSION["Role"];

// ดึงข้อมูลการเข้า-ออกงาน
if ($role == 'Admin' || $role == 'HR') {
    $sql = "SELECT * FROM Attendance";
} else {
    $sql = "SELECT * FROM Attendance WHERE Em_id = '$username'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>บันทึกการเข้า-ออกงาน</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">ระบบบันทึกการเข้า-ออกงาน</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">🔙 กลับหน้าหลัก</a>

    <form action="record_attendance.php" method="POST">
        <button type="submit" name="check_in" class="btn btn-success">✅ Check-in</button>
        <button type="submit" name="check_out" class="btn btn-danger">⏳ Check-out</button>
    </form>

    <table id="attendanceTable" class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>รหัสพนักงาน</th>
                <th>เวลาเข้า</th>
                <th>เวลาออก</th>
                <th>สถานะ</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Em_id"]; ?></td>
                    <td><?php echo $row["Check_in"]; ?></td>
                    <td><?php echo $row["Check_out"] ? $row["Check_out"] : "-"; ?></td>
                    <td><?php echo $row["Work_status"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    $(document).ready(function() {
        $('#attendanceTable').DataTable();
    });
</script>

</body>
</html>

<?php $conn->close(); ?>
