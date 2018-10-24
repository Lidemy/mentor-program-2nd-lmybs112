<?php
$err_mes = 0;
$name = '';
$acc = '';
$pas = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // 驗證非空
    if (empty($_POST['nickname'])) {
        $err_mes++;
        $name = '暱稱';
    }
    if (empty($_POST['account'])) {
        $err_mes++;
        $acc = '帳號';
    }
    if (empty($_POST['password'])) {
        $err_mes++;
        $pas = '密碼';
    }
    if (!empty($_POST['nickname']) && !empty($_POST['account']) && !empty($_POST['password'])) {
        // 取值
        $nickname = $_POST['nickname'];
        $account = $_POST['account'];
        $password = $_POST['password'];
        $is_login = false;

        // 密碼加密
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // 連接數據庫
        require_once 'conn.php';

        // 判斷是否註冊過
        $check_acc = $conn->prepare("SELECT * FROM lmybs112_users WHERE account=?");
        $check_acc->bind_param("s", $account);
        $check_acc->execute();
        $res_acc = $check_acc->get_result();
        if (!$res_acc) {
            exit('查詢數據失敗');
        }
        $row = $res_acc->fetch_assoc();
        if ($row>1) {
          echo "<script> alert('註冊失敗，此帳號已存在!'); location.href = 'join.php'</script>";
          exit();
      }

        // 增加數據
        $join = $conn->prepare("INSERT INTO lmybs112_users(id, nickname, account, password) VALUES (?,?,?,?)");
        $id = null;
        $join->bind_param('ssss', $id, $nickname, $account, $hash);
        $join->execute();

        if (!$join) {
            exit('增加數據失敗');
        } else {
            // 註冊成功後自動登入
            $last_id = $conn->insert_id;
            $_COOKIE["check"] = $last_id;
            $is_login = true;

            // 增加身份驗證
            $certificate = uniqid();
            $add_certificate = $conn->prepare("INSERT INTO lmybs112_users_certificate(certificate,account) VALUES(?,?)");
            $add_certificate->bind_param('ss', $certificate, $account);
            $add_certificate->execute();
            setcookie('check', $certificate, time() + 1 * 24 * 60 * 60);
            setcookie('login', $is_login, time() + 1 * 24 * 60 * 60);
            // 響應頁面
            header('location: index.php');
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

        <?php if ($err_mes === 3): ?>
        <div class="alert">
        <?php echo "請輸入以下資料"; ?>
        </div>
        <?php elseif ($err_mes > 0 && $err_mes===2): ?>
        <div class="alert">
        <?php if ($name): ?>
        <?php echo "請輸入". $name . "及" . $acc,$pas; ?>
        <?php else:?>
        <?php echo "請輸入". $acc . "及" . $pas; ?>
        <?php endif?>
        </div>
        <?php elseif ($err_mes > 0 && $err_mes===1): ?>
        <div class="alert">
        <?php echo "請輸入".$name,$acc,$pas; ?>
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