<?php

// 判斷是否登入
$is_login = false;
$user_id = '';
if (isset($_COOKIE["user_id"]) && !empty($_COOKIE["user_id"])) {
    $is_login = true;
    $user_id = $_COOKIE["user_id"];
}
// 連接數據庫
require_once 'conn.php';

// 查詢數據
$query = mysqli_query($conn, "SELECT lmybs112_comments.id,lmybs112_comments.message,lmybs112_comments.create_at,lmybs112_users.nickname FROM lmybs112_comments left join lmybs112_users on lmybs112_comments.user_id=lmybs112_users.id WHERE parent_id=0 order by create_at DESC;");

if (!$query) {
    exit("查詢數據失敗");
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
    /* outline: .0625rem solid red; */
  }
  body{
    background:url("bg.jpg") no-repeat center center;
    background-size: cover;
    background-attachment: fixed;
  }
  a,a:link,a:visited{
  color:white;
  text-decoration: none;
  }

  .container {
    max-width: 60rem;
    margin: 0 auto;
    padding: 3.125rem;
    display: flex;
    flex-direction: column;
    /* background-color: azure; */
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
  }
  .btn button{
    border:none;
    padding: .3125rem .625rem;
  }

  .board {
    background-color: #F2F2F2;
  }
  .board-res{
    margin-top: 1.25rem;
  }

  .title {
    padding: 1.25rem 0 0 1.25rem;
  }

  .content {
    margin: 1.25rem;
    padding: .625rem;
    background-color: white;
  }

  .content_info {
    width: 100%;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
  }

  .name {
    font-size: 1.25rem;
    color: #3F9FE3;
  }

  .date {
    font-size: 1rem;
  }

  .content_message {
    width: 100%;
    display: flex;
    justify-content: center;
    margin-top: .625rem;
  }

  textarea {
    padding: .625rem;
    font-size: 1rem;
    width: 100%;
    resize: none;
  }

  .button {
    width: 100%;
    display: flex;
    justify-content: flex-end;
    padding-top: .625rem;
  }

  button {
    color: white;
    font-size: 1rem;
    background-color: #3F9FE3;
    padding: .625rem 3.125rem;
  }

  .content-child {
    display: flex;
    justify-content:space-between;
  }

  .aside {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .info-child {
    padding-left: .625rem;
    display: flex;
    justify-content: space-between;
  }

  .main {
    display: flex;
    flex-direction: column;
  }

  .main-child {
    width:100%;
    padding: .625rem;
  }
  .date{
  font-size:12px;
  }
  .show {
    margin-left: .625rem;
    padding: .625rem 0;
  }
  .line{
    border-bottom: 1px solid #ccc;
  }

  .message-child {
    padding: .625rem;
    background-color: #F2F5F7;
    display: flex;
    flex-direction: column;
  }

  .content-child-mes {
    display: flex;
    flex-direction: column;
    margin: 0;
    padding: 0;
    background-color: #F2F5F7;
  }
</style>

<body>
  <div class="container">
  <!-- 導覽列 -->
    <nav class=nav>
      <a href="index.php"><h1>簡易留言板</h1></a>
      <div class="btn">
      <?php if (!$is_login): ?>
      <a href="join.php" class="join"><button>註冊</button></a>
        <a href="login.php" class="login"><button>登入</button></a>
      <?php else: ?>
      <a href="logout.php" class="logout"><button>登出</button></a>
    <?php endif?>
      </div>
    </nav>

    <!-- 我要留言 -->
    <div class="board">
      <h3 class="title">我要留言</h3>
      <form action="add_message.php" class="content" method="post">
        <!-- <div class="content_info">
          <input type="text" name="nickname" placeholder="請輸入暱稱">
        </div> -->
        <div class="content_message">
          <textarea name="message" id="textarea" cols="100" rows="10" placeholder="請輸入留言內容"></textarea>
        </div>
        <input type="hidden" name="parent_id" value="0">
        <div class="button">
        <?php if ($is_login): ?>
          <button>留言</button>
          <?php else: ?>
          <button disabled>登入後留言</button>
          <?php endif?>
        </div>
      </form>
    </div>

    <!-- 輸出下方留言 -->
  <?while ($item = mysqli_fetch_assoc($query)): ?>
    <div class="board board-res">
      <div class="content content-child">
        <div class="aside">
          <span>▲</span>
          <span>0</span>
        </div>
        <div class="main">
          <div class="content_info info-child">
            <h3 class="name">
              <?echo $item['nickname'] ?>
            </h3>
            <h3 class="date">
              <?echo $item['create_at'] ?>
            </h3>
          </div>
          <div class="show">
            <?echo htmlspecialchars($item['message']) ?>
          </div>


          <?// 查詢數據
$parent_id = $item['id'];
$query_child = mysqli_query($conn, "SELECT lmybs112_comments.id,lmybs112_comments.message,lmybs112_comments.create_at,lmybs112_users.nickname FROM lmybs112_comments left join lmybs112_users on lmybs112_comments.user_id=lmybs112_users.id WHERE parent_id={$parent_id} order by create_at ASC;");
if (!$query_child) {
    exit("查詢數據失敗");
}?>

          <div class="content_message message-child">
            <div class="content content-child content-child-mes">
            <!-- 顯示子留言 -->
            <?while ($item_child = mysqli_fetch_assoc($query_child)): ?>
              <div class="main main-child">
                <div class="content_info info-child line">
                  <h3 class="name">
                    <?echo $item_child['nickname'] ?>
                  </h3>
                  <h3 class="date">
                    <?echo $item_child['create_at'] ?>
                  </h3>
                </div>
                <div class="show">
                  <?echo htmlspecialchars ($item_child['message']) ?>
                </div>
              </div>

              <?endwhile?>
            </div>
            <!-- 回覆留言 -->
            <form class="main main-child" action="add_message.php" method="post">
              <!-- <div class="content_info info-child">
                <input type="text" name="nickname" placeholder="請輸入暱稱">
              </div> -->
              <div class="content_message">
                <textarea name="message" cols="100" rows="5" placeholder="回覆此留言"></textarea>
              </div>
              <input type="hidden" name="parent_id" value="<?echo $item['id'] ?>">
              <div class="button">

              <?php if ($is_login): ?>
                <button>回應</button>
              <?php else: ?>
                <button disabled>登入後回應</button>
              <?php endif?>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  <?endwhile?>
  </div>
</body>
</html>