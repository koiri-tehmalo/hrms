<?php
session_start();
session_destroy(); // ลบ session
header("Location: login.php"); // กลับไปหน้า Login
exit();
?>
