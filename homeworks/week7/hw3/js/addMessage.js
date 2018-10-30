// 新增主留言改 ajax
(function ($) {
  console.log('res.id')
  $('.send').on('click', function (e) {
    e.preventDefault()
    let mes = $('#sendMessage').val()
    let nickname = $('#nickname').text()
    let parentID = $('input[name="parent_id"]').val()
    let account = $('#check_cer').text()
    console.log('res.id')
    console.log(mes, nickname, parentID, account)
    $.ajax({
      type: 'POST',
      url: 'add_message.php',
      data: {
        nickname: nickname,
        message: mes,
        parent_id: parentID,
        user_id: account,
        check: account
      },
      success: function (resp) {
        let res = JSON.parse(resp)
        if (res.result === 'success') {
          $('.showMessage').prepend(`
<div class="board board-res">
  <div class="content content-child">
    <div class="aside">
      <span>▲</span>
      <span>0</span>
    </div>
    <div class="main main-res">
      <div class="content_info info-child">
        <h3 class="name"> ${nickname} </h3>
        <h3 class="date">2018-10-29 09:03:18 </h3>
      </div>
      <div class="show">${mes}
        <div class="modify">
          <a href="index.php?id=${res.id}"><i class="fas fa-pencil-alt"></i></a>
          <a href="delete.php?id=${res.id}" class="delete__mes" data-id="${res.id}"><i class="fas fa-trash-alt"></i></a>
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
  `)
        }
      }
    })
  })
})($)