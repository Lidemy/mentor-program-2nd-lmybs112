<?php
//添加留言

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 驗證非空
    if (empty($_POST['message'])) {
        $GLOBALS['error_message'] = '請輸入留言內容';
        return;
    }
    // 取值
    $parent_id = $_POST['parent_id'];
    $message = $_POST['message'];
    $check = $_COOKIE["check"];

    // 連接數據庫
    require_once 'conn.php';
    $stmt = $conn->prepare("SELECT account FROM lmybs112_users_certificate where certificate = ?");
    $stmt->bind_param("s", $check);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $user_id = $row['account'];
    header('Location:index.php');
    // 新增數據
    $add_mes = $conn->prepare("INSERT INTO `lmybs112_comments`(parent_id, user_id, message) VALUES (?,?,?)");
    $add_mes->bind_param("sss", $parent_id, $user_id, $message);
    $add_mes->execute();
    $result = $add_mes->get_result();
    //響應頁面
    header('Location:index.php');
    if (!$result) {
        $GLOBALS['error_message'] = "查詢數據失敗";
        return;
    }
}
