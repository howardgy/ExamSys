<body>
    <?php include 'nav_bar_old.php'?>

    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-3 col-md-2 sidebar">
                <ul class="nav nav-sidebar">
                    <li id="click1">
                        <a>学生成绩</a>
                    </li>
                    <li id="click2">
                        <a>考试管理</a>
                    </li>
                    <li id="click3">
                        <a>题目管理</a>
                    </li>
                    <li id="click4">
                        <a>录入试题</a>
                    </li>
                    <li id="click5">
                        <a>快速组卷</a>
                    </li>
                </ul>
            </div>















            <!-- 学生成绩 -->
            <div id="info1" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">学生成绩</h1>

                    <div>
                        <table class="table table-bordered table-hover table-striped table-condensed c">
                            <thead>
                                <tr>
                                    <td width="30px"> </td>
                                    <td width="70px">ID</td>
                                    <td width="80px">名字</td>
                                    <td width="">考试</td>
                                    <td width="80px">分数</td>
                                    <td width="200px">时间</td>
                                    <td width="140px"> </td>
                                </tr>
                            </thead>
                            <tbody id="scoreView">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>












            <!-- 考试管理 -->
            <div id="info2" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <div class="space_between">
                        <div class="page-header h1">考试管理</div>
                        <div><button id="add_new_test" class="btn btn-primary space" data-toggle="modal" data-target="#test_modal">添加新考试</button></div>
                    </div>

                    <div id="content">
                        <table class="table table-bordered table-hover table-striped table-condensed c">
                            <thead>
                                <tr>
                                    <td width="50px">编号</td>
                                    <td width="">试卷标题</td>
                                    <td width="60px">试题数</td>
                                    <td width="70px">考试人数</td>
                                    <td width="80px">发布者</td>
                                    <td width="150px">创建时间</td>
                                    <td width="230px">操作</td>
                                </tr>
                                <tr id="tip_Ques" style="display:none;">
                                    <td colspan="7"></td>
                                </tr>
                            </thead>
                            <tbody id="Ques_List">
                            </tbody>
                        </table>
                        <div class="list-div-Ques">
                        </div>
                    </div>
                </div>
            </div>










            <!-- 题目管理 -->
            <div id="info3" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">题目管理</h1>

                    <div id="content">
                        <div class="col-sm-5 space">
                            <select class="form-control" id="choose_test_to_show_ques" name="choose_test_to_show_ques">
                                <option value="-1">全部题目</option>
                            </select>
                        </div>

                        <table class="table table-bordered table-hover table-striped table-condensed c">
                            <thead>
                                <tr>
                                    <td width="30px"> </td>
                                    <td width="">题干预览</td>
                                    <td width="70px">正确率</td>
                                    <td width="200px">操作</td>
                                </tr>
                                <tr id="tip_Ques" style="display:none;">
                                    <td colspan="3"></td>
                                </tr>
                            </thead>
                            <tbody id="Ques_List_ctrl">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>












            <!-- 录入试题 -->
            <div id="info4" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">录入试题</h1>

                    <div style="width:600px;">
                        <div class="input-group space">
                            <span class="input-group-addon">题目内容</span>
                            <textarea type="textarea" id="this_content" name="this_content" class="form-control" placeholder="输入题目内容" rows="5" style="resize:none" maxlength="1000"></textarea>
                        </div>


                        <div id="chooses">
                            <div id="add_choose" class="input-group space">
                                <span id="choose_no" class="input-group-addon">备选选项</span>
                                <input type="text" name="choice" class="form-control" placeholder="输入选项内容" maxlength="100">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="options" value="0"> 正确标记</label>
                                </span>
                            </div>

                            <div id="add_choose" class="input-group space">
                                <span id="choose_no" class="input-group-addon">备选选项</span>
                                <input type="text" name="choice" class="form-control" placeholder="输入选项内容" maxlength="100">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="options" value="1"> 正确标记</label>
                                </span>
                            </div>

                            <div id="add_choose" class="input-group space">
                                <a id="delete_choose" class="input-group-addon">删除本项</a>
                                <input type="text" name="choice" class="form-control" placeholder="输入选项内容" maxlength="100">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="options" value="2"> 正确标记</label>
                                </span>
                            </div>

                            <div id="add_choose" class="input-group space">
                                <a id="delete_choose" class="input-group-addon">删除本项</a>
                                <input type="text" name="choice" class="form-control" placeholder="输入选项内容" maxlength="100">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="options" value="3"> 正确标记</label>
                                </span>
                            </div>

                            <div id="add_choose" class="input-group space">
                                <a id="delete_choose" class="input-group-addon">删除本项</a>
                                <input type="text" name="choice" class="form-control" placeholder="输入选项内容" maxlength="100">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="options" value="4"> 正确标记</label>
                                </span>
                            </div>
                        </div>

                        <div class="space_between">
                            <button class="btn btn-primary" id="add_new_choose">添加新选项</button>
                            <button class="btn btn-success" id="submit_question">提交本题</button>
                        </div>
                    </div>


                </div>
            </div>














            <!-- 建立试题集(组卷) -->
            <div id="info5" style="display:none">
                <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">
                    <h1 class="page-header">快速组卷</h1>
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <input type="radio" name="add_ques_to_where" value="0" checked>
                                已有试卷
                            </label>
                            <div class="col-sm-5">
                                <select class="form-control" id="add_ques_to_list_selector">
                                    <option value="-1">请选择一套试卷</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">
                                <input type="radio" name="add_ques_to_where" value="1">
                                新的试卷
                            </label>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" id="add_ques_to_new_test_name" placeholder="输入新的考试标题" maxlength="30">
                            </div>
                            <div class="col-sm-2">
                                <button type="button" onclick="submit_add_ques_to_test()" class="btn btn-primary">提交</button>
                            </div>

                    </div>

                    <h5 class="sub-header">
                        请从下方题库勾选要加入本题集的试题：
                    </h5>

                    <table class="table table-bordered table-hover table-striped table-condensed c">
                        <thead>
                            <tr>
                                <td width="30px"> </td>
                                <td width="">题干预览</td>
                                <td width="70px">正确率</td>
                                <td width="170px">操作</td>
                                <td width="70px"><label><input type='checkbox' id='all_page5'> 全选</label></td>
                            </tr>
                        </thead>
                        <tbody id="Ques_List_add">
                        </tbody>
                    </table>

                    <div id="content">
                        <div class="table-responsive">

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

<?php echo $page_script; ?>

<?php include 'userinfo_modal.php'?>





<!-- q_view Modal -->
<div class="modal fade" id="q_view_modal" tabindex="" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">题目</h4>
            </div>

            <div class="modal-body">
                <div class="space_between space">
                    <div class="flex_block" id="q_view_qid"></div>
                    <div class="flex_block" id="q_view_teacherName"></div>
                </div>
                <div id="q_view_content" class="space"></div>
                <div id="q_view_choices" class="space"></div>
                <div id="q_view_answer"></div>
                <div id="q_view_data"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
            </div>
        </div>
    </div>
</div>







<!-- q_edit Modal -->
<div class="modal fade" id="q_edit_modal" tabindex="" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">编辑题目</h4>
            </div>

            <div class="modal-body">
                        <div class="input-group space">
                            <span class="input-group-addon">题目内容</span>
                            <textarea type="textarea" id="edit_content" class="form-control" placeholder="输入题目内容" rows="5" style="resize:none"></textarea>
                        </div>


                        <div id="edit_chooses">
                            <div class="input-group space">
                                <span id="choose_no" class="input-group-addon">备选选项</span>
                                <input type="text" id="edit_choice_0" name="edit_choice" class="form-control" placeholder="输入选项内容">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="edit_options" value="0"> 正确标记</label>
                                </span>
                            </div>

                            <div class="input-group space">
                                <span id="choose_no" class="input-group-addon">备选选项</span>
                                <input type="text" id="edit_choice_1" name="edit_choice" class="form-control" placeholder="输入选项内容">
                                <span class="input-group-addon">
                                    <label><input type="radio" name="edit_options" value="1"> 正确标记</label>
                                </span>
                            </div>

                        </div>

                        <div><button class="btn btn-primary" id="edit_add_new_choose">添加新选项</button></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
                <button type="button" class="btn btn-primary" id="submit_question_edit">保存</button>
            </div>
        </div>
    </div>
</div>










<!-- test Modal -->
<div class="modal fade" id="test_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="test_modal_title">新的考试</h4>
      </div>
      <div class="modal-body">

        <div class="form-horizontal">
            <div class="form-group">
                <label for="test_name" class="col-sm-3 control-label">试卷标题 *</label>
                <div class="col-sm-8">
                <input type="text" class="form-control" id="test_name" placeholder="考试标题" maxlength="30">
                </div>
            </div>

            <div class="form-group">
                <label for="test_subject" class="col-sm-3 control-label">科目</label>
                <div class="col-sm-8">
                <input type="text" class="form-control" id="test_subject" placeholder="临床麻醉" maxlength="20">
                </div>
            </div>

            <div class="form-group">
                <label for="test_timeLimit" class="col-sm-3 control-label">限时 (min)</label>
                <div class="col-sm-3">
                <input type="number" class="form-control" id="test_timeLimit" placeholder="90" maxlength="3"> 
                </div>
            </div>

            <div class="form-group">
                <label for="test_subject" class="col-sm-3 control-label">状态 *</label>
                <div class="col-sm-8">
                    <div class="radio">
                    <label>
                        <input type="radio" name="test_status" id="test_status1" value="0" checked>
                        未开放
                    </label>
                    </div>
                    <div class="radio">
                    <label>
                        <input type="radio" name="test_status" id="test_status2" value="1">
                        开考中
                    </label>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="test_subject" class="col-sm-3 control-label">成绩 *</label>
                <div class="col-sm-6">
                <div class="radio">
                    <label>
                        <input type="radio" name="test_show_score" id="test_show_score1" value="0" checked>
                        未公布
                    </label>
                    </div>
                    <div class="radio">
                    <label>
                        <input type="radio" name="test_show_score" id="test_show_score2" value="1">
                        可查询
                    </label>
                    </div>
                </div>
            </div>

            <div class="form-group" id="test_modal_delete">
                <label for="test_subject" class="col-sm-3 control-label">操作</label>
                <div class="col-sm-2">
                    <button class="btn btn-danger" onclick="delete_test()">删除考试</button>
                </div>   
                <div class="checkbox col-sm-5">
                    <label><input type="checkbox" id="delete_test_history_also_checkbox"> 同时删除考生答题记录</label>
                </div>
            <div>

        </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
        <button type="button" class="btn btn-primary" id="test_modal_save">保存</button>
      </div>
    </div>
  </div>
</div>











</body>

</html>