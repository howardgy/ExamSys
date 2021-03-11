<body>
    <?php include('nav_bar_old.php') ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <form method="POST" action="/ExamSys/index.php/User/login" class="form-signin">
                    <h2 class="form-signin-heading">登录</h2>

                    <div class="space">
                        身份：
                        <label class="radio-inline">
                        <input type="radio" name="UserLevel" value="0" checked> 学生
                        </label>
                        <label class="radio-inline">
                        <input type="radio" name="UserLevel" value="1"> 老师
                        </label>
                    </div>

                    <label for="UserId" class="sr-only">账号</label>
                    <input type="text" id="UserId" name="UserId" class="form-control" placeholder="账号" maxlength="20" required autofocus>
                    <label for="UserPassword" class="sr-only">密码</label>
                    <input type="password" id="UserPassword" name="UserPassword" class="form-control" maxlength="20" placeholder="密码" required>
                    <button id="submit-btn" class="btn btn-lg btn-primary btn-block" type="submit">登录</button>
                    <button class="btn btn-lg btn-primary btn-warning btn-block" type="button" onclick="location.href='/ExamSys/index.php/pages/reg'">注册</button>
                </form>
            </div>
        </div>
        <div class="acknowledgement">Coded by Howard</div>
    </div>
</body>

</html>
