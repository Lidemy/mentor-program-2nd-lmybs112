<?php
if (empty($_GET['id'])) {
    exit('<h1>找不到刪除對象</h1>');
}

// 連接數據庫
include_once 'conn.php';

// 刪除數據
$id = $_GET['id'];
$del = $conn->prepare("DELETE FROM lmybs112_comments WHERE id=?");
$del->bind_param('i', $id);
$del->execute();
$del->bind_result();
$row = array();
if (!$del->fetch()) {
    $row = array('error' => '刪除數據失敗');
}
header('Location:index.php');
