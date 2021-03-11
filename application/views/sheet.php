<body>
    <?php
    include 'nav_bar_old.php';
    
    function numberTOalphabet($num){
        switch($num){
            case 0:
                return 'A';
                break;
            case 1:
                return 'B';
                break;
            case 2:
                return 'C';
                break;
            case 3:
                return 'D';
                break;
            case 4:
                return 'E';
                break;
            case 5:
                return 'F';
                break;
            case 6:
                return 'G';
                break;
            case 7:
                return 'H';
                break;
            case 8:
                return 'I';
                break;
            case 9:
                return 'J';
                break;
        }
    }
    ?>

    <div class="container">
        <div class="row page_topping">
            <div class="col-md-8 col-md-offset-2">
                <?php
                if($status == 0){
                    ?>

                    <div class="h1 c"><?php echo($err_msg);?></div>
                    
                    <?php
                }else{
                    ?>

                    <div class="h1 c"><?php echo($test_info->name);?></div>
                    <div class="c">科目：<?php echo($test_info->subject);?></div>
                    <div class="c">时限：<?php echo($test_info->timeLimit);?>分钟</div>
                    <div class="c">题目数量：<?php echo($test_info->ques_count);?>题</div>
                    <?php
                    if($if_snapshot){
                    ?>
                        <div class="c">考生：<?php echo($test_info->test_history->stuName);?> (ID：<?php echo($test_info->test_history->stuAccount);?>)</div>
                        <div class="c">交卷时间：<?php echo($test_info->test_history->finish);?></div>
                        <div class="c">分数：<?php echo($test_info->test_history->score);?> （答对<?php echo($test_info->test_history->correct_count);?>题）</div>
                    <?php
                    }
                    ?>

                    <div class="ques_block">

                    <?php
                    foreach($questions as $key => $q){
                        if($if_snapshot){
                            //snapshot
                            ?>
                            
                            <div class="ques">
                                <div><?php echo($key + 1);?>. <?php echo($q->snapshot_content);?></div>
                                
                                <?php
                                $correct_key = null;
                                foreach($q->choices as $key2 => $c){
                                    if($c->a == 1){
                                        $correct_key = $key2;
                                    }
                                    ?>
                                    <div>(<?php echo(numberTOalphabet($key2));?>) <?php echo($c->c);?></div>
                                    
                                    <?php
                                }
                                $judge_str = "回答错误，正确答案为 " . numberTOalphabet($correct_key);
                                $css_str = 'wrong';
                                if($correct_key == $q->stuChoice){
                                    $judge_str = "回答正确";
                                    $css_str = 'right';
                                }
                                ?>
                                
                                <div>学生选择：<?php echo(numberTOalphabet($q->stuChoice));?></div>
                                <div class="<?php echo($css_str);?>"><?php echo($judge_str);?></div>
                            </div>

                            <?php
                        }else{
                            //not snapshot
                            ?>
                            
                            <div class="ques">
                                <div><?php echo($key + 1);?>. <?php echo($q->content);?></div>
                                
                                <?php
                                $correct_key = null;
                                foreach($q->choices as $key2 => $c){
                                    if($c->a == 1){
                                        $correct_key = $key2;
                                    }
                                    ?>

                                    <div>(<?php echo(numberTOalphabet($key2));?>) <?php echo($c->c);?></div>
                                    
                                    <?php
                                }
                                ?>
                                
                                <div>正确答案：<?php echo(numberTOalphabet($correct_key));?></div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                    </div>
                    <?php
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>