(function ($) {
  // 存儲任務列表
  let list = []
  // 添加任務 ----------------------
  let addTask = createTask => {
    list.push(createTask)
    render()
    $("input[type='text']").val('') // 清空輸入欄
  }
  // 刪除任務 -----------------------
  let deleteTask = id => {
    id = Number(id)
    let delAfter = []
    for (let i = 0; i < list.length; i++) {
      if (i !== id) {
        delAfter.push(list[i])
      }
    }
    list = delAfter
    render()
  }
  // 渲染頁面 -----------------------
  let render = () => {
    $('#task').empty()
    for (let i = 0; i < list.length; i++) {
      $('#task').append(
        `<div class="show-task row justify-content-center align-items-center">
      <input type="checkbox" class="checkbox">
      <p class="text col-8">${list[i]}</p>
      <input class = "task-id"
      type = "hidden" value = "${i}" >
      <button class="delete btn btn-danger">
      <i class="fas fa-minus"></i></button>
    </div>`)
    }
  }

  // -------- state ------------------
  let state = e => {
    e.preventDefault()
    if ($(e.target).hasClass('delete')) {
      let id = $(e.target).parent().find('.task-id').val()
      deleteTask(id)
    } else if ($(e.target).hasClass('text')) {
      let state = $(e.target).parent().find(':checkbox')
      state.prop('checked', !state.prop('checked'))
    }
  }

  // 點擊任務項執行 state （狀態改變/刪除任務）
  $('#task').on('click', state)

  // -------- newTask ------------------
  let newTask = () => {
    // 取得創建任務
    let createTask = $('#todo').val()
    // 判斷不為空
    if (createTask !== '') {
      // 添加任務
      addTask(createTask)
    }
    render()
  }

  // 點擊 ＋ 執行 newTask
  $('#submit').on('click', newTask)

  // 點擊 enter 執行 newTask
  $('body').keyup(event => {
    if (event.keyCode === '13') {
      $('#submit').click()
    }
  })
})($)
