let stars = (n) => {
  let arr = []
  let star = ''
  for (let i = 0; i < n; i++) {
    star += '*'
    arr.push(star)
  }
  return arr
}

module.exports = stars