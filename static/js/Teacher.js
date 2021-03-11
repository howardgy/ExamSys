var current_test_modal_tid, test_modal_submit_type;
var ques_ctrl_tid, current_edit_qid;

var goto_page = (page) => {
    var page_count = 5, infos = [], clicks = [];
    for(i = 0; i < page_count; i ++){
        infos[i] = '#info' + (i + 1);
        clicks[i] = '#click' + (i + 1);
    }
    infos.splice(page - 1, 1);
    clicks.splice(page - 1, 1);
    var rest_info_str = infos.join(',');
    var rest_click_str = clicks.join(',');

    $(rest_info_str).hide();
    $("#info" + page).show();
    $(rest_click_str).removeClass("active");
    $("#click" + page).addClass("active");
};

var init_page1 = () => {
    goto_page(1);
    loadPage1();
}
var init_page2 = () => {
    goto_page(2);
    loadPage2();
}

var init_page3 = (tid = -1) => {
    goto_page(3);
    loadPage3(tid);
}

var init_page4 = () => {
    goto_page(4);
}

var init_page5 = () => {
    goto_page(5);
    loadPage5();
}

// var ques_i = 5;




















$(document).ready(function(){

    $("#click1").click(function(){
        init_page1();
    });

    $("#click2").click(function(){
        init_page2();
    });

    $("#click3").click(function(){
        init_page3();
    });

    $("#click4").click(function(){
        init_page4();
    });

    $("#click5").click(function(){
        init_page5();
    });

    $("#update_user_name").click(function(){
        update_user_name();
    });

    $("#update_psw").click(function(){
        update_psw();
    });

    $("#test_modal_save").click(function(){
        submit_test_modal_form(test_modal_submit_type);
    });

    $("#add_new_test").click(function(){
        $("#test_modal_title").html('添加新的考试');
        test_modal_submit_type = 0;
        $("#test_modal_delete").hide();
        test_modal_init({
            'name': '',
            'subject': '',
            'timeLimit': '',
            'status': 0,
            'show_score': 0,
        });
    });


    $("#edit_add_new_choose").click(function () {
        let h = '';
        h += '<div class="input-group space">';
        h += '<a id="edit_delete_choice" class="input-group-addon">删除本项</a>';
        h += '<input type="text" name="edit_choice" class="form-control" placeholder="输入选项内容" maxlength="100">';
        h += '<span class="input-group-addon">';
        h += '<label><input type="radio" name="edit_options"> 正确标记</label>';
        h += '</span>';
        h += '</div>';
    
        $("#edit_chooses").append(h).find("a#edit_delete_choice").click(function () {
            $(this).parent().remove();
        })
    });

    $("#submit_question_edit").click(function(){
        var edit_content = $('#edit_content').val();
        var edit_choices = [];
        if(edit_content == null || edit_content == ""){
            alert('请填写完整');
            return;
        }
        
        let finished = true;
        $("input[name='edit_choice']").each(function(){
            let v = $(this).val();
            if(v == null || v == ""){
                finished = false;
            }else{
                edit_choices.push({
                    'c': $(this).val(),
                    'a': null
                })
            }
        });
        if(finished == false){
            alert('请填写完整');
            return;
        }

        let options_count = 0;
        $("input[name='edit_options']").each(function(i){
            let v = 0;
            if($(this).is(":checked")){
                v = 1;
            }
            edit_choices[i]['a'] = v;
            options_count += v;
        });
        if(options_count == 0){
            alert('请选择正确答案');
            return;
        }
        // console.log(edit_content, edit_choices);
        //current_edit_qid

        $.ajax({
            url: "/ExamSys/index.php/Teacher/update_question",
            type: "POST",
            dataType: 'json',
            data: {
                "content": edit_content,
                "choices": edit_choices,
                "qid": current_edit_qid
            },
            success: function (data) {
                console.log('update_question', data);
                if(data.success == 1){
                    $('#q_edit_modal').modal('toggle');
                    // loadPage2();
                }else{
                    alert(data.err_msg);
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        });
    });

    $("#choose_test_to_show_ques").change(function(){
        var tid = $(this).children('option:selected').val();
        loadQues_by_tid(tid);
    });

    $("#add_new_choose").click(function () {
        // ques_i++;
        $("#chooses").append(
            " <div id='add_choose' class='input-group space'>" +
            " <a id='delete_choose' class='input-group-addon'>删除本项</a>" +
            " <input type='text' name='choice' class='form-control' placeholder='输入选项内容' maxlength='100'>" +
            " <span class='input-group-addon'>" +
            " <label><input type='radio' name='options'> 正确标记" +
            " </span></label>" +
            " </div>"
        ).find("a#delete_choose").click(function () {
            $(this).parent().remove();
        })
    });

    $("a#delete_choose").click(function () {
        $(this).parent().remove();
    })

    //添加新题目
    $('#submit_question').click(function () {
        var content = $('#this_content').val();
        var choices = [];
        if(content == null || content == ""){
            alert('请填写完整');
            return;
        }
        
        let finished = true;
        $("input[name='choice']").each(function(){
            let v = $(this).val();
            if(v == null || v == ""){
                finished = false;
            }else{
                choices.push({
                    'c': $(this).val(),
                    'a': null
                })
            }
        });
        if(finished == false){
            alert('请填写完整');
            return;
        }

        let options_count = 0;
        $("input[name='options']").each(function(i){
            let v = 0;
            if($(this).is(":checked")){
                v = 1;
            }
            choices[i]['a'] = v;
            options_count += v;
        });
        if(options_count == 0){
            alert('请选择正确答案');
            return;
        }
        // console.log(choices);

        $.ajax({
            url: "/ExamSys/index.php/Teacher/RecordQues",
            type: "POST",
            dataType: 'json',
            data: {
                "content": content,
                "choices": choices
            },
            success: function (data) {
                console.log('RecordQues', data);
                if(data.success == 1){
                    alert('添加成功！');
                    $('#this_content').val("").focus();
                    $("input[name='choice']").each(function(){
                        $(this).val("");
                    });
                    $("input[name='options']").each(function(){
                        $(this).prop("checked", false);
                    });
                }else{
                    alert('添加失败', data.err_msg);
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        });
    });

});











function loadQues_by_tid(tid){
    $.ajax({
        url: '/ExamSys/index.php/Teacher/loadQues',
        type: 'POST',
        data: {
            tid: tid
        },
        dataType: 'json',
        success: function (data) {
            console.log('loadQues', data);
            load_table_on_page3(data['data'], tid);
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function delete_a_ques(qid, refresh_page){
    if(confirm("您确定要删除该题目吗？")){
        $.ajax({
            url: '/ExamSys/index.php/Teacher/delete_question',
            type: 'POST',
            data: {
                qid: qid
            },
            dataType: 'json',
            success: function (r) {
                console.log('delete_question', r);
                if(r.question_affected = 1){
                    //refresh page
                    if(refresh_page == 0){
                        loadPage3();
                    }else{
                        loadPage5();
                    }
                }else{
                    alert({
                        'delete_question': r.delete_question,
                        'ques_included_affected': r.ques_included_affected
                    })
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        })
    }
}


function q_view(qid){
    $.ajax({
        url: '/ExamSys/index.php/Teacher/get_question',
        type: 'POST',
        data: {
            qid: qid
        },
        dataType: 'json',
        success: function (r) {
            console.log('get_question', r);
            $("#q_view_qid").text("QID: " + qid);
            $("#q_view_teacherName").text("录入：" + r.question.teacherName);
            $("#q_view_content").text(r.question.content);

            let choices = r.question.choices;
            let h = '';
            let a = '答案：';
            for (var j = 0; j < choices.length; j++) {
                h += "<div>(" + numberTOalphabet(j) + ") " + choices[j]['c'] + "</div>";
                if(choices[j]['a'] == 1){
                    a += numberTOalphabet(j);
                }
            }
            $('#q_view_choices').html(h);
            $('#q_view_answer').html(a);
            $('#q_view_data').html("<div>已作答："+r.question.tested_count+"人</div><div>正确率："+r.question.difficulty+"</div>");
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
}


function submit_test_modal_form(type){
    let name = $("#test_name").val();
    if(name == ""){
        alert("请填写完整");
    }else{
        let data = {
            'name': $("#test_name").val(),
            'subject': $("#test_subject").val(),
            'timeLimit': parseInt($("#test_timeLimit").val()),
            'status': $("input[name='test_status']:checked").val(),
            'show_score': $("input[name='test_show_score']:checked").val(),
        };
        // console.log(data);

        if(type == 0){
            //new test
            $.ajax({
                url: '/ExamSys/index.php/Teacher/add_test',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (r) {
                    console.log('add_test', r);
                    if(r.success == 1){
                        $('#test_modal').modal('toggle');
                        loadPage2();
                    }else{
                        alert(r.err_msg);
                    }
                },
                error: function (XMLHttpRequest) {
                    console.log(XMLHttpRequest.responseText);
                }
            })
            
        }else{
            //update test
            data.tid = current_test_modal_tid;
            $.ajax({
                url: '/ExamSys/index.php/Teacher/update_test',
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (r) {
                    console.log('update_test', r);
                    if(r.success == 1){
                        $('#test_modal').modal('toggle');
                        loadPage2();
                    }else{
                        alert(r.err_msg);
                    }
                },
                error: function (XMLHttpRequest) {
                    console.log(XMLHttpRequest.responseText);
                }
            })
        }
    }
    
}

function test_modal_init(data){
    $("#test_name").val(data.name).focus();
    $("#test_subject").val(data.subject);
    $("#test_timeLimit").val(data.timeLimit);
    if(data.status == 0){
        $("input[name='test_status']").get(0).checked=true; 
    }else{
        $("input[name='test_status']").get(1).checked=true; 
    }
    if(data.show_score == 0){
        $("input[name='test_show_score']").get(0).checked=true; 
    }else{
        $("input[name='test_show_score']").get(1).checked=true; 
    }

    $('#test_modal').on('shown.bs.modal', function () {
        $('#test_name').focus()
    })
}

function loadPage1() {
    $.ajax({
        url: '/ExamSys/index.php/Teacher/loadScores',
        type: 'POST',
        data: {},
        dataType: 'json',
        success: function (data) {
            console.log('loadScores', data['result']);
            if(data['result'].length == 0)
            {
                /// 没有数据了
                var empty_tip = "<tr><td colspan='7' class='c'>没有数据</td></tr>";
                $('#scoreView').html(empty_tip);
            }else{
                let info = data['result'];
                var h = ''
                for (var i = 0; i < info.length; i++) {
                    h += '<tr>';
                    h += '<td>' + (i + 1) + '</td>';
                    h += '<td>' + info[i].stuAccount + '</td>';
                    h += '<td>' + info[i].stuName + '</td>';
                    h += '<td>' + info[i].test_name + '</td>';
                    h += '<td>' + info[i].score + '</td>';
                    h += '<td>' + info[i].finish + '</td>';
                    h += '<td class="c">';
                    h += '<button onclick="view_test(' + info[i].test_id + ',' + info[i].stuAccount + ','+ info[i].id +')" class="btn btn-default btn-sm">查看试卷</button> ';
                    h += '<button onclick="delete_test_history(' + info[i].id + ')" class="btn btn-danger btn-sm btn-viewques">删除</button>';
                    h += '</td>';
                    h += '</tr>';
                }
                $('#scoreView').html(h);
            }
            
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
}

function delete_test_history(test_history_id){
    if(confirm("该操作不可恢复，确定要删除该考试记录吗？")){
        $.ajax({
            url: '/ExamSys/index.php/Teacher/delete_test_history',
            type: 'POST',
            data: {
                test_history_id: test_history_id
            },
            dataType: 'json',
            success: function (data) {
                console.log('delete_test_history', data);
                
                if(data.test_history_affected == 1){
                    loadPage1();
                }else{
                    alert(data);
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        });
    }
}


function loadPage2() {
    $.ajax({
        url: '/ExamSys/index.php/Teacher/loadTests',
        type: 'POST',
        data: {},
        dataType: 'json',
        success: function (data) {
            console.log('loadTests', data['result']);
            if(data['result'].length == 0)
            {
                /// 没有数据了
                var empty_tip = "<tr><td colspan='7'>没有数据</td></tr>";
                $('#Ques_List').html(empty_tip);
            }else{
                let info = data['result'];
                let h = '';
                for (var i = 0; i < info.length; i++) {
                    h += '<tr>';
                    h += '<td>' + info[i].id + '</td>';
                    h += '<td>' + info[i].name + '</td>';
                    h += '<td>' + info[i].q_count + '</td>';
                    h += '<td>' + info[i].student_count + '</td>';
                    h += '<td>' + info[i].teacherName + '</td>';
                    h += '<td>' + info[i].timestamp + '</td>';
                    h += '<td class="c">';
                    h += '<button onclick="view_test(' + info[i].id + ')" class="btn btn-default btn-sm">预览试卷</button> ';
                    h += '<button onclick="view_ques_in_test(' + info[i].id + ')" class="btn btn-default btn-sm">管理试题</button> ';
                    h += '<button onclick="update_test_button(' + info[i].id + ')" class="btn btn-default btn-sm">设置</button>';
                    h += '</td>';
                    h += '</tr>';
                }
                $('#Ques_List').html(h);
            }
            
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function view_test(tid, stuAccount = null, tets_history_id = null){
    if(stuAccount == null){
        window.location.href = "/ExamSys/index.php/Pages/sheet/" + tid;
    }else{
        window.location.href = "/ExamSys/index.php/Pages/sheet/" + tid + "/" + stuAccount + "/" + tets_history_id;
    }
}

function view_ques_in_test(tid){
    init_page3(tid);
}

function delete_test(){
    if(confirm('该操作无法撤回，确定吗？')){
        let delete_test_history_also = 0;
        if($('#delete_test_history_also_checkbox').is(':checked')) {
            delete_test_history_also = 1;
        }
        $.ajax({
            url: '/ExamSys/index.php/Teacher/delete_test',
            type: 'POST',
            data: {
                tid: current_test_modal_tid,
                delete_test_history_also: delete_test_history_also
            },
            dataType: 'json',
            success: function (data) {
                console.log('delete_test', data);
                
                if(data.test_affected == 1){
                    $('#test_modal').modal('toggle');
                    loadPage2();
                }else{
                    alert({
                        'test_affected': data.test_affected,
                        'ques_included_affected': data.ques_included_affected,
                        'test_history_affected': data.test_history_affected
                    });
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        });
    }
}

function update_test_button(tid){
    $("#test_modal_title").html('设置考试');
    current_test_modal_tid = tid;
    test_modal_submit_type = 1;
    $("#test_modal_delete").show();

    $.ajax({
        url: '/ExamSys/index.php/Teacher/get_test',
        type: 'POST',
        data: {
            tid: tid
        },
        dataType: 'json',
        success: function (data) {
            console.log('get_test', data);
            test_modal_init({
                'name': data.test.name,
                'subject': data.test.subject,
                'timeLimit': data.test.timeLimit,
                'status': data.test.status,
                'show_score': data.test.show_score,
            });
            $('#test_modal').modal('toggle');
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
    
}

function loadPage3(tid = -1)
{
    $.ajax({
        url: '/ExamSys/index.php/Teacher/loadQues',
        type: 'POST',
        data: {
            tid: tid
        },
        dataType: 'json',
        success: function (data) {
            console.log('loadQues', data);
            load_table_on_page3(data['data'], tid);
            load_tests_on_page3(data['AllQuesSets'], tid);
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function load_table_on_page3(info, tid = -1)
{
    ques_ctrl_tid = tid;

    var h = "";
    if(info.length == 0){
        h ="<tr><td colspan='4'>暂无数据</td></tr>";
    }else{
        for (var i = 0; i < info.length; i++) {
            h += '<tr>';
            h += '<td>' + (i + 1) + '</td>';
            h += '<td align="left">' + info[i].content + '</td>';
            h += '<td>' + info[i].difficulty + '</td>';
            h += '<td>';
            if(tid != -1){
                h += '<button onclick="remove_ques_from_test(' + info[i].id + ')" class="btn btn-sm btn-default">移出试卷</button> ';
            }
            h += '<button class="btn btn-sm btn-default" onclick="q_view(' + info[i].id + ')" data-toggle="modal" data-target="#q_view_modal">查看</button> ';
            h += '<button onclick="q_edit(' + info[i].id + ')" data-toggle="modal" data-target="#q_edit_modal" class="btn btn-sm btn-default">编辑</button> ';
            h += '</td>';
            h += '</tr>';
        }
    }
    
    $('#Ques_List_ctrl').html(h);
}

function q_edit(qid){
    current_edit_qid = qid;
    $.ajax({
        url: '/ExamSys/index.php/Teacher/get_question',
        type: 'POST',
        data: {
            qid: qid
        },
        dataType: 'json',
        success: function (r) {
            console.log('get_question', r);
            
            $("#edit_content").val(r.question.content);
            $('#q_edit_modal').on('shown.bs.modal', function () {
                $('#edit_content').focus()
            })

            let h = '';
            for(i = 0; i < 2; i ++){
                h += '<div class="input-group space">';
                h += '<span id="edit_delete_choice" class="input-group-addon">备选选项</span>';
                h += '<input type="text" id="edit_choice_' + i + '" name="edit_choice" class="form-control" placeholder="输入选项内容" value="' + r.question.choices[i].c + '" maxlength="20">';
                h += '<span class="input-group-addon">';
                h += '<label><input type="radio" name="edit_options" value="' + i + '"> 正确标记</label>';
                h += '</span>';
                h += '</div>';
            }
            $("#edit_chooses").html(h);
            
            for(i = 2; i < r.question.choices.length; i ++){
                let h = '';
                h += '<div class="input-group space">';
                h += '<a id="edit_delete_choice" class="input-group-addon">删除本项</a>';
                h += '<input type="text" id="edit_choice_' + i + '" name="edit_choice" class="form-control" placeholder="输入选项内容" value="' + r.question.choices[i].c + '" maxlength="20">';
                h += '<span class="input-group-addon">';
                h += '<label><input type="radio" name="edit_options" value="' + i + '"> 正确标记</label>';
                h += '</span>';
                h += '</div>';

                $("#edit_chooses").append(h).find("a#edit_delete_choice").click(function () {
                    $(this).parent().remove();
                })
            }

            let correct_index;
            for(i = 0; i < r.question.choices.length; i ++){
                if(r.question.choices[i].a == 1){
                    correct_index = i;
                    break;
                }
            }
            // console.log(correct_index);
            $("input[name='edit_options']").get(correct_index).checked = true; 

        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
}


function remove_ques_from_test(qid){
    $.ajax({
        url: '/ExamSys/index.php/Teacher/remove_a_ques_from_test',
        type: 'POST',
        data: {
            qid: qid,
            tid: ques_ctrl_tid
        },
        dataType: 'json',
        success: function (data) {
            console.log('remove_a_ques_from_test', data);
            if(data.ques_included_affected == 1){
                loadQues_by_tid(ques_ctrl_tid);
            }else{
                alert(data);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function loadPage5()
{
    $.ajax({
        url: '/ExamSys/index.php/Teacher/loadQues',
        type: 'POST',
        data: {
            tid: -1
        },
        dataType: 'json',
        success: function (data) {
            console.log('loadQues', data);
            load_table_on_page5(data['data']);
            load_test_on_page5(data['AllQuesSets']);
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
    $("#all_page5").get(0).checked = false;
}

function load_tests_on_page3(data, tid){
    var drop_html = "<option value='-1'>全部题目</option>";
    for (var i = 0; i < data.length; i++)
    {
        drop_html += "<option value='" + data[i]['id'] + "'>试卷：" + data[i]['name'] + "</option>";
    }
    
    $("#choose_test_to_show_ques").html(drop_html);
    $("#choose_test_to_show_ques").find("option[value = '" + tid + "']").attr("selected","selected");

}

function load_test_on_page5(data){
    var drop_html = "<option value='-1'>请选择一套试卷</option>";
    for (var i = 0; i < data.length; i++)
    {
        drop_html += "<option value='" + data[i]['id'] + "'>" + data[i]['name'] + "</option>";
    }
    
    $("#add_ques_to_list_selector").html(drop_html);
}

function load_table_on_page5(info)
{
    var h = '';
    if(info.length == 0){
        h ="<tr><td colspan='5'>暂无数据</td></tr>";
    }else{
        for (var i = 0; i < info.length; i++) {
            h += '<tr>';
            h += '<td>' + (i + 1) + '</td>';
            h += '<td align="left">' + info[i].content + '</td>';
            h += '<td>' + info[i].difficulty + '</td>';
            h += '<td>';
            h += '<button class="btn btn-sm btn-default" onclick="q_view(' + info[i].id + ')" data-toggle="modal" data-target="#q_view_modal">查看</button> ';
            h += '<button onclick="delete_a_ques(' + info[i].id + ', 1)" class="btn btn-sm btn-default">删除</button> ';
            h += '<button onclick="q_edit(' + info[i].id + ')" data-toggle="modal" data-target="#q_edit_modal" class="btn btn-sm btn-default">编辑</button>';
            h += '</td>';
            h += '<td><input type="checkbox" name="check_page5" value="' + info[i].id + '"></td>';
            h += '</tr>';
        }
    }
    $('#Ques_List_add').html(h);

    $("#all_page5").click(function(){
        let flag = this.checked;
        $("input[name='check_page5']").each(function(){
            this.checked = flag;
        });
    });
}

function submit_add_ques_to_test(){
    let qids = [];
    $.each($('input[name="check_page5"]:checked'),function(){
        qids.push($(this).val());
    });
    if(qids.length == 0){
        alert("请选择要加入的题目");
        return;
    }

    let add_ques_to_where = $("input[name='add_ques_to_where']:checked").val();
    if(add_ques_to_where == 0){
        //已有
        let add_ques_to_list_selector = $("#add_ques_to_list_selector").val();
        if(add_ques_to_list_selector == -1){
            alert("请选择一套试卷");
            return;
        }else{
            add_ques_to_existing_test(qids, add_ques_to_list_selector);
        }
    }else{
        //新的
        let add_ques_to_new_test_name = $("#add_ques_to_new_test_name").val();
        if(add_ques_to_new_test_name == ""){
            alert("请输入试卷标题");
            return;
        }else{
            add_ques_to_new_test(qids, add_ques_to_new_test_name);
        }
    }
}

function add_ques_to_existing_test(qids, tid){
    $.ajax({
        url: '/ExamSys/index.php/Teacher/add_ques_to_existing_test',
        type: 'POST',
        data: {
            qids: qids,
            tid: tid
        },
        dataType: 'json',
        success: function (data) {
            console.log('add_ques_to_existing_test', data);
            if(data.success == 1){
                alert("添加成功");
            }else{
                alert(data.err_msg);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function add_ques_to_new_test(qids, test_name){
    $.ajax({
        url: '/ExamSys/index.php/Teacher/add_ques_to_new_test',
        type: 'POST',
        data: {
            qids: qids,
            test_name: test_name
        },
        dataType: 'json',
        success: function (data) {
            console.log('add_ques_to_new_test', data);
            if(data.success == 1){
                alert("添加成功");
                loadPage5();
                $("#add_ques_to_new_test_name").val("");
                $("input[name='add_ques_to_where']").get(0).checked = true;
            }else{
                alert(data.err_msg);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}