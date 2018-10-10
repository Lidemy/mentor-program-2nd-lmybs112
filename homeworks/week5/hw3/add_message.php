<?php
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
    $user_id = $_COOKIE['user_id'];

    // var_dump($parent_id);
    // var_dump($message);
    // var_dump($create_at);

    // 連接數據庫
    require_once 'conn.php';

    // 查詢數據
    $query = mysqli_query($conn, "INSERT INTO `lmybs112_comments`(`parent_id`, `user_id`, `message`) VALUES ({$parent_id},{$user_id},'{$message}')");

    if (!$query) {
        $GLOBALS['error_message'] = "查詢數據失敗";
        return;
    }
    $affected_rows = mysqli_affected_rows($conn);
    if ($affected_rows !== 1) {
        $GLOBALS['error_message'] = "上傳數據失敗";
        return;
    }
    //響應頁面
    header('location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_message();
}
