<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard - ระบบจัดการพนักงาน</title>
    
    <!-- Bootstrap & FontAwesome -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        body {
            display: flex;
            height: 100vh;
            overflow: hidden;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            background-color: #343a40;
            color: white;
            position: fixed;
            left: 0;
            top: 0;
            padding: 20px;
            transition: 0.3s;
        }
        .sidebar a {
            display: block;
            color: white;
            padding: 10px;
            text-decoration: none;
            border-radius: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin-left: 250px;
            transition: 0.3s;
            width: 100%;
        }
        .sidebar.hidden {
            margin-left: -260px;
        }
        .content.full-width {
            margin-left: 0;
        }
        .toggle-btn {
            position: absolute;
            top: 15px;
            left: 220px;
            cursor: pointer;
            color: white;
            background: #343a40;
            border: none;
            padding: 10px;
            border-radius: 5px;
            transition: 0.3s;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    <h4 class="text-center">เมนู</h4>
    <a href="dashboard.php">
        <i class="fa fa-home"></i> หน้าหลัก
    </a>
    <?php if ($_SESSION["Role"] == "Admin") { ?>
    <a href="manage_users.php"> <i class="fa fa-user"></i> จัดการผู้ใช้</a>
<?php } ?>
    <?php if ($_SESSION["Role"] == "Admin" || $_SESSION["Role"] == "HR") { ?>
        <a href="leave.php">
            <i class="fa fa-calendar-check"></i> จัดการการลา
        </a>
        <a href="manage_employee.php">
            <i class="fa-solid fa-users-gear"></i> จัดการพนักงาน
        </a>
        <a href="add_employee.php">
            <i class="fa fa-user-plus"></i> เพิ่มพนักงาน
        </a>
        <a href="manage_department.php">
            <i class="fa fa-tasks"></i> จัดการแผนก
        </a>
        <a href="add_department.php">
            <i class="fa fa-tasks"></i> เพิ่มแผนก
        </a>
    <?php } ?>
    
    <a href="attendance.php">
        <i class="fa fa-clock"></i> บันทึกเวลาเข้า-ออก
    </a>
    <a href="change_password.php">
        <i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน
    </a>
    <a href="logout.php" class="text-danger">
        <i class="fa fa-sign-out-alt"></i> ออกจากระบบ
    </a>
</div>

<!-- Content -->
<div class="content" id="content">
    <button class="toggle-btn" id="toggleSidebar">
        <i class="fa fa-bars"></i>
    </button>

<!-- JavaScript -->
<script>
    document.getElementById("toggleSidebar").addEventListener("click", function () {
        var sidebar = document.getElementById("sidebar");
        var content = document.getElementById("content");

        if (sidebar.classList.contains("hidden")) {
            sidebar.classList.remove("hidden");
            content.classList.remove("full-width");
        } else {
            sidebar.classList.add("hidden");
            content.classList.add("full-width");
        }
    });
</script>
</div>
</body>
</html>

