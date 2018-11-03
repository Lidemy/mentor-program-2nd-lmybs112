<?php
// 啟用 session
session_start();

// 刪除cookie
setcookie('login', '', time() - 1 * 24 * 60 * 60);

// 刪除 session
session_destroy();

// 響應頁面
header('location: index.php');
