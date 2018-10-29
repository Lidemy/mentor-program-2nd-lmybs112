<?php
//添加留言
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 驗證非空
    if (!empty($_POST['message'])) {

        // 取值
        $parent_id = $_POST['parent_id'];
        $message = $_POST['message'];
        $check = $_COOKIE["check"];

        // 連接數據庫
        require_once 'conn.php';

        // 驗證身份
        $check_certificate = $conn->prepare("SELECT account FROM lmybs112_users_certificate where certificate = ?");
        $check_certificate->bind_param("s", $check);
        $check_certificate->execute();
        $res_certificate = $check_certificate->get_result();
        if (!$res_certificate) {
            exit('查詢數據失敗');
        }
        $row = $res_certificate->fetch_assoc();
        $user_id = $row['account'];
        // 新增數據
        $add_mes = $conn->prepare("INSERT INTO `lmybs112_comments`(parent_id, user_id, message) VALUES (?,?,?)");
        $add_mes->bind_param("sss", $parent_id, $user_id, $message);
        $add_mes->execute();
        $last_id = $conn->insert_id;
        if (!$add_mes) {
            exit('添加數據失敗');
        }
    }
    if ($parent_id === '0') {
        $arr = array('result' => 'success', 'id' => $last_id);
        echo json_encode($arr);
    }else{
        header('Location:index.php');
    }
}
