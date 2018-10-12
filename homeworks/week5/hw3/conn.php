<?php
$servername = "";
$username = "";
$passwords = "";
$dbname = "";

// 連接數據庫
$conn = new mysqli($servername, $username, $passwords, $dbname);
// 判斷是否連接成功
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// 設置編碼
mysqli_set_charset($conn, 'utf8');
