var stuAccount, test_id, current_question, ques_left, current_qid, current_process;

/// 答题计时器
// function two_char(n) {
//     return n >= 10 ? n : "0" + n;
// }
// function time_fun() {
//     var sec = 0;
//     setInterval(function () {
//         sec++;
//         var date = new Date(0, 0)
//         date.setSeconds(sec);
//         var h = date.getHours(), m = date.getMinutes(), s = date.getSeconds();
//         $("#timer").text("答题计时：" + two_char(h) + ":" + two_char(m) + ":" + two_char(s));
//     }, 1000);
// }

function start_test(stuAccount, test_id) {
    $.ajax({
        type: "POST",
        url: "/ExamSys/index.php/Test/startTest",
        dataType: "JSON",
        data: {
            stuAccount: stuAccount,
            test_id: test_id
        },
        success: function (data) {
            console.log('startTest', data);
            if(data.result == 1){
                location.reload();
            }else{
                alert(data.err_msg);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
};

function AquireQuestion(sid, tid) {
    stuAccount = sid;
    test_id = tid;

    $.ajax({
        type: "POST",
        url: "/ExamSys/index.php/Test/AquireQues",
        dataType: "JSON",
        data: {
            stuAccount: sid,
            test_id: tid
        },
        success: function (data) {
            console.log('AquireQues', data);
            display_next(data);
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function finish_test(){
    if(ques_left.length > 0){
        if(confirm('您还有题目没有答完，确定交卷吗？')){
            finish_test_core();
        }
    }else{
        if(confirm('确定交卷吗？')){
            finish_test_core();
        }
    }
}

function finish_test_core(){
    $.ajax({
        type: "POST",
        url: "/ExamSys/index.php/Test/finish_test",
        dataType: "JSON",
        data: {
            stuAccount: stuAccount,
            tid: test_id
        },
        success: function (data) {
            console.log('finish_test', data);
            if(data.success == 1){
                alert('提交完成！祝您取得理想成绩！');
                location.href = '/ExamSys/index.php/Pages/student';
            }else{
                alert(data.err_msg);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function submit_n_next(){
    //获得选项，如果没选则提示
    var stuChoice = $("input[type='radio']:checked").val();
    if(stuChoice == undefined){
        alert('请选择答案');
    }else{
        var correct = 0;
        //分析答案是否正确 - 单选
        if(current_question['choices'][stuChoice]['a'] == 1){
            correct = 1;
        }

        $.ajax({
            type: "POST",
            url: "/ExamSys/index.php/Test/submit_n_show_next",
            dataType: "JSON",
            data: {
                stuAccount: stuAccount,
                tid: test_id,
                qid: current_question['qid'],
                stuChoice: stuChoice,
                correct: correct
            },
            success: function (data) {
                console.log('submit_n_show_next', data);
                display_next(data);
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        })
    }
}

function display_next(data){
    $('#probar').css('width', data.percentage + "%");
    $('#ques_left').text("已答/剩余: " + data.already_done.length + " / " +data.ques_left.length);
    $('#percent').text("完成进度：" + data.percentage + "%");
    ques_left = data.ques_left;
    let next_question_id = null;
    if(data.next_question){
        next_question_id = data.next_question.qid;
    }
    current_process = {
        'already_done': data.already_done,
        'next_question_id': next_question_id,
        'ques_left_R': data.ques_left_R,
        'marks': data.marks
    };
    // console.log('current_process', current_process);

    if (data.msg == "generated") {
        current_question = data.next_question;
        current_qid = data.next_question.qid;
        $('#QuesInfo').text("第 " + data.next_question_order + " 题");
        $('#question_type').text("选择题");
        $('#QuesContent').text(data.next_question.question_content);
        $('#ctrl_button').html("<button onclick='submit_n_next()' class='btn btn-primary'>提交本题</button>");
        display_mark_btn(data.undone_marked);

        let choices = data.next_question.choices;
        let h= '';
        for (var j = 0; j < choices.length; j++) {
            h += "<div class='radio'><label>" +
                "<input type='radio' name='answer' value='" + j + "'> (" + numberTOalphabet(j) + ') ' + choices[j]['c'] +
                "</label></div>";
        }
        $('#choices').html(h);

    } else if (data.msg == "finished") {
        current_qid = null;
        console.log('finished');
        $('#QuesInfo').text("题目已答完");
        $('#QuesContent').text("您可以检查已答题目，或提交试卷。");
        $('#question_type').text("");
        $('#ctrl_button').html("<button onclick='finish_test()' class='btn btn-primary'>交卷</button>");
        $('#mark_button').html("");
        $('#choices').html("");
    }
    getBoxes(data);
}

function getBoxes(data){
    let h = '';
    let i = 1;
    let current_css_str, marked_css_str;
    
    //已做
    data.already_done.forEach(v => {
        if(current_qid == v){
            current_css_str = 'current_question ';
        }else{
            current_css_str = '';
        }
        marked_css_str = '';
        data.marks.forEach(m => {
            if(m.qid == v && m.marked == 1){
                marked_css_str = 'marked_box ';
            }
        })
        h += '<div><a class="already_done_box ' + marked_css_str + current_css_str + '" href="javascript:reviewQues(' + v + ',' + i + ')">' + i + '</a></div>';
        i ++ ;
    });
    //当前
    let id_;
    if(data.next_question){
        id_ = data.next_question.qid;
    }else{
        id_ = data.next_question_id;
    }
    if(id_){
        if(current_qid == id_){
            current_css_str = 'current_question';
        }else{
            current_css_str = '';
        }

        marked_css_str = '';
        data.marks.forEach(m => {
            if(m.qid == id_ && m.marked == 1){
                marked_css_str = 'marked_box ';
            }
        })
        h += '<div><a class="ques_next_box ' + marked_css_str + current_css_str + '" href="javascript:reviewQues(' + id_ + ',' + i + ')">' + i + '</a></div>';
        i ++ ;
    }
    
    //未做
    data.ques_left_R.forEach(v => {
        h += '<div class="ques_left_box">' + i + '</div>';
        i ++ ;
    });
    // console.log(h);
    $('#boxes').html(h);
}

function reviewQues(qid, i){
    $.ajax({
        type: "POST",
        url: "/ExamSys/index.php/Test/reviewQuestion",
        dataType: "JSON",
        data: {
            qid: qid,
            tid: test_id
        },
        success: function (data) {
            console.log('reviewQuestion', data);
            if(data.done){
                let question = data.data;
                current_qid = question.qid;
                current_question = question;
                $('#QuesInfo').text("第 " + i + " 题");
                $('#question_type').text("选择题");
                $('#QuesContent').text(question.snapshot_content);
                display_mark_btn(question.marked);

                //自选到最新一题，提交后会自动转跳到下一题
                if(qid == current_process.next_question_id){
                    $('#ctrl_button').html("<button onclick='submit_n_next()' class='btn btn-primary'>提交本题</button>");
                    // console.log('自选到最新一题，提交后会自动转跳到下一题');
                }else{
                    $('#ctrl_button').html("<button onclick='updateAnswer(" + question.id + ")' class='btn btn-primary'>更新本题</button>");
                }
                
                let choices = question.choices ;
                let h = '';
                for (var j = 0; j < choices.length; j++) {
                    h += "<div class='radio'><label>" +
                        "<input type='radio' name='answer' value='" + j + "'> (" + numberTOalphabet(j) + ') ' + choices[j]['c'] +
                        "</label></div>";
                }
                $('#choices').html(h);
                if(question.stuChoice){
                    $("input[name='answer']").get(question.stuChoice).checked=true;
                } 
                getBoxes(current_process);
            }
            
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
}

function updateAnswer(history_id){
    var stuChoice = $("input[type='radio']:checked").val();
    if(stuChoice == undefined){
        alert('请选择答案');
    }else{
        var correct = 0;
        //分析答案是否正确 - 单选
        if(current_question['choices'][stuChoice]['a'] == 1){
            correct = 1;
        }
    
        $.ajax({
            type: "POST",
            url: "/ExamSys/index.php/Test/updateAnswer",
            dataType: "JSON",
            data: {
                history_id: history_id,
                stuChoice: stuChoice,
                correct: correct
            },
            success: function (data) {
                console.log('updateAnswer', data);
                if(data.success == 1){
                    alert('已保存新的答案');
                }else{
                    alert(data.err_msg);
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        })
    }
    
}

function display_mark_btn(marked){
    // console.log('update mark', marked);
    if(marked == 1){
        $('#mark_button').html('<a href="javascript:set_mark(0);" class="marked"><span class="glyphicon glyphicon-star" aria-hidden="true"></span>标记</a>');
    }else{
        $('#mark_button').html('<a href="javascript:set_mark(1);" class="unmarked"><span class="glyphicon glyphicon-star-empty" aria-hidden="true"></span>标记</a>');
    }
}

function set_mark(marked){
    $.ajax({
        type: "POST",
        url: "/ExamSys/index.php/Test/set_mark",
        dataType: "JSON",
        data: {
            marked: marked,
            qid: current_qid,
            tid: test_id
        },
        success: function (data) {
            console.log('set_mark', data);
            if(data.result == 1){
                display_mark_btn(marked);
                current_process.marks = data.marks;
                getBoxes(current_process);
            }else{
                alert(data.err_msg);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
}

