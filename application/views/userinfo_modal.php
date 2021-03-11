<!-- Userinfo Modal -->
<div class="modal fade" id="userinfo_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">修改个人信息</h4>
      </div>
      <div class="modal-body">

        <div class="form-horizontal">
            <div class="form-group">
                <label for="user_name" class="col-sm-3 control-label">真实姓名</label>
                <div class="col-sm-6">
                <input type="text" class="form-control" id="user_name" placeholder="真实姓名" value="<?php echo $_SESSION['UserName']; ?>">
                </div>
                <button class="btn btn-primary col-sm-2" id="update_user_name">提交</button>
            </div>

            <div class="form-group">
                <label for="user_psw" class="col-sm-3 control-label">原始密码</label>
                <div class="col-sm-6">
                <input type="password" class="form-control" id="user_psw1" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <label for="user_psw" class="col-sm-3 control-label">新密码</label>
                <div class="col-sm-6">
                <input type="password" class="form-control" id="user_psw2" placeholder="密码">
                </div>
            </div>
            <div class="form-group">
                <label for="user_psw" class="col-sm-3 control-label">重复新密码</label>
                <div class="col-sm-6">
                <input type="password" class="form-control" id="user_psw3" placeholder="密码">
                </div>
                <button class="btn btn-primary col-sm-2" id="update_psw">提交</button>
            </div>
        </div>

      </div>
    </div>
  </div>
</div>