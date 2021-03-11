<body>
    <?php include('nav_bar_old.php') ?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="myJumbotron">
                    <h1>欢迎！</h1>
                    <p>姓名：<?php echo $_SESSION['UserName'] . " (ID:" . $_SESSION['UserId'] . ")"; ?></p>
                    <div class="space">
                        <select id="choose_set_test" name="choose_set_test" class="form-control">
                            <option value='-1'>请选择一场考试</option>
                        </select>
                    </div>
                    <div><a id="go_test" class="btn btn-primary btn-sm" role="button">马上去答题</a></div>
                    
                </div>
            </div>
            <div class="col-md-9">
                <div class="panel panel-primary right_side_panel">
                    <div class="panel-heading">
                        <h3 class="panel-title">我的考试</h3>
                    </div>
                    <div class="panel-body">

                        <table class="table table-striped">
                            <div>
                            <table class="table table-bordered table-hover table-striped table-condensed">            
                                <thead>
                                    <tr>
                                        <td width="5%"> </td>
                                        <td width="25%">时间</td>
                                        <td width="">考试名称</td>
                                        <td width="20%">状态</td>
                                    </tr>
                                    <tr id="tip" style="display:none;">
                                        <td colspan="4"></td>
                                    </tr>
                                </thead>            
                                <tbody id="GradeView">                
                                </tbody>
                            </table>
                            <div class="list-div">        
                            </div>
                        </div>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include 'userinfo_modal.php'?>
</body>

</html>