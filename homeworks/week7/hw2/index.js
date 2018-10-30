(function ($) {
  // 功能-----------------------------------

  // 添加任務 addTask
  let addTask = function (createTask) {
    // 在myTask下顯示增加任務
    $('#task').append(
      `<div class="show-task row justify-content-center align-items-center">
      <input type="checkbox" class="checkbox">
      <p class="text col-8">${createTask}</p>
      <button class="delete btn btn-danger"><i class="fas fa-minus"></i></button>
    </div>`)
    $("input[type='text']").val('') // 清空輸入欄
  }

  // 刪除任務 deleteTask
  let deleteTask = function () {
    // 遍歷所有 delete
    $('.delete').each(function () {
      // 點擊 delete
      $(this).click(function () {
        // 刪除任務
        $(this).closest('div').remove()
      })
    })
  }

  // 判斷任務完成狀態 state
  let state = function () {
    // 遍歷所有 checkbox
    $('.checkbox').each(function () {
      // 點擊 checkbox
      $(this).on('click', function () {
        // 已完成劃掉
        let checked = $(this).prop('checked')
        if (checked === true) {
          $(this).parent().children('.text').css({
            'text-decoration': 'line-through',
            'color': '#ccc'
          })
        } else { // 取消已完成
          $(this).parent().children('.text').css({
            'text-decoration': 'none',
            'color': 'white'
          })
        }
      })
    })
  }

  // 計算任務項 countChecked
  let countChecked = function () {
    let done = $('input:checked').length
    let all = $('input:checkbox').length
    let undone = all - done
    $('#count').text('共 ' + all + ' 項任務，' + (done === 0 ? '還未完成任務' : ' 未完成： ' + undone + ' 已完成： ' + done))
  }

  // ----------------------------------

  // todoList
  let todoList = function () {
    // 取得創建任務
    let createTask = $('#todo').val()

    // 判斷不為空
    if (createTask !== '') {
      // 添加任務
      addTask(createTask)
    }

    // 判斷任務完成狀態
    state()

    // 刪除任務
    deleteTask()

    // 計算任務項
    countChecked()

    // 點擊 checkbox 計算任務項
    $('input[type=checkbox]').on('click', countChecked)

    // 點擊 刪除 計算任務項
    $('.delete').on('click', countChecked)
  }

  // 點擊 ＋ 執行 todoList
  $('#submit').on('click', todoList)

  // 點擊 enter 執行 todoList
  $('body').keyup(function (event) {
    if (event.keyCode === '13') {
      $('#submit').click()
    }
  })
})($)