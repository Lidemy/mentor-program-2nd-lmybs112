<?php

// 啟用 session
session_start();

//添加留言
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 驗證非空
    if (!empty($_POST['message'])) {

        // 取值
        $parent_id = $_POST['parent_id'];
        $message = $_POST['message'];

        // 連接數據庫
        require_once 'conn.php';

        // 新增數據
        $add_mes = $conn->prepare("INSERT INTO `lmybs112_comments`(parent_id, user_id, message) VALUES (?,?,?)");
        $add_mes->bind_param("sss", $parent_id, $_SESSION["account"], $message);
        $add_mes->execute();
        $last_id = $conn->insert_id;
        if (!$add_mes) {
            exit('添加數據失敗');
        }
        // 取得創建時間
        $time = $conn->prepare("SELECT create_at FROM lmybs112_comments WHERE id = ?");
        $time->bind_param('s', $last_id);
        $time->execute();
        $create_at = $time->get_result()->fetch_assoc()['create_at'];

    }
    if ($parent_id === '0') {
        $arr = array('result' => 'success', 'id' => $last_id, 'create_at' => $create_at, 'user_id' => $_SESSION["account"]);
        echo json_encode($arr);
    } else {
        header('Location:index.php');
    }
}
