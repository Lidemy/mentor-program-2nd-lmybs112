(() => {
  document.addEventListener('DOMContentLoaded', () => {
    // 按鈕容器
    let keyboard = document.querySelector('.calculator__container__keyboard')
    let row = document.querySelectorAll('.keyboard__row')
    // 顯示器
    let screen = document.querySelector('.calculator__container__result')
    // 紀錄顯示數
    let count = 0

    // 鍵盤註冊點擊事件
    keyboard.addEventListener('click', e => {
      // 獲取按到的內容
      let btnType = e.target.innerText

      // 點到row不顯示
      for (let i = 0; i < row.length; i++) {
        if (btnType === row[i].innerText) {
          return
        }
      }
      // 清空鍵
      if (btnType === 'AC') {
        screen.innerText = '0'
        count = 1

        // 倒退鍵
      } else if (btnType === 'DEL') {
        if (screen.innerText !== '') {
          if (screen.innerText.length === 1) {
            screen.innerText = '0'
          } else {
            screen.innerText = screen.innerText.slice(0, -1)
          }
          count--
        }
        // 計算
      } else if (btnType === '=') {
        if (!screen.innerText) {
          screen.innerText = ''
        } else {
          screen.innerText = eval(screen.innerText)
          count = screen.innerText.length
        }
      } else {
        if (screen.innerText === '0' && (!isNaN(+btnType))) {
          screen.innerText = ''
        }

        screen.innerText += btnType

        // 限制位數
        if (count++ >= 8) {
          screen.innerText = '數字過大'
        }
      }
    })
  })
})()