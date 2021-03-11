var global_list;
$(document).ready(function () {
    loadingData();//试题记录

    Test_Set_Dropdown();

    $("#update_user_name").click(function(){
        update_user_name();
    });

    $("#update_psw").click(function(){
        update_psw();
    });

    $("#go_test").click(function(){
        var selected_test = $("#choose_set_test").children('option:selected').val()
        
        if(selected_test=='-1')
        {
            alert("请先选择题库");
        }else{
            window.location = "/ExamSys/index.php/Pages/test/" + selected_test;
        }
    });
});

function Test_Set_Dropdown()
{
    $.ajax({
        url: '/ExamSys/index.php/StuInfo/getOpenTests',
        type: 'POST',
        data: {},
        dataType: 'json',
        success: function (data) {
            // console.log('getOpenTests', data[0]['QsetId']);
            var drop_html = "<option value='-1'>请选择考试</option>";
            for (var i = 0; i < data.length; i++){
                drop_html += "<option value='" + data[i]['id'] + "'>" + data[i]['name'] + "</option>";
            }

            $("#choose_set_test").html(drop_html);

        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    });
}

function loadingData(setid = $("#choose_set_stu").val()) {
    
    $.ajax({
        url: '/ExamSys/index.php/StuInfo',
        type: 'POST',
        data: {},
        dataType: 'json',
        success: function (data) {
            console.log('StuInfo', data);
            var list = data.data;
            // console.log(list);
            ajaxSuccess(list);

        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })

}


//把ajax相同部分封装成函数调用
function ajaxSuccess(list) {
    var html = '';
    global_list = list;

    if(list.length == 0){
        html += '<tr>';
        html += '<td colspan="4">暂无数据</td>';
        html += '</tr>';
    }else{
        for (var i = 0; i < list.length; i++) {
            html += '<tr>';
            html += '<td>' + (i + 1) + '</td>';
            html += '<td>' + list[i]['start'] + '</td>';
            html += '<td>' + list[i]['name']+ '</td>';
            if(list[i]['status'] == 1){
                html += '<td><a href="/ExamSys/index.php/Pages/test/' + list[i]['id'] + '">继续考试</a></td>';
            }else{
                if(list[i]['show_score'] == 1){
                    html += '<td><a href="javascript:show_score(' + i + ');">查看成绩</a></td>';
                }else{
                    html += '<td>成绩待公布</td>';
                }
                
            }
            html += '</tr>';
        }
    }
    
    $('#GradeView').html(html);
}

function show_score(i){
    // console.log(global_list[i]);
    let data = global_list[i];
    alert('考试：' + data['name'] + '\n科目：' + data['subject'] + '\n时间：' + data['start'] + '\n分数：' + data['score'] + ' 分');
}