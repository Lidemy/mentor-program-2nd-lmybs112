(() => {
  let submit = document.querySelector('.container__form__content__submit')
  let txt = document.querySelectorAll('.tip--txt')
  let bg = document.querySelectorAll('.container__form__content__qa')
  let answer = document.querySelectorAll('.container__form__content__answer')
  let type = document.getElementsByName('type')
  let label = document.querySelectorAll('label')
  let checked = ''
  document.addEventListener('DOMContentLoaded', () => {
    submit.addEventListener('click', () => {
      for (let i = 0; i < answer.length - 1; i++) {
        if (!(answer[i].value)) {
          txt[i].style.display = 'block'
          answer[i].classList.add('tip--line')
          bg[i].classList.add('tip--bg')
        } else if ((answer[i].value)) {
          answer[i].classList.remove('tip--line')
          bg[i].classList.remove('tip--bg')
          txt[i].style.display = 'none'
        }
      }
      for (let i = 0; i < type.length; i++) {
        if (type[i].checked) {
          bg[2].style.backgroundColor = 'white'
          txt[2].style.color = 'white'
          checked = label[i].innerText
        }
      }
      console.log('電子郵件：' + answer[0].value)
      console.log('暱稱：' + answer[1].value)
      console.log('報名類型：' + checked)
      console.log('職業：' + answer[3].value)
      console.log('是否有程式相關背景：' + answer[4].value)
      console.log('其他：' + answer[5].value)
    })
  })
})()
