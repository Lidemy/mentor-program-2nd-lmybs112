<?php
// 刪除cookie
setcookie('user_id', '', time() + 1 * 24 * 60 * 60);
// 響應頁面
header('location: index.php');
