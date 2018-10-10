資料庫名稱：comments

| 欄位名稱 | 欄位型態 | 說明     |
| -------- | -------- | -------- |
| id       | integer  | 留言 id  |
| content  | text     | 留言內容 |

---

資料表名稱：comments

| 欄位名稱  | 欄位型態 | 說明       |
| --------- | -------- | ---------- |
| id        | integer  | 留言人 id  |
| parent_id | integer  |  主留言 id |
| user_id   | integer  | 會員 id    |
| message   | text     | 留言內容   |
| create_at | datetime | 留言時間   |

資料表名稱：users

| 欄位名稱 | 欄位型態     | 說明      |
| -------- | ------------ | --------- |
| id       | integer      | 會員 id   |
| nickname | text         | 會員暱稱 |
| account  | varchar (32) | 會員帳號  |
| password | varchar (32) | 會員密碼  |
