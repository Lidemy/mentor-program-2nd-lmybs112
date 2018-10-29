(function ($) {
  // 點擊刪除按鈕
  $('.delete__mes').click(function (e) {
    // 取得留言容器
    let commentContainer = $(this).parent().parent().parent().parent().parent().parent()
    // 判斷子留言
    if ($(this).hasClass('delete__mes__response')) {
      // 取得子留言容器
      commentContainer = $(this).parent().parent().parent()
    }
    // 取得當前刪除id
    let id = $(this).attr('data-id')
    let string = 'id=' + id
    // 停止提交再確認
    e.preventDefault()
    if (confirm('是否要刪除留言?')) {
      $.ajax({
        type: 'GET',
        url: 'delete.php',
        data: string,
        success: function (data) {
          // 刪除此留言
          commentContainer.slideUp('slow', function () {
            $(commentContainer).remove()
          })
        }
      })
    }
  })
})($)
