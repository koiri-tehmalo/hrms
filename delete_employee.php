<?php
session_start();
require 'db.php';

if (!isset($_SESSION["Username"]) || ($_SESSION["Role"] != 'Admin' && $_SESSION["Role"] != 'HR')) {
    header("Location: dashboard.php");
    exit();
}

$em_id = $_GET["id"];
$conn->query("DELETE FROM Employee WHERE Em_id = '$em_id'");
header("Location: manage_employee.php");
exit();
?>
