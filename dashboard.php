<?php
session_start();
require 'db.php'; // เชื่อมต่อฐานข้อมูล

// ตรวจสอบว่าเข้าสู่ระบบหรือยัง
if (!isset($_SESSION["Username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["Username"];
$role = $_SESSION["Role"];

// ดึงข้อมูลพนักงานทั้งหมด (เฉพาะ Admin กับ HR เท่านั้น)
if ($role == 'Admin' || $role == 'HR') {
    $sql = "SELECT Em_id, First_name, Last_name, Job_position, Department FROM Employee";
} else {
    // ถ้าเป็น Employee ให้ดูข้อมูลของตัวเองเท่านั้น
    $sql = "SELECT Em_id, First_name, Last_name, Job_position, Department FROM Employee WHERE Em_id = '$username'";
}

$result = $conn->query($sql);
?>
<div class="text-center">

<?php if ($_SESSION["Role"] == "Admin") { ?>
    <a href="manage_users.php" class="btn btn-success"> จัดการผู้ใช้</a>

<?php } ?>

<?php if ($_SESSION["Role"] == "HR" || $_SESSION["Role"] == "Admin") { ?>
    <a href="manage_employee.php" class="btn btn-warning"> จัดการพนักงาน</a>
    <a href="add_employee.php" class="btn btn-warning"> เพิ่มพนักงาน</a>
    <a href="manage_department.php" class="btn btn-warning"> จัดการแผนก</a>
    <a href="add_department.php" class="btn btn-warning"> เพิ่มแผนก</a>
<?php } ?>
</div>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body { font-family: Arial, sans-serif; background-color: #f8f9fa; }
        .container { margin-top: 50px; }
        .card { margin-bottom: 20px; }
    </style>
</head>
<body>

<div class="container">
    <h2 class="text-center">Dashboard ระบบจัดการพนักงาน</h2>
    <p class="text-center">ยินดีต้อนรับ <strong><?php echo $_SESSION["Username"]; ?></strong> (<?php echo $_SESSION["Role"]; ?>)</p>
    
    <div class="d-flex justify-content-between mb-3">
    <a href="attendance.php" class="btn btn-success">บันทึกเวลาเข้า-ออกงาน</a>
    <a href="leave.php" class="btn btn-warning">จัดการการลา</a>
    <a href="change_password.php" class="btn btn-warning">🔑 เปลี่ยนรหัสผ่าน</a> <!-- ปุ่มเปลี่ยนรหัสผ่าน -->
    <a href="logout.php" class="btn btn-danger">ออกจากระบบ</a>
    </div>

    <div class="row">
        <!-- การ์ดแสดงจำนวนพนักงาน -->
        <div class="col-md-4">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <h5 class="card-title">จำนวนพนักงานทั้งหมด</h5>
                    <p class="card-text">
                        <?php
                        $count_sql = "SELECT COUNT(*) AS total FROM Employee";
                        $count_result = $conn->query($count_sql);
                        $count_row = $count_result->fetch_assoc();
                        echo $count_row["total"] . " คน";
                        ?>
                    </p>
                </div>
            </div>
        </div>

        <!-- การ์ดแสดงจำนวนพนักงานในแต่ละแผนก -->
        <div class="col-md-4">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <h5 class="card-title">จำนวนแผนก</h5>
                    <p class="card-text">
                        <?php
                        $dept_sql = "SELECT COUNT(DISTINCT Department) AS total FROM Employee";
                        $dept_result = $conn->query($dept_sql);
                        $dept_row = $dept_result->fetch_assoc();
                        echo $dept_row["total"] . " แผนก";
                        ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- ตารางแสดงข้อมูลพนักงาน -->
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>รหัสพนักงาน</th>
                <th>ชื่อ</th>
                <th>นามสกุล</th>
                <th>ตำแหน่ง</th>
                <th>แผนก</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Em_id"]; ?></td>
                    <td><?php echo $row["First_name"]; ?></td>
                    <td><?php echo $row["Last_name"]; ?></td>
                    <td><?php echo $row["Job_position"]; ?></td>
                    <td><?php echo $row["Department"]; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>

<?php $conn->close(); ?>
