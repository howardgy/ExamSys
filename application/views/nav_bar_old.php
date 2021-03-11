<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false"
                aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/ExamSys"><?php echo(appName);?></a>
            
                <?php
                if(isset($bar_content)){
                    if($bar_content == 'teacher'){
                ?>
                <ul class="nav navbar-nav navbar-right">
                    <p class="navbar-text" style="color:white">你好，<?php echo $_SESSION['UserName']; ?> 老师</p>
                    <li><a class="nav-link" data-toggle="modal" data-target="#userinfo_modal">修改个人信息</a></li>
                </ul>

                <?php
                    }elseif($bar_content=="test0" || $bar_content=="test2"){
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <p class="navbar-text" style="color:white"><?php echo $_SESSION['UserName']; ?></p>
                            <li><a href="/ExamSys">返回主页</a></li>
                        </ul>
                        <?php
                    }elseif($bar_content=="test1"){
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <p class="navbar-text" style="color:white"><?php echo $_SESSION['UserName']; ?></p>
                            <li><a href='javascript:finish_test()'>交卷</a></li>
                        </ul>
                        <?php
                    }elseif($bar_content=="student"){
                        ?>
                        <ul class="nav navbar-nav navbar-right">
                            <p class="navbar-text" style="color:white"><?php echo $_SESSION['UserName']; ?></p>
                            <li><a href="javascript:void(0);"  data-toggle="modal" data-target="#userinfo_modal">修改个人信息</a></li>
                        </ul>
                        <?php
                    }
                }
                ?>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <?php
                if(isset($bar_content)){
                    if($bar_content == 'teacher'){
                    ?>

                    <li><a href="/ExamSys/index.php/User/logout">注销</a></li>
                
                    <?php
                    }elseif($bar_content=="test0" || $bar_content=="test2"){
                    ?>

                    <li><a href="/ExamSys/index.php/User/logout">注销</a></li>
                    
                    <?php
                    }elseif($bar_content=="student"){
                    ?>

                    <li><a href="/ExamSys/index.php/User/logout">注销</a></li>
                    
                    <?php
                    }
                }
                ?>
                <li><a href="/">麻醉科</a></li>
            </ul>
        </div>
    </div>
</nav>