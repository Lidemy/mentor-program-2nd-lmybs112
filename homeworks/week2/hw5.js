let add = (a, b) => {
  // 將字串拆分放入數組反轉
  let arrA = a.split('').reverse()
  let arrB = b.split('').reverse()
  // 存較大數的長度
  let arrLength = Math.max(arrA.length, arrB.length)
  // 存相加的數
  let ans = ['']
  // 判斷要不要進位
  let carry = 0
  // 循環(兩者較大數) arrLength 次
  for (let i = 0; i < arrLength; i++) {
    // 遍歷字符串轉成數字相加
    // 預設值設0 沒有數字就捕0對齊
    // 加進位數
    ans[i] = parseInt(arrA[i] || 0) + parseInt(arrB[i] || 0) + carry
    // 判斷有沒有進位
    if (ans[i] >= 10) {
      [ans[i], carry] = [ans[i] % 10, 1]
    } else {
      carry = 0
    }
  }
  // 如果最後進位為1，位數要再加1
  if (carry === 1) {
    ans[arrLength] = carry
  }
  return ans.reverse().join('')
}

// console.log(add('12312383813881381381', '129018313819319831'))
// console.log(add('9', '19'))
// console.log(add('9', '9'))
// console.log(add('111111111111111111111111111111111111', '111111111111111111111111111111111111'))

module.exports = add;