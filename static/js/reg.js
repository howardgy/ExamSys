var regUsername = /^[a-zA-Z\u4e00-\u9fa5]+$/;
var regUserid = /^[0-9a-zA-Z]+$/;
// var regPasswordSpecial = /[~!@#%&=;':",./<>_\}\]\-\$\(\)\*\+\.\[\?\\\^\{\|]/;
// var regPasswordAlpha = /[a-zA-Z]/;
// var regPasswordNum = /[0-9]/;
var password;
var check = [true, false, false, false, false];

//校验成功函数
function success(Obj, counter) {
    Obj.parent().parent().removeClass('has-error').addClass('has-success');
    $('.tips').eq(counter).hide();
    $('.glyphicon-ok').eq(counter).show();
    $('.glyphicon-remove').eq(counter).hide();
    check[counter] = true;

}

// 校验失败函数
function fail(Obj, counter, msg) {
    Obj.parent().parent().removeClass('has-success').addClass('has-error');
    $('.glyphicon-remove').eq(counter).show();
    $('.glyphicon-ok').eq(counter).hide();
    $('.tips').eq(counter).text(msg).show();
    check[counter] = false;
}


// 邀请码
// $('.container').find('input').eq(0).change(function () {
//     if ($(this).val().length == '') {
//         fail($(this), 0, '请输出邀请码');
//     } else {
//         success($(this), 0);
//     }
// });


// 用户名匹配
$('.container').find('input').eq(1).change(function () {
    if (regUsername.test($(this).val())) {
        success($(this), 1);
    } else {
        fail($(this), 1, '姓名只能为中文或英文，不能包含其他符号')
    }
});



$('.container').find('input').eq(2).change(function () {
    
    if ($(this).val().toString().length < 4) {
        fail($(this), 2, '账号不能少于4个字符');
        return;

    }else if(regUserid.test($(this).val())) {
        // 校验学号工号是否已存在
        let UserId = $(this).val();
        let type = $("#type option:selected").val();
        
        let that = this;
        $.ajax({
            type: "POST",
            url: "/ExamSys/index.php/User/regCheck",
            data: {
                "UserId": UserId,
                "type": type
            },
            success: function (data) {
                if(data == 'exist'){
                    fail($(that), 2, '此账号已经注册过！');
                }else{
                    success($(that), 2);
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        });
    } else {
        fail($(this), 2, '只能由数字和字母组成');
    }

});



// 密码匹配
$('.container').find('input').eq(3).change(function () {
    password = $(this).val();

    if ($(this).val().length < 1) {
        fail($(this), 3, '密码太短');
    } else {
        success($(this), 3);
    }
});


// 再次输入密码校验
$('.container').find('input').eq(4).change(function () {

    if ($(this).val() == password) {
        success($(this), 4);
    } else {

        fail($(this), 4, '两次输入的密码不一致');
    }

});




$('#submit').click(function (e) {
    
    if (!check.every(function (value) {
        return value == true
    })) {
        e.preventDefault();
        for (key in check) {
            if (!check[key]) {
                $('.container').find('input').eq(key).parent().parent().removeClass('has-success').addClass('has-error')
            }
        }
    } else {
        let type = $('#type').val();
        /// 前台校验无误
        let submitdata = {
            "username": $('#username').val(),
            "password": md5($('#password').val()),
            "userid": $('#userid').val(),
            "type": type,
            "invitation": $('#invitation').val()
        };
        // console.log('submit data', submitdata);
        $.ajax({
            type: "POST",
            url: "/ExamSys/index.php/User/signUp",
            data: submitdata,
            dataType: 'json',
            success: function (data) {
                console.log('signUp', data);
                if (data.success == 1) {
                    alert('注册成功');
                    if(type == 0){
                        window.location.href = "/ExamSys/index.php/Pages/student";
                    }else{
                        window.location.href = "/ExamSys/index.php/Pages/teacher";
                    }
                } else {
                    // dialog.tip("注册失败", data['err_msg'], function () { window.location.href = "/ExamSys/index.php/Pages/reg"; });
                    alert("注册失败", data['err_msg']);
                    window.location.href = "/ExamSys/index.php/Pages/reg";
                }
            },
            error: function (XMLHttpRequest) {
                console.log(XMLHttpRequest.responseText);
            }
        })
    }
});



$('#reset').click(function () {
    $('input').slice(0, 6).parent().parent().removeClass('has-error has-success');
    $('.tips').hide();
    $('.glyphicon-ok').hide();
    $('.glyphicon-remove').hide();
    check = [true, false, false, false, false];
});