<?php
session_start();
require 'db.php';

if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

$dept_id = $_GET["id"];
$conn->query("DELETE FROM department WHERE Dept_id = '$dept_id'");
header("Location: manage_department.php");
exit();
?>
