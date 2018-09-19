let alphaSwap = (str) => {
  let change = ''
  for (let i = 0; i < str.length; i++) {
    if (str[i] >= 'a' && str[i] <= 'z') {
      change += str[i].toUpperCase()
    } else {
      change += str[i].toLowerCase()
    }
  }
  return change
}

module.exports = alphaSwap