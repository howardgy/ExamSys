function update_user_name(){
    $.ajax({
        url: '/ExamSys/index.php/User/update_user',
        type: 'POST',
        data: {
            value: $("#user_name").val(),
            field: 'name'
        },
        dataType: 'json',
        success: function (data) {
            console.log('update_user', data);
            if(data.result == 1){
                alert('已更新');
                window.location.href = "/ExamSys";
            }else{
                alert(data.err_msg);
            }
        },
        error: function (XMLHttpRequest) {
            console.log(XMLHttpRequest.responseText);
        }
    })
}

function update_psw(){
    let psw1 = $("#user_psw1").val();
    let psw2 = $("#user_psw2").val();
    let psw3 = $("#user_psw3").val();

    if(psw1 == '' || psw2 == '' || psw3 == ''){
        alert('请填写完整');
    }else{
        if(psw2 != psw3){
            alert('两次密码输入不一致');
            $("#user_psw2").val('').focus();
            $("#user_psw3").val('');
        }else{
            $.ajax({
                url: '/ExamSys/index.php/User/update_user',
                type: 'POST',
                data: {
                    psw_old: md5(psw1),
                    value: md5(psw2),
                    field: 'psw'
                },
                dataType: 'json',
                success: function (data) {
                    console.log('update_user', data);
                    if(data.result == 1){
                        alert('已更新');
                        $("#user_psw1").val('');
                        $("#user_psw2").val('');
                        $("#user_psw3").val('');

                    }else if(data.err_msg == 'old_psw_wrong'){
                        alert('原密码不正确');
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
}