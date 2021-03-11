<body>
    <?php include('nav_bar_old.php') ?>

    <div class="container-fluid" onload="AquireQuestion()">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar mysidebar">
                <ul class="nav nav-sidebar">
                    <?php
                    if($test->status == 1){
                    ?>
                    <li id="info1">
                        <div class="h4" id="percent">完成进度：</div>

                        <div class="progress progress-striped active" style="margin-left:10px;margin-right:10px">
                            <div id="probar" class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                                <span class="sr-only">完成进度</span>
                            </div>
                        </div>
                    </li>

                    <li class="sidebar_info">
                        <div class="h5">考试名称：<?php echo($test->name);?></div>
                        <div class="h5">考试科目：<?php echo($test->subject);?></div>
                        <div class="h5">答题时限：<?php echo($test->timeLimit);?> min</div>
                        <!-- <div class="h5" id="timer">剩余时间：</div> -->
                        <div class="h5" id="ques_left">剩余题数：</div>
                    </li>

                    <li id="boxes" class="sidebar_info"></li>
                    <?php
                    }
                    ?>
                </ul>
            </div>













            <?php
            if($test->status == 0){
            ?>
            <div id="before">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <div class="panel panel-primary" style="margin-left:20%;margin-right:20%;">
                        <div class="panel-heading">
                            <h3 class="panel-title">请您确认</h3>
                        </div>
                        <div class="panel-body h4">
                            <div class="space">考试名称：<?php echo($test->name);?></div>   
                            <div class="space">考试科目：<?php echo($test->subject);?></div>    
                            <div class="space">答题时限：<?php echo($test->timeLimit);?> min</div>   
                            <div class="space">题目数量：<?php echo($test->ques_count);?> 题</div>
                            <center>
                            <button onclick="start_test('<?php echo($_SESSION['UserId']);?>', <?php echo($test->id);?>)" class="btn btn-primary center">开始考试</button>
                            </center>
                            </div>
                    </div>
                </div>
            </div>



            <?php
            }else if($test->status == 1){
            // }else{
            ?>




            <div id="info2">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 id="question_type" class="page-header" style="margin-top:15px">选择题</h1>
                    <div class="panel panel-primary" >
                        <div class="panel-heading">
                            <h3 class="panel-title" id="QuesInfo">第x题</h3>
                        </div>
                        <div class="panel-body question_content">
                            <div id="QuesContent" class="space">
                                    正在获取试题内容......<br>
                                    如果长时间未成功载入，请尝试刷新
                            </div>
                            <div id="choices" class="space"></div>
                            <div class="ctrl_flex">
                                <div id="ctrl_button"></div>
                                <div id="mark_button"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                AquireQuestion(<?php echo($_SESSION['UserId'] . "," . $test->id);?>);
            </script>

            <?php
            }else{
            ?>








            <div>
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1>您已完成该考试</h1>
                </div>
            </div>


            <?php
            }
            ?>


        </div>
    </div>
</body>

</html>