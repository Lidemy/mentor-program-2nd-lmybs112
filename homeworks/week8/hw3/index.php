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

// 設置時間
$conn->query("set time_zone = '+8:00'");

// 設置編碼
mysqli_set_charset($conn, 'utf8');

$conn->autocommit(FALSE);
$conn->begin_transaction();
$sel_product = $conn->prepare("SELECT amount,id FROM lmybs112_products for update");
$sel_product->execute();
$result = $sel_product->get_result();
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo "amount：". $row["amount"];
    if ($row["amount"] > 0) {
      $buy_product = $conn->prepare("UPDATE lmybs112_products SET amount=amount-1 WHERE id=1");
      if ($buy_product->execute()){
        echo "購買成功";
      }
    }
}
$conn->commit();