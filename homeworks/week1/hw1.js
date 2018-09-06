//hw1：印出星星
//給定 n（1<=n<=30），依照規律「印出 *」圖形
function printStars(n) {
  if (n >= 1 && n <= 30) {
    for (var i = 0; i < n; i++) {
      console.log("*");
    }
  }
}

// printStars(1);
// printStars(3);
// printStars(30);

// printStars(-1);
// printStars(0);
// printStars(31);