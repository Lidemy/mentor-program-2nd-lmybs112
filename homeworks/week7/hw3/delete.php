<?php
// 驗證非空
if (empty($_GET['id'])) {
    exit('<h1>找不到刪除對象</h1>');
}

// 連接數據庫
require_once 'conn.php';

// 取值
$id = $_GET['id'];

// 刪除數據
$del = $conn->prepare("DELETE FROM lmybs112_comments WHERE id=?");
$del->bind_param('i', $id);
$del->execute();
if (!$del) {
    exit('<h1>刪除數據失敗</h1>');
}

header('Location:index.php');