//hw2：首字母大寫
//給定一字串，把第一個字轉成大寫之後「回傳」，若第一個字不是英文字母則忽略。

// function capitalize(str) {
//   var change=str.substring(0,1).toUpperCase()+str.substring(1);
//   return change;
// }

function capitalize(str) {
  var change = '';
  if (str[0] >= 'a' && str[0] <= 'z') {
    change = str[0].toUpperCase() + str.substring(1);
    return change;
  } else {
    return str;
  };
}