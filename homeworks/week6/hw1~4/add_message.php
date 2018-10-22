<?php
// 初始化session
session_start();
function add_message()
{
    // 驗證非空
    if (empty($_POST['message'])) {
        $GLOBALS['error_message'] = '請輸入留言內容';
        return;
    }

    // 取值
    $parent_id = $_POST['parent_id'];
    $message = $_POST['message'];
    $user_id = $_SESSION["user_id"];

    // 連接數據庫
    require_once 'conn.php';

    // 新增數據
    $add_mes = $conn->prepare("INSERT INTO `lmybs112_comments`(parent_id, user_id, message) VALUES (?,?,?)");
    $add_mes->bind_param("sss", $parent_id, $user_id, $message);
    $add_mes->execute();
    $result = $add_mes->get_result();

    if (!$result) {
        $GLOBALS['error_message'] = "查詢數據失敗";
        return;
    }

    $row = array();
    if (!$result->fetch()) {
        $row = array('error' => '上傳數據失敗');
    }
}


function edit_message()
{
    // 驗證非空
    $edit_message = empty($_POST['message']) ? $edit['message'] : $_POST['message'];

    // 連接數據庫
    require_once 'conn.php';

    // 查詢數據
    $edit = $conn->prepare("UPDATE lmybs112_comments SET message =? WHERE id =?");
    $edit->bind_param('si', $edit_message, $id);
    $edit->execute();

    if (!$edit) {
        $GLOBALS['error_message'] = "查詢數據失敗";
        return;
    }
}

// 發送留言
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($_GET['id'])) {
        add_message();
}

//響應頁面
header('location: index.php');
}