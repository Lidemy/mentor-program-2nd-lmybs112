<!-- 輸出下方留言 -->
<div class="board board-res">
  <div class="content content-child">
    <div class="aside">
      <span>▲</span>
      <span>0</span>
    </div>
    <div class="main main-res">
      <div class="content_info info-child">
        <h3 class="name">
          ${nickname}
        </h3>
        <h3 class="date">
          ${res.create_at}
        </h3>
      </div>
      <div class="show">
        ${mes}
        <div class="modify">
          <a href="index.php?id=${res.id}"><i class="fas fa-pencil-alt"></i></a>
          <a href="delete.php?id=${res.id}" data-id="${res.id}" class="delete__mes">Delete</a>
        </div>
      </div>
      <div class="content_message message-child">
        <form class="main main-child" action="add_message.php" method="post">
          <div class="content_message">
            <textarea name="message" cols="100" rows="5" placeholder="回覆此留言"></textarea>
          </div>
          <input type="hidden" name="parent_id" value="${res.id}">
          <div class="button">
            <button class="send_res">回應</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
