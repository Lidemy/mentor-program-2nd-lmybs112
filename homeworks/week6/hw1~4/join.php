<?php

// 初始化session
session_start();

// 註冊會員
function add_user()
{
    // 驗證非空
    if (empty($_POST['nickname'])) {
        $GLOBALS['error_message'] = '請輸入暱稱';
        return;
    }
    if (empty($_POST['account'])) {
        $GLOBALS['error_message'] = '請輸入帳號';
        return;
    }
    if (empty($_POST['password'])) {
        $GLOBALS['error_message'] = '請輸入密碼';
        return;
    }
    // 取值
    $is_login = false;
    $nickname = $_POST['nickname'];
    $account = $_POST['account'];
    $password = $_POST['password'];

    // 密碼加密
    $hash = password_hash($password, PASSWORD_DEFAULT, ['cost' => 11]);

    // 連接數據庫
    require_once 'conn.php';

    // 查詢數據
    $join = $conn->prepare("INSERT INTO lmybs112_users(id, nickname, account, password) VALUES (?,?,?,?)");
    $id=null;
    $join->bind_param('ssss',$id,$nickname,$account,$hash);
    $join->execute();

    if (!$join) {
        $GLOBALS['error_message'] = "查詢數據失敗";
        return;
    } else {
        // 註冊成功後自動登入
        $last_id = $conn->insert_id;
        $_SESSION["user_id"]=$last_id;
        // 儲存登入狀態
        $is_login=true;
        setcookie('login', $is_login, time() + 1 * 24 * 60 * 60);
    }

    // 響應頁面
    header('location: index.php');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add_user();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>簡易留言板</title>
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body{
    background:url("bg.jpg") center center;
    background-size: cover;
  }
  a,a:link,a:visited{
  color:white;
  text-decoration: none;
  }
  .container {
    max-width: 60rem;
    height: 100vh;
    margin: 0 auto;
    padding: 3.125rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
  }

  .nav {
    width: 100%;
    z-index: 1;
    background-color: #3F9FE3;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: .625rem;
    border-radius:.3125rem;
  }
  .nav>h1{
    color:white;
  }
  .btn{
    display: flex;
    justify-content: flex-end;
    display: flex;
  }
  button{
    color: white;
    font-size: 1rem;
    background-color: #3F9FE3;
    border:none;
    padding: .3125rem .625rem;
    margin: .3125rem 0;
  }
  .member{
    background-color:#F2F5F7;
    display:flex;
    justify-content:center;
    padding:1.25rem 0;
  }
  #join-form{
    background-color: #fff;
    box-shadow: 0 0 .0625rem .0625rem silver;
    width: 90%;
    display:flex;
    flex-direction:column;
    align-items:center;
    border-radius: .3125rem;
    padding:.625rem 0;
  }
  .form-group{
    color: #3F9FE3;
    font-size: 1.125rem;
    padding:.625rem 0;
  }
  .form-group>input{
    font-size: 1.125rem;
  }
  .form-title{
    color: #3F9FE3;
    padding: .3125rem
  }
  .submit{
    padding: .3125rem 1.875rem;
  }
  .alert{
    color:red;
  }
  .click_join,.click_join:link,.click_join:visited{
    color:black;
    text-decoration: none;
  }
</style>

<body>
  <div class="container">
    <nav class=nav>
      <a href="index.php">
        <h1>簡易留言板</h1>
      </a>
      <div class="btn">
        <a href="index.php" class="index"><button>回首頁</button></a>
        <a href="login.php" class="login"><button>登入</button></a>
      </div>
    </nav>
    <main class="member">
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="join-form" autocomplete="off">
        <h2 class="form-title">註冊成為會員</h2>

        <?php if (isset($error_message)): ?>
        <div class="alert">
        <?php echo $error_message; ?>
        </div>
        <?php endif?>

        <div class="form-group">
            <label for="nickname">暱稱：</label>
            <input type="text" id="nickname" name="nickname" placeholder="請輸入暱稱"
            value="<?php echo isset($_POST['nickname']) ? $_POST['nickname'] : '' ?>">
          </div>
        <div class="form-group">
          <label for="account">帳號：</label>
          <input type="text" id="account" name="account" placeholder="請輸入帳號"
          value="<?php echo isset($_POST['account']) ? $_POST['account'] : '' ?>">
        </div>
        <div class="form-group">
          <label for="password">密碼：</label>
          <input type="password" id="password" name="password" placeholder="請輸入密碼">
        </div>
        <button class="submit">註冊</button>
        <h4><a href="login.php" class="click_join">已有會員點我登入</a></h4>
      </form>
    </main>
  </div>
</body>

</html>