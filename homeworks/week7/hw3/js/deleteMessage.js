(function ($) {
  // 點擊刪除按鈕
  $('.showMessage').click(function (e) {
    if ($(e.target).hasClass('delete__mes')) {
      e.preventDefault()
      // 取得留言容器
      let commentContainer = $(e.target).parent().parent().parent().parent().parent()
      // 判斷子留言
      if ($(e.target).hasClass('delete__mes__response')) {
        // 取得子留言容器
        commentContainer = $(e.target).parent().parent().parent()
      }
      // 取得當前刪除id
      let id = $(e.target).attr('data-id')
      if (confirm('是否要刪除留言?')) {
        $.ajax({
          type: 'GET',
          url: 'delete.php',
          data: {
            id: id
          },
          success: function () {
            // 刪除此留言
            commentContainer.slideUp('slow', function () {
              $(commentContainer).remove()
            })
          }
        })
      }
    }
  })
})($)