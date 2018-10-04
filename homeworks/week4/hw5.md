## hw5：簡答題

1. 什麼是 DOM？

   - DOM（文檔對像模型）是通過 JavaScript，可以重構整個 HTML 文檔。可以添加，移除，改變或重排頁面上的項目。
   - 要改變頁面的某個東西， JavaScript 就需要獲得對 HTML 文檔中所有元素進行訪問的入口。這個入口，連同對 HTML 元素進行添加，移動，改變或移除的方法和屬性，都是通過文檔對像模型來獲得的（DOM）。

   - 參考連結 [什么是 DOM? DOM 和 JavaScript 的关系](https://blog.csdn.net/hqf2009/article/details/50352456)

2. 什麼是 Ajax？

   - 核心操作是用 XMLHttpRequest（簡稱 XHR）對象進行異步數據處理，向服務器發送請求和解析服務器響應提供接口，使瀏覽器可以發出 HTTP 請求與接收 HTTP 響應，實現在頁面不刷新的情況下和服務端進行數據交互。

   - 參考連結 [ajax 交互原理](https://blog.csdn.net/zqjflash/article/details/19479135)

3. HTTP method 有哪幾個？有什麼不一樣？

   1. GET：取得(想要的服務)的資料或是狀態。（safe & idempotent）
   2. POST：新增一項資料。
   3. PUT：利用更新的方式於"指定位置"新增一項資料。 （idempotent）
   4. PATCH：在現有的資料欄位中，增加或部分更新一筆新的資料。
   5. DELETE：指定資料刪除。 （idempotent）

   - idempotent 是指該操作不管做 1 遍、2 遍或多遍，都會得到同樣的資源狀態結果。
   - safe 是指該操作不會改變原本的資源狀態，並且同樣的結果是可以被快取（Cache）的。
   - POST／PUT 都可以用來新增

     1. POST 的定義上屬於將原先沒有的資料去做一筆新增的動作，
     2. PUT 在定義上(idempotent)無論做多少次，回傳結果都會一樣。

   - PATCH／PUT 都可以用來修改

     1. PATCH 則可以針對已經存在的資料欄位去做部分更新
     2. PUT 就像是把整份改好的表格重新上傳。

   - 參考連結 [HTTP 協定](https://shannon112.blogspot.com/2018/08/api-vs-webhook.html)

4. `GET` 跟 `POST` 有哪些區別，可以試著舉幾個例子嗎？

   - get 從伺服器上獲取數據，將參數數據加到 URL 中，用戶可以看到，安全性低，執行速度較快。

   - post 是向伺服器傳送數據，將內容放置在 http 請求信息體內傳送，用戶看不到這個過程，安全性較高執行速度較慢。

![圖片介紹](https://4.bp.blogspot.com/-r-ChcxuRUo8/UMC5f37SQYI/AAAAAAAAEfM/04-sOhGZHMc/s1600/Comparison_thumb.png)

- 參考連結 [[HTTP] HTTP GET、POST Method](https://marcus116.blogspot.com/2012/12/http-http-getpost-method.html)

5. 什麼是 RESTful API？

   - REST (Representational State Transfer) 中文翻譯叫做「具象狀態傳輸」，
     是一種網路架構風格，目的是便於不同軟體/程序在網絡（例如網際網路）中互相傳遞信息。
     符合 REST 風格的 Web API 就被稱為 RESTful API 使 API 設計具有整體一致性，易於維護、擴展，且充份利用 HTTP 協定的特點。

   - 參考連結 [簡明 RESTful API 設計要點](https://tw.twincl.com/programming/*641y)

6. JSON 是什麼？

   - JSON 是個以純文字為基底去儲存和傳送簡單結構資料，可以透過特定的格式去儲存任何資料(字串,數字,陣列,物件)，也可以透過物件或陣列來傳送較複雜的資料。
     相容性高、格式容易瞭解，閱讀及修改方便且支援許多資料格式。

   - 參考連結 [你不可不知的 JSON 基本介紹](https://tw.twincl.com/programming/*641y)

7. JSONP 是什麼？

   - JSONP（JSON with Padding），用於解決 AJAX 跨域問題的一種方案。
     由於同源策略的限制，瀏覽器只允許的 XmlHttpRequest 請求當前源（域名，協議，端口）的資源，而對請求腳本資源沒有限制。通過請求腳本標籤實現跨域請求，然後在服務端輸出 JSON 數據並執行回調函數，這種跨域的數據的方式被稱為 JSONP。

   - 參考連結 [JSONP 原理及简单实现](https://juejin.im/entry/59a5a194f265da24734447f2)

8. 要如何存取跨網域的 API？

   - 透過在 HTTP Header 中加入 Access-Control-Allow-Origin 此回應標頭來讓用戶端檢查，當回應標頭含有 Access-Control-Allow-Origin 時資料將正常顯示，如未包含時雖然呼叫成功但是資料不會顯示出來。

   - 參考連結 [實作 Cross-Origin Resource Sharing (CORS) 解決 Ajax 發送跨網域存取 Request](https://blog.toright.com/posts/3205/%E5%AF%A6%E4%BD%9C-cross-origin-resource-sharing-cros-%E8%A7%A3%E6%B1%BA-ajax-%E7%99%BC%E9%80%81%E8%B7%A8%E7%B6%B2%E5%9F%9F%E5%AD%98%E5%8F%96-request.html)
