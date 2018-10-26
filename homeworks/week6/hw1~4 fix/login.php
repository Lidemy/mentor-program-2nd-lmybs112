<?php
$err_msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 驗證非空
    if (empty($_POST['account']) && empty($_POST['password'])) {
      $err_msg = '請輸入帳號及密碼';
    }else{
      $err_msg = '請輸入';
      if (empty($_POST['account'])) {
        $err_msg .= '帳號';
    }
    if (empty($_POST['password'])) {
        $err_msg .= '密碼';
    }
    }

    // 取值
    if (!empty($_POST['account']) && !empty($_POST['password'])) {
        $account = $_POST['account'];
        $password = $_POST['password'];
        $is_login = false;

        // 連接數據庫
        require_once 'conn.php';

        // 查詢數據
        $login = $conn->prepare("SELECT * FROM lmybs112_users WHERE account=?");
        $login->bind_param("s", $account);
        $login->execute();
        $result = $login->get_result();
        if (!$result) {
            exit('查詢數據失敗');
        }
        $row = $result->fetch_assoc();
        if ($row > 0 && password_verify($password, $row['password'])) {
            // 儲存登入狀態
            $is_login = true;
            $check_certificate = $conn->prepare("SELECT * FROM lmybs112_users_certificate WHERE account = ?");
            $check_certificate->bind_param("s", $account);
            $check_certificate->execute();
            $res_certificate = $check_certificate->get_result();
            //每次重新登入更新 certificate
            if ($res_certificate->num_rows > 0) {
                $certificate = uniqid();
                $set_certificate = $conn->prepare("UPDATE lmybs112_users_certificate SET certificate = ? WHERE account = ?");
                $set_certificate->bind_param('ss', $certificate, $account);
                $set_certificate->execute();
                setcookie('check', $certificate, time() + 1 * 24 * 60 * 60);
            }
            setcookie('login', $is_login, time() + 1 * 24 * 60 * 60);
            // 響應頁面
            header('location: index.php');
        } else {
            $err_msg = '登入失敗，請重新登入或註冊會員!';
        }
    }
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
    height:100vh;
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
  }
  .member{
    background-color:#F2F5F7;
    display:flex;
    justify-content:center;
    padding:1.25rem 0;
  }
  #login-form{
    background-color: #fff;
    box-shadow: 0 0 .0625rem .0625rem silver;
    width:90%;
    display:flex;
    flex-direction:column;
    align-items:center;
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
    padding: .3125rem;
  }
  .submit{
    padding: .3125rem 1.875rem;
    margin-bottom:.625rem;
  }
  .click_join,.click_join:link,.click_join:visited{
    font-weight:normal;
    color:black;
    text-decoration: none;
  }
  .alert{
    color:red;
  }

</style>

<body>
  <div class="container">
    <nav class=nav>
      <a href="index.php"><h1>簡易留言板 </h1></a>
      <div class="btn">
        <a href="index.php" class="index"><button>回首頁</button></a>
        <a href="join.php" class="login"><button>註冊</button></a>
      </div>
    </nav>
    <main class="member">
    <form action="" method="post" id="login-form">
      <h2 class="form-title">登入會員</h2>

      <!-- 提示錯誤訊息 -->
      <?php if (!empty($err_msg)): ?>
        <div class="alert">
        <?php echo $err_msg; ?>
        </div>
        <?php endif?>

      <div class="form-group">
        <label for="account">帳號：</label>
        <input type="text" id="account" name="account"placeholder="請輸入帳號"
        value="<?php echo isset($_POST['account']) ? $_POST['account'] : '' ?>">
      </div>
      <div class="form-group">
        <label for="password">密碼：</label>
        <input type="password" id="password" name="password"placeholder="請輸入密碼">
      </div>
      <button class="submit">登入</button>
      <h4><a href="join.php" class="click_join">還不是會員嗎？<strong>點我註冊</strong></a></h4>
    </form>
    </main>
  </div>
</body>

</html>