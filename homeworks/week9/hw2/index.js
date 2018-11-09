(() => {
  // Stack 後進先出
  let Stack = function () {
    let arr = []
    let i = 0
    return {
      push: (n) => {
        arr[i] = n
        i++
      },
      pop: () => {
        let res = arr[i - 1]
        arr.splice(i - 1, 1)
        i--
        return res
      }
    }
  }

  let stack = new Stack()
  stack.push(10)
  stack.push(5)
  console.log(stack.pop()) // 5
  console.log(stack.pop()) // 10

  // Queue 先進先出
  let Queue = function () {
    let arr = []
    let i = 0
    return {
      push: (n) => {
        arr[i] = n
        i++
      },
      pop: () => {
        let res = arr[0]
        arr.splice(0, 1)
        return res
      }
    }
  }

  let queue = new Queue()
  queue.push(1)
  queue.push(2)
  console.log(queue.pop()) // 1
  console.log(queue.pop()) // 2
})()
