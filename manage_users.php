<?php
session_start();
require 'db.php';

// ✅ ตรวจสอบสิทธิ์ (เฉพาะ Admin เท่านั้นที่เข้าถึงได้)
if (!isset($_SESSION["Username"]) || $_SESSION["Role"] != 'Admin') {
    header("Location: dashboard.php");
    exit();
}

// ดึงข้อมูลผู้ใช้ทั้งหมด
$sql = "SELECT Em_id, Username, Role FROM Users";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>จัดการสิทธิ์ผู้ใช้</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center">จัดการสิทธิ์ผู้ใช้</h2>
    <a href="dashboard.php" class="btn btn-secondary mb-3">🔙 กลับหน้าหลัก</a>

    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>รหัสพนักงาน</th>
                <th>ชื่อผู้ใช้</th>
                <th>สิทธิ์การใช้งาน</th>
                <th>เปลี่ยนสิทธิ์</th>
                <th>รีเซ็ตรหัสผ่าน</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row["Em_id"]; ?></td>
                    <td><?php echo $row["Username"]; ?></td>
                    <td><?php echo $row["Role"]; ?></td>
                    <td>
                        <form action="update_role.php" method="POST">
                            <input type="hidden" name="em_id" value="<?php echo $row["Em_id"]; ?>">
                            <select name="new_role">
                                <option value="Employee" <?php if ($row["Role"] == "Employee") echo "selected"; ?>>Employee</option>
                                <option value="HR" <?php if ($row["Role"] == "HR") echo "selected"; ?>>HR</option>
                                <option value="Admin" <?php if ($row["Role"] == "Admin") echo "selected"; ?>>Admin</option>
                            </select>
                            <button type="submit" class="btn btn-warning btn-sm">อัปเดต</button>
                        </form>
                    </td>
                    <td>
                        <form action="reset_password.php" method="POST">
                            <input type="hidden" name="em_id" value="<?php echo $row["Em_id"]; ?>">
                            <button type="submit" class="btn btn-danger btn-sm">🔑 รีเซ็ตรหัสผ่าน</button>
                        </form>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

</div>

</body>
</html>

<?php $conn->close(); ?>
