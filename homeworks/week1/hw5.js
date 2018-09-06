// hw5：自己的函式自己寫

//  join 會接收兩個參數：一個陣列跟一個字串，會在陣列的每個元素中間插入一個字串，
//  最後回傳合起來的字串。
function join(str, concatStr) {
  var newString=str[0];
  for(var i=1;i<str.length;i++){
    newString+=concatStr+str[i];
  }
  return newString;
}
console.log(join([1,2,3],""));
console.log(join(['a','b','c'],"!"));
console.log(join(['a',1,'b',2,'c',3],","));

// repeat 回傳重複 n 次之後的字串。
function repeat(str, times) {
  var rep='';
for(var i=0;i<times;i++){
  rep+=str;
}
return rep;
}
console.log(repeat('a',5));
console.log(repeat('yoyo',2));