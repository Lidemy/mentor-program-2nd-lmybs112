<?php

// 啟用 session
session_start();

// 驗證非空
if (empty($_GET['id'])) {
    exit('<h1>找不到刪除對象</h1>');
}

// 連接數據庫
require_once 'conn.php';

// 取值
$id = $_GET['id'];

// 判斷登入對象
$user = $conn->prepare("SELECT user_id FROM `lmybs112_comments` WHERE `id`=?");
$user->bind_param('i', $id);
$user->execute();
$account = $user->get_result()->fetch_assoc()['user_id'];

if ($account === $_SESSION['account']) {
// 刪除數據
    $del = $conn->prepare("DELETE FROM lmybs112_comments WHERE id=?");
    $del->bind_param('i', $id);
    $del->execute();
    if (!$del) {
        exit('<h1>刪除數據失敗</h1>');
    }
} else {
    exit('<h1>刪除數據失敗</h1>');
}
header('Location:index.php');
