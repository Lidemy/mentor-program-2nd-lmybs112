## 請找出三個課程裡面沒提到的 HTML 標籤並一一說明作用。

  1. &lt;abbr&gt;：用來標示簡稱或縮寫，並設置 title 為完整描述。

  2. &lt;sup&gt; / &lt;sub&gt;：用來標示上下標文本。（ 例如： X<sup>2=>上標</sup> / X<sub>2=>下標</sub> ）  

  3. &lt;canvas&gt;：標示放置圖形的容器，通過腳本（例如：JavaScript ）來繪製圖。  

- 參考連結 [HTML5 標籤列表](https://developer.mozilla.org/zh-CN/docs/Web/Guide/HTML/HTML5/HTML5_element_list)

## 請問什麼是盒模型（box modal）

- 盒模型由內到外包含元素的内容（ content ）、内邊距（ padding ）、  
邊框（ border ）、外邊距（ margin ）幾個元素，  
  透過 box-sizing 又可以分為標準模型（ content-box ）和 IE 模型（ border-box ）。

  1. 標準模型（ content-box ）:盒子的寬度只包含 content 寬度，  
  而總寬度 = 左右 margin + 左右 border + 左右 padding + width 。  
  
  2. IE 模型（ border-box ）：盒子的寬度 = 左右 border + 左右 padding + content 的寬度，  
  而總寬度 = 左右 margin + width 。

- 參考連結 [兩種 Box Model (盒模型)的理解、區別以及注意事項](https://www.jianshu.com/p/2e787c6d8ede)

## 請問 display: inline, block 跟 inline-block 的差別是什麼？

  1. inline：不會獨佔一行，寬度是隨元素內容變化的，  
不能設置 width 、 height 和上下 margin 及上下 padding，  
只能設置左右 margin 及左右 padding 。

  2. block：會獨佔一行，可以設定 width 和 height、margin 和 padding 屬性。
  3. inline-block：既有 inline 同行的特性又有 block 可設置寬高的特性，  
但有文字空白間隙的問題，可透過改變 html 結構（例如：注釋或刪除標籤間的空白）、  
設置父元素 font-size 為 0 等方式解決。

- 參考連結 [block、inline 和 inline-block 概念和區別](http://www.cnblogs.com/KeithWang/p/3139517.html)  

- 參考連結 [CSS 基礎篇--如何解決 inline-block 元素的空白間距](https://segmentfault.com/a/1190000003748030)

## 請問 position: static, relative, absolute 跟 fixed 的差別是什麼？

  1. static：預設定位，無法設置 top、bottom、left、right改變位置。  
  
  2. relative：和 static 位置相同，但是可以設置 top、bottom、left、right 改變位置。  
  
  3. absolute：以不是 static 的父元素為定位，但若上層所有的父元素都是預設的 static 定位，  
就會以 body 作為定位。  

  4. fixed：以瀏覽器視窗定位，固定在同一個位置，不會隨著滾動捲軸滾動而移動。  
  
- 參考連結 [學習 CSS 版面配置-關於 position 屬性](http://zh-tw.learnlayout.com/position.html)
