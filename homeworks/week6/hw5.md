## 請說明 SQL Injection 的攻擊原理以及防範方法

- 原理：透過在網頁中的輸入欄位或網址列的參數夾帶 SQL 指令或特殊字元，入侵到資料庫。

- 防範方法：使用 prepare statement 預處理，將變數設為 ?，再使用 bind_param 帶入變數名稱。

## 請說明 XSS 的攻擊原理以及防範方法

- 攻擊原理：惡意攻擊者往 Web 頁面裏嵌入惡意的客户端腳本，當用户瀏覽此網頁時，腳本就會在用户的瀏覽器上執行，進而達到攻擊者的目的。比如獲取用户的 Cookie、導航到惡意網站、攜帶木馬等。

- 防範方法：

 1. 使用 XSS Filter

    - 輸入過濾，對用戶提交的數據進行有效性驗證，僅接受指定長度範圍內並符合我們期望格式的的內容提交，阻止或者忽略除此外的其他任何數據。
    - 輸出轉義，當需要將一個字符串輸出到 Web 網頁時，同時又不確定這個字符串中是否包括 XSS 特殊字符，為了確保輸出內容的完整性和正確性，輸出 HTML 屬性時可以使用 HTML 轉義編碼（HTMLEncode）進行處理，輸出到script 中，可以進行 JS 編碼。

 2. 使用 HttpOnly Cookie

    - 將重要的 cookie 標記為 httponly，這樣的話當瀏覽器向 Web 服務器發起請求的時就會帶上 cookie 字段，但是在 js 腳本中卻不能訪問這個 cookie，這樣就避免了 XSS 攻擊利用 JavaScript 的 document.cookie 獲取 cookie。(若單獨使用無法全面抵禦跨站點腳本攻擊，所以通常需要將 HTTP-only Cookie 和其他技術組合使用。)

- [參考連結 - XSS](https://hk.saowen.com/a/5494c2b9b8098a6e95556655d9bb0d6a262ad8bbdaa5be72befad43b6501d5f9)

- [參考連結 - 對於跨站腳本攻擊（XSS攻擊）的理解和總結](https://www.imooc.com/article/13553)

- [參考連結 - COOKIE之安全设置漫谈](https://www.cnblogs.com/milantgh/p/3767105.html)
## 請說明 CSRF 的攻擊原理以及防範方法

- 攻擊原理：利用網站對於用戶網頁瀏覽器的信任，挾持用戶當前已登陸的 Web 應用程序，去執行並非用戶本意的操作。

- 防範方法：

 1. 客戶端與服務端以 POST 方式傳輸。
 2. 服務端驗證 HTTP Referer 字段。
 3. 使用驗證碼。
 4. 不通過 form 發送數據，如：Ajax 發送 Json 數據，Ajax 本身限制跨域請求，很大可能的避免 CSRF 攻擊。
 5. 添加 Token 驗證，在表單中添加服務端隨機生成的 Token，提交後服務端進行 Token 驗證。由於 Token 的存在，攻擊者無法再構造一個帶有合法 Token 的請求實施 CSRF 攻擊（一般結合 XSS 防禦一起使用）。

- [參考連結 - CSRF 攻擊原理及防護](https://www.jianshu.com/p/00fa457f6d3e)

- [參考連結 - CSRF 攻擊簡單介紹與相應防護措施](https://juejin.im/post/5af3a2de6fb9a07abb239c89)

## 請舉出三種不同的雜湊函數

1. MD5
2. SHA-256
3. bcrypt

## 請去查什麼是 Session，以及 Session 跟 Cookie 的差別

- Session 是一種服務器端的機制，當客戶端對服務端請求時，服務端會檢查請求中是否包含一個 Session 標識（稱為 Session ID）。
  如果沒有，那麼服務端就生成一個隨機的 Session 以及和它匹配的 Session ID，並將 Session ID 返回給客戶端。
  如果有，那麼服務器就在存儲中根據 session ID 查找到對應的 Session。

| \       | 數據存放位置 | 安全性 | 性能 |
| ------- | ---------- | ----- | --- |
| Cookie  | 客戶端瀏覽器 | 較低 | 較高 |
| Session | 服務器      | 較高 | 較低 |

- 兩者差別：

  1. Cookie 數據存放在客戶的瀏覽器上，較不安全，別人可以分析存放在本地的 Cookie 並竄改 Cookie 內容，但性能較 Session 高，單個的 Cookie 保存的數據不能超過 4K，很多瀏覽器都限制一個站點最多保存 20 個的 Cookie。
  2. Session 數據會在一定時間內保存在服務器上安全性較高但當訪問增多，會比較佔用服務器的性能。

- 使用時機：將登入等重要訊息存放在 SESSION，而其他不影響安全性的訊息，可以放在 COOKIE 中。

- [參考連結 - 会话(Cookie,Session,Token)管理知识整理(一)](https://www.zybuluo.com/Dukebf/note/856502#session-%E6%9C%BA%E5%88%B6)
- [參考連結 - Cookie & Session](https://ithelp.ithome.com.tw/articles/10187212)

## `include`、`require`、`include_once`、`require_once` 的差別

| \                                   | require | require_once | include_once | include_once |
| ------------------------------------ | ------- | ------------ | ------------ | ------------ |
| 被載入文件如果不存在是否影響繼續運行 | Y       | Y            | N            | N            |
| 多次調用是否會重複執行被載入的文件   | Y       | N            | Y            | N            |

- 差別：

  1. require 和 include 區別在於 require 會因為載入文件不存在而停止當前文件執行，而 include 不會。
  2. 有沒有 once，區別在於代碼中每使用一次就執行一次載入的文件，而 once 只會在第一次使用時執行。

- 使用時機：

  1. include 一般用於載入公共文件，而這個文件的存在與否不會影響程序後面的運行。
  2. require 用於載入不可缺失的文件至於是否採用一次載入（一次）這種方式取決於被載入的文件。