<?php
$servername = "localhost";
$username = "root"; // เปลี่ยนตามเครื่องที่ใช้
$password = "";
$dbname = "hrms";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . $conn->connect_error);
}
?>
