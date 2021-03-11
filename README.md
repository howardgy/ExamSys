ExamSys在线考试系统
===========================

### Intro

ExamSys is an online exam system based on Web; the front end is constructed by HTML+JS+CSS, with the application of BootStrap and JQuery framework; the back end is built by PHP+MySQL with the using of CodeIgnitor PHP framework. This project provide a simple and easy user interface, which is divided into two parts -- the student and teacher end. After logged in, students are allow to take tests and get random questions in a test; teachers manage question banks, tests, and student performances; the system supports single choice question and automatically generate scores. 

ExamSys是一个基于Web的在线考试系统，前端使用HTML+JS+CSS构建，应用了BootStrap和JQuery框架以及AJAX、JSON等技术；后端使用PHP+MySQL实现，采用了CI框架。程序构建了一个清爽简单的用户界面，分为学生端和教师端两部分，学生登录系统后可以自由选择任意题库进行答题练习，也可随时查看自己的答题情况，教师账户可对题库、题目细节、学生成绩等进行相应的管理操作。系统支持单选并进行自动判分。设计还有许多不如意的地方, 以后会慢慢改进, 慢慢完善这个系统, 使其可以满足大部分在线测试的需求. 

 Author | Email
------- | -------------
 Howard | laurentstudio@qq.com
 Ryann  | lrx0014@hotmail.com



Change Logs
-----------

### ExamSys_MZ v0.3.1 (2020/5/3)
* 即使修改题库或删除题目，考试作答记录也能完全按照快照显示
* 每一题只要作答人数大于5人即可计算出正确率
* 修复重复添加题目到考试的bug

### ExamSys_MZ v0.3 (2020/4/21)

* 引入CodeIgnitor框架，完善代码逻辑
 * 所有API函数都有回调
 * 改变选项的分割方式
 * 默认5选项，增加题目后不刷新页面
 * 后台管理页面可通过地址指定
* 答题模式增加回顾已答题目、标记题目功能
* 注册时增加邀请码作为验证机制
* 增加用户更改名称和密码功能
* 数据库彻底重构

### ExamSys v0.2.1 (2018/05/19)
    
* 项目Docker化，提供容器技术支持

  
### ExamSys v0.2 (2018/01/30)
* 修复了一些BUG，增加了新功能
* 修复一些页面逻辑是漏洞
* 增加了组卷功能，可以区分不同场次的考试
* 可以删除题目
  
### ExamSys v0.1 (2018/01/25)
* 实现最基础的功能，验证程序可正常工作
* 管理员端和考生端的注册登录
* 多项选择题的录入
* 信息浏览和考生答题功能
  
### Screenshots

#### [登录页]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/login_page.jpg)

#### [注册页 支持前后台数据验证]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/SignUp_page.jpg)

#### [学生页]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/StudentInfo_page.jpg)

#### [在线测试页 答题后可立即判题给分]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/Test_page.jpg)

#### [教师可以查看考生成绩，支持模糊查询]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/Teacher_1.jpg)

#### [教师查看题库中的试题详情]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/Teacher_2.jpg)

#### [教师可以自己录入试题，目前只支持多项选择题，以后会加入其它常见题型]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/Teacher_3.jpg)

#### [组卷功能，设置不同的考试]
![](https://wafer-1256881308.cos.ap-guangzhou.myqcloud.com/img/ExamSys_md/Teacher_4.jpg)
