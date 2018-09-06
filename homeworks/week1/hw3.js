// hw3：反轉字串
// 給定一個字串，請「印出」反轉之後的樣子（不能使用內建的 reverse 函式）
function reverse(str) {
  var rev = '';
  for (var i = str.length - 1; i >= 0; i--) {
    rev += str[i];
  };
  console.log(rev);
}