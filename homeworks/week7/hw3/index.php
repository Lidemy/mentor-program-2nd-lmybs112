<?php

// 連接數據庫
require_once 'conn.php';

// 判斷是否登入
$is_login = false;
$account = '';
$nickname = '';
if (isset($_COOKIE["check"]) && !empty($_COOKIE["check"])) {
    $is_login = true;
    $certificate = $_COOKIE['check'];
    $check = $conn->prepare("SELECT account FROM lmybs112_users_certificate WHERE certificate = ?");
    $check->bind_param('s', $certificate);
    $check->execute();
    $account = $check->get_result()->fetch_assoc()['account'];
}

// 分頁
$page = empty($_GET['page']) ? 1 : (int) $_GET['page'];
$page_size = 10;
$offset = ($page - 1) * $page_size;

// 查詢數據 分頁
$stmt = $conn->prepare("SELECT lmybs112_comments.id,lmybs112_comments.message,lmybs112_comments.create_at,lmybs112_users.nickname FROM lmybs112_comments left join lmybs112_users on lmybs112_comments.user_id=lmybs112_users.account WHERE parent_id=? order by create_at DESC LIMIT ?,?");
$parent_id = 0;
$stmt->bind_param('iii', $parent_id, $offset, $page_size);
$stmt->execute();
$query = $stmt->get_result();
if (!$query) {
    exit("查詢數據失敗");
}

// 查詢數據 留言總數
$count = $conn->prepare("SELECT lmybs112_comments.id,lmybs112_comments.message,lmybs112_comments.create_at,lmybs112_users.nickname FROM lmybs112_comments left join lmybs112_users on lmybs112_comments.user_id=lmybs112_users.account WHERE parent_id=? order by create_at DESC");
$count->bind_param('i', $parent_id);
$count->execute();
$count_pages = $count->get_result();
if (!$count_pages) {
    exit("查詢數據失敗");
}
$nickname = $count_pages->fetch_assoc()['nickname'];
$id = $count_pages->fetch_assoc()['id'];

// 計算頁碼
$total = $count_pages->num_rows;
$end = ceil($total / 10);
$begin = 1;

// 查詢可編輯數據
if (!empty($_GET['id'])) {
    $edit = $conn->prepare("SELECT * FROM lmybs112_comments WHERE id =?");
    $edit->bind_param('i', $_GET['id']);
    $edit->execute();
    $edit_res = $edit->get_result();
    if (!$edit_res) {
        exit("查詢數據失敗");
    }
} else {
// 查詢可刪除數據
    $del = $conn->prepare("SELECT * FROM lmybs112_comments WHERE user_id =?");
    $del->bind_param('i', $account);
    $del->execute();
    $de_result = $del->get_result();
    if (!$de_result) {
        exit("查詢數據失敗");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <!-- fontawesome -->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz"
    crossorigin="anonymous">
  <!-- bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB"
    crossorigin="anonymous">
  <title>簡易留言板</title>
</head>
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }
  body{
    background:url("blurry-bg.jpg") no-repeat center center;
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
    cursor:pointer;
  }

  .board {
    background-color: #F2F2F2;
  }
  .board-res{
    padding:.625rem 0;
    margin-top:1.25rem;
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
    display: flex;
    justify-content: space-between;
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
  .modify{
    text-align:right;
    padding:5px;
  }
  .modify>a{
    color:#ccc;
  }
  .modify>a:hover{
    color:#ea0000;
  }
  i{
    padding:0 1rem;
  }
  table{
    font-size:1.2rem;
    padding:.325rem 0;
    background-color: #3F9FE3;
    color:#fff;
  }
  td{
    padding:0 .325rem;
  }
    @media screen and (max-width: 1024px) {
    .fa-arrow-alt-circle-up {
    display:none;
    }
  }
  .fa-arrow-alt-circle-up{
  position: fixed;
  font-size:3rem;
  bottom: 150px;
  right:0;
  margin-right:14rem;
  color:#191970;
  opacity:0.8;
  }
  .page{
    text-align:center;
  }
  .show_self+.show{
    width:98%;
    height:100%;
    background-color: #87CEFA;
    opacity:0.8;
    padding-left:5px;
    box-shadow: 0px 0px 3px 3px #87CEFA;
  }
  .active>a{
    background-color:white;
    color:#3F9FE3;
    font-size:1.325rem;
    padding:0 3px;
    border-radius:5px;
  }
  .hidden{
    display:none;
  }
  .showNickname{
    color:white;
    padding:0 5px;
  }
</style>

<body>
  <!-- 留言板 -->
  <div class="container" id="top">
    <!-- 留言板-導覽列 -->
    <nav class="nav">
      <a href="index.php">
        <h1><i class="far fa-comments"></i>簡易留言板</h1>
      </a>
      <div class="btn">
        <!-- 判斷是否登入 -->
        <?php if (!$is_login): ?>
        <a href="join.php" class="join"><button>註冊</button></a>
        <a href="login.php" class="login"><button>登入</button></a>
        <?php else: ?>
        <h6 id="check_cer" class="hidden"><?php echo $certificate ?></h6>
        <h4 class="showNickname">Hi~ <?php echo ($nickname) ?></h4>
        <a href="logout.php" class="logout"><button>登出</button></a>
        <?php endif?>
      </div>
    </nav>

    <!-- 留言板-留言內容 -->

    <!-- 判斷要新增留言 or 修改留言 -->
    <?php if (isset($edit_res)): ?>
    <!-- 留言板-留言內容-我要修改 -->
    <div class="board">
      <h3 class="title">我要修改<i class="fas fa-user-edit"></i></h3>
      <?php while ($ed = $edit_res->fetch_assoc()): ?>
      <form action="edit.php?id=<?php echo $ed['id'] ?>" class="content" method="post">
        <div class="content_message">
          <textarea name="message" id="textarea" cols="100" rows="10" placeholder="請輸入修改內容"><?php echo $ed['message'] ?></textarea>
        </div>
        <input type="hidden" name="parent_id" value="0">
        <div class="button">
          <button>修改</button>
        </div>
      </form>
      <?endwhile?>
    </div>

    <?php else: ?>

    <!-- 留言板-留言內容-我要留言 -->
    <div class="board">
      <h3 class="title"id="nickname"><?php echo ($nickname) ?><i class="fas fa-bullhorn"></i></h3>
      <form action="add_message.php" class="content" id="main_mes" method="post">
        <div class="content_message">
          <textarea name="message" id="sendMessage" cols="100" rows="10" placeholder="請輸入留言內容"></textarea>
        </div>
        <input type="hidden" name="parent_id" value="0">
        <div class="button">

          <!-- 判斷是否登入 -->
          <?php if ($is_login): ?>
          <button class="send">留言</button>
          <?php else: ?>
          <button disabled>登入後留言</button>
          <?php endif?>
        </div>
      </form>
    </div>



    <!-- 輸出下方留言 -->
    <?while ($item = $query->fetch_assoc()): ?>
    <div class="showMessage">
    <div class="board board-res">
      <div class="content content-child">
        <div class="aside">
          <span>▲</span>
          <span>0</span>
        </div>
        <div class="main main-res">
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
            <!-- 判斷是否顯示編輯＆刪除功能 -->
            <?php if ($is_login): ?>
            <?foreach ($de_result as $com): ?>
            <?php if ($com['id'] == $item['id'] && $com['user_id'] == $account): ?>

            <div class="modify">
              <a href="index.php?id=<?php echo $item['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
              <a href="delete.php?id=<?php echo $item['id'] ?>" class="delete__mes" data-id="<?php echo $item['id'] ?>"><i
                  class="fas fa-trash-alt"></i></a>
            </div>

            <?php endif?>
            <?php endforeach?>
            <?php endif?>
          </div>

          <?// 查詢子留言數據
$child = $conn->prepare("SELECT lmybs112_comments.id,lmybs112_comments.message,lmybs112_comments.create_at,lmybs112_users.nickname FROM lmybs112_comments left join lmybs112_users on lmybs112_comments.user_id=lmybs112_users.account WHERE parent_id=? order by create_at ASC;");

$parent_id = $item['id'];
$child->bind_param('i', $parent_id);
$child->execute();
$query_child = $child->get_result();
if (!$query_child) {
    exit("查詢數據失敗");
}?>

          <div class="content_message message-child">
            <div class="content content-child content-child-mes">

              <!-- 顯示子留言 -->
              <?while ($item_child = $query_child->fetch_assoc()): ?>
              <div class="main main-child">
                <div class="content_info info-child line">
                  <h3 class="name">
                    <?echo $item_child['nickname'] ?>
                  </h3>
                  <h3 class="date">
                    <?echo $item_child['create_at'] ?>
                  </h3>
                </div>
                <!-- 刪除＆編輯功能 -->
                <?php if ($is_login): ?>
                <?foreach ($de_result as $com): ?>
                <?php if ($com['id'] == $item_child['id'] && $com['user_id'] == $account): ?>
                <span class="modify">
                  <a href="index.php?id=<?php echo $com['id'] ?>"><i class="fas fa-pencil-alt"></i></a>
                  <a href="delete.php?id=<?php echo $com['id'] ?>" class="delete__mes delete__mes__response" data-id="<?php echo $com['id'] ?>"><i
                      class="fas fa-trash-alt"></i></a>
                </span>
                <?php if ($item['nickname'] == $item_child['nickname']): ?>
                <div class="show_self"></div>
                <?php endif?>
                <?php endif?>
                <?php endforeach?>
                <?php endif?>

                <div class="show">
                  <?echo htmlspecialchars($item_child['message']) ?>
                </div>

              </div>
              <?endwhile?>
            </div>

            <!-- 回覆留言 -->
            <form class="main main-child" action="add_message.php" method="post">
              <div class="content_message">
                <textarea name="message" cols="100" rows="5" placeholder="回覆此留言"></textarea>
              </div>
              <input type="hidden" name="parent_id" value="<?echo $item['id'] ?>">
              <div class="button">

                <!-- 判斷是否登入 -->
                <?php if ($is_login): ?>
                <button class="send_res">回應</button>
                <?php else: ?>
                <button disabled>登入後回應</button>
                <?php endif?>

              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
    <?endwhile?>
    <!-- 留言板-返回頂部 -->
    <div>
      <a href="#top"><i class="fas fa-arrow-alt-circle-up"></i></a>
    </div>
    <!-- 分頁 -->
    <table>
      <tr class="page">
        <td><a href="index.php?page=<?php echo $page > 1 ? $page - 1 : 1 ?>">上一頁</a></td>
        <?php for ($i = $begin; $i <= $end; $i++): ?>
        <td <?php echo $i === $page ? 'class="active"' : ''; ?>><a href="index.php?page=<?php echo $i ?>">
            <?echo $i ?></a></td>
        <?php endfor?>
        <td><a href="index.php?page=<?php echo $page < $end ? $page + 1 : $end ?>">下一頁</a></td>
      </tr>
    </table>
  </div>
  <?php endif?>


  <!-- jquery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49"
    crossorigin="anonymous"></script>
  <!-- bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T"
    crossorigin="anonymous"></script>
  <!-- index.js -->
<script src="js/deleteMessage.js"></script>
<script src="js/addMessage.js"></script>

</body>

</html>