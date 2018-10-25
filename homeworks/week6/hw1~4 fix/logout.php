<?php
// 刪除cookie
setcookie('login', '', time() - 1 * 24 * 60 * 60);
setcookie('check', '', time() - 1 * 24 * 60 * 60);

// 響應頁面
header('location: index.php');
