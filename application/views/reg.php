<body>
  <?php include 'nav_bar_old.php'?>

  <div class="container">
    <div class="col-md-6 col-md-offset-3" style="margin-top:10%">
        <form>
            <div class="space">
                <label for="name">选择身份</label>
                <select id="type" name="type" class="form-control">
                    <option value="0">学生</option>
                    <option value="1">教师</option>
                </select>
            </div>

            <div class="form-group has-feedback">
                <label for="username">邀请码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-sunglasses"></span></span>
                    <input id="invitation" name="invitation" class="form-control" placeholder="请输入邀请码" maxlength="100" type="text" autofocus>
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="username">姓名</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
                    <input id="username" name="UserName" class="form-control" placeholder="请输入姓名，中文或英文字符" maxlength="30" type="text">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="userid">登录账号</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-flag"></span></span>
                    <input id="userid" name="UserId" class="form-control" placeholder="请输登录账号，字母+数字" maxlength="20" type="text">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class=" glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="password">密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="password" name="Password" class="form-control" placeholder="请输入密码" maxlength="20" type="password">
                </div>

                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group has-feedback">
                <label for="passwordConfirm">确认密码</label>
                <div class="input-group">
                    <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
                    <input id="passwordConfirm" name="Confirm" class="form-control" placeholder="请再次输入密码" maxlength="20" type="password">
                </div>
                <span style="color:red;display: none;" class="tips"></span>
                <span style="display: none;" class="glyphicon glyphicon-remove form-control-feedback"></span>
                <span style="display: none;" class="glyphicon glyphicon-ok form-control-feedback"></span>
            </div>

            <div class="form-group">
                <input class="form-control btn btn-primary" id="submit" value="立即注册">
            </div>

            <div class="form-group">
                <input value="重置" id="reset" class="form-control btn btn-danger" type="reset">
            </div>
        </form>
    </div>
</div>


<script src="/ExamSys/static/js/Reg.js"></script>
</body>

</html>