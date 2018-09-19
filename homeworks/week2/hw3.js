let isPrime = (n) => {
  let res = true
  if (n === 1) {
    res = false
  } else {
    for (let i = 2; i < n; i++) {
      if (n % i === 0) {
        res = false
      }
    }
  }
  return res
}

module.exports = isPrime