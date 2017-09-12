$(function(){
    //登陆页背景随机
    var rand=Math.floor(Math.random()*5+1);
    $('body').css('background','url('+ThinkPHP['IMG']+'/login_bg'+rand+'.jpg) no-repeat').css('background-size','100%')
    //登陆页的按钮
    $('#login input[type="submit"]').button();
    //创建注册对话框
    $('#register').dialog({
        width:430,
        height:385,
        modal:true,
        resizable:false,
        title:'注册新用户',
        closeText:'关闭',
        autoOpen:false,
        buttons:[{
            text:'提交',
            click:function(e){
                $(this).submit();
            }
        }]
    }).validate({
        submitHandler:function(form){
            $('#verify_register').attr('form-click','register');
            $('#verify_register').dialog('open');
        },
        //将错误信息存入ol列表
        showErrors:function(errorMap,errorList){
            var errors=this.numberOfInvalids();
            if(errors>0){
                $('#register').dialog('option','height',errors*20+385)
            }else{
                $('#register').dialog('option','height',385)
            }
            this.defaultShowErrors();
        },
        //错误部分边框红色显示
        highlight:function(element,errorClass){
            $(element).css('border','1px solid red');
            $(element).parent().find('span').html('*').removeClass('succ');
        },
        //正确回复原来边框
        unhighlight:function(element,errorClass){
            $(element).css('border','1px solid #ccc');
            $(element).parent().find('span').html('&nbsp;').addClass('succ');
        },
        errorLabelContainer:'ol.reg_error',
        wrapper:'li',
        //验证规则
        rules:{
            username:{
                required:true,
                minlength:2,
                maxlength:20,
                isAt:true,
                remote:{
                    url:ThinkPHP['MODULE']+'/User/checkUserName',
                    type:'POST',
                    beforeSend:function(jqXHR,settings){
                        $('#username').next().html('&nbsp;').removeClass('succ').addClass('loading')
                    },
                    complete:function(jqXHR,textStatus){
                        if(jqXHR.responseText=='true'){
                            $('#username').next().html('&nbsp;').removeClass('loading').addClass('succ')
                        }else{
                            $('#username').next().html('*').removeClass('loading')
                        }
                    }

                }
            },
            password:{
                required:true,
                minlength:6,
                maxlength:40
            },
            repassword:{
                required:true,
                equalTo:'#password'
            },
            email:{
                required:true,
                email:true,
                remote:{
                    url:ThinkPHP['MODULE']+'/User/checkEmail',
                    type:'POST'
                }

            }
        },
        messages:{
            username:{
                required:'用户不得为空',
                minlength: $.format('帐号不得小于{0}位'),
                maxlength: $.format('帐号不得大于{0}位'),
                isAt:'不能存在@符号',
                remote:'用户名被占用'
            },
            password:{
                required:'密码不得为空',
                minlength: $.format('帐号不得小于{0}位'),
                maxlength: $.format('帐号不得大于{0}位')
            },
            repassword:{
                required:'密码确认不得为空',
                equalTo:'密码必须和密码确认一致'
            },
            email:{
                required:'邮箱不得为空',
                email:'请输入合法电子邮箱',
                remote:'邮箱被占用',
                beforeSend:function(jqXHR,settings){
                    $('#email').next().html('&nbsp;').removeClass('succ').addClass('loading')
                },
                complete:function(jqXHR,textStatus){
                    if(jqXHR.responseText=='true'){
                        $('#email').next().html('&nbsp;').removeClass('loading').addClass('succ')
                    }else{
                        $('#email').next().html('*').removeClass('loading')
                    }
                }
            },
            verify:{
                required:'验证码不得为空',
                remote:'验证码输入不正确,请重新输入'
            }
        }
    });
    //点击注册打开对话框
    $('#reg_link').click(function(){
        $('#register').dialog('open');
    });
    //设置加载dialog
    $('#loading').dialog({
        autoOpen:false,
        model:true,
        closeOnEscape:false,
        resizable:false,
        draggable:false,
        width:180,
        height:40
    }).parent().find('.ui-widget-header').hide();
    //验证对话框
    $('#verify_register').dialog({
        autoOpen:false,
        width:290,
        height:300,
        modal:true,
        title:'请输入验证码',
        resizable:false,
        closeText:'关闭',
        buttons:[{
            text:'完成',
            click:function(e){
                $(this).submit()
            }
        }],
        close:function(){
            $('#register').dialog('widget').find('button').eq(1).button('enable');
        }
    }).validate({
        submitHandler: function (form) {
            if($('#verify_register').attr('form-click')=='register'){
                $('#register').ajaxSubmit({
                    url: ThinkPHP['MODULE'] + '/User/register',
                    type: 'POST',
                    data: {
                        verify: $('#verify').val()
                    },
                    beforeSubmit: function () {
                        $('#loading').dialog('open');
                        $('#register').dialog('widget').find('button').eq(1).button('disable');
                        $('#verify_register').dialog('widget').find('button').eq(1).button('disable');
                    },
                    success: function (responseText) {
                        if (responseText) {
                            $('#register').dialog('widget').find('button').eq(1).button('enable');
                            $('#verify_register').dialog('widget').find('button').eq(1).button('enable');
                            $('#loading').css('background', 'url(' + ThinkPHP['IMG'] + '/success.gif) no-repeat 20px center').html('数据新增成功...');
                            setTimeout(function () {
                                if (verifyimg.indexOf('?') > 0) {
                                    $('.verifyimg').attr('src', verifyimg + '&random=' + Math.random());
                                }
                                else {
                                    $('.verifyimg').attr('src', verifyimg + '?random=' + Math.random());
                                }
                                $('#register').dialog('close');
                                $('#verify_register').dialog('close');
                                $('#loading').dialog('close');
                                $('#register').resetForm();
                                $('#verify_register').resetForm();
                                $('span.star').html('*').removeClass('succ');
                                $('#loading').css('background', 'url(' + ThinkPHP['IMG'] + '/loading.gif) no-repeat 20px center').html('数据交互中...');
                            }, 1000);
                        }
                    }
                });
            }else if($('#verify_register').attr('form-click')=='login'){
                    $('#login').ajaxSubmit({
                        url: ThinkPHP['MODULE'] + '/User/login',
                        type: 'POST',
                        beforeSubmit:function(){
                            $('#loading').dialog('open');
                        },
                        success:function(responseText){
                            if(responseText==-9){
                                $('#loading').dialog('option','width',210).css('background', 'url(' + ThinkPHP['IMG'] + '/error.png) no-repeat 20px center').html('帐号或密码不正确');
                                setTimeout(function(){
                                    $('#loading').dialog('close');
                                    $('#loading').dialog('option','width',180).css('background', 'url(' + ThinkPHP['IMG'] + '/loading.gif) no-repeat 20px center').html('数据交互中');
                                },2000);
                            }else{
                                $('#loading').dialog('option','width',240).css('background', 'url(' + ThinkPHP['IMG'] + '/success.gif) no-repeat 20px center').html('登陆成功，正在跳转中...');
                                $('#login').resetForm();
                                $('#verify_register').resetForm();
                                setTimeout(function(){
                                    location.href=ThinkPHP['INDEX'];
                                },1000);
                            }
                        }
                    })
                }
        },
        showErrors : function (errorMap, errorList) {
            var errors = this.numberOfInvalids();
            if (errors > 0) {
                $('#verify_register').dialog('option', 'height', errors * 20 + 300);
            } else {
                $('#verify_register').dialog('option', 'height', 300);
            }
            this.defaultShowErrors();
        },
        highlight : function (element, errorClass) {
            $(element).css('border', '1px solid red');
            $(element).parent().find('span').html('*').removeClass('succ');
        },
        unhighlight : function (element, errorClass) {
            $(element).css('border', '1px solid #ccc');
            $(element).parent().find('span').html('&nbsp;').addClass('succ');
        },
        errorLabelContainer : 'ol.ver_error',
        wrapper : 'li',
        rules : {
            verify : {
                required : true,
                remote : {
                    url : ThinkPHP['MODULE'] + '/User/checkVerify',
                    type : 'POST'
                }
            }
        },
        messages : {
            verify : {
                required : '验证码不得为空！',
                remote : '验证码不正确！'
            }
        }
    });
    //设置登陆对话框
    $('#login').validate({
        submitHandler:function(form){
            $('#verify_register').attr('form-click','login');
            $('#verify_register').dialog('open');
        },
        rules:{
            username:{
                required:true,
                minlength:2,
                maxlength:50
            },
            password:{
                required:true,
                minlength:6,
                maxlength:30
            }
        },
        messages:{
            username:{
                required:'必填',
                minlength: $.format('帐号不得小于{0}位'),
                maxlength: $.format('帐号不得大于{0}位')
            },
            password:{
                required:'必填',
                minlength: $.format('密码不得小于{0}位'),
                maxlength: $.format('密码不得大于{0}位')
            }
        }
    });
    //点击更换验证码
    var verifyimg = $('.verifyimg').attr('src');
    $('.changeimg').click(function () {
        if (verifyimg.indexOf('?') > 0) {
            $('.verifyimg').attr('src', verifyimg + '&random=' + Math.random());
        }
        else {
            $('.verifyimg').attr('src', verifyimg + '?random=' + Math.random());
        }
    });
    //自定义验证，不得包含@
    $.validator.addMethod('isAt',function(value,element){
        var text=/^[^@]+$/i;
        return this.optional(element) || (text.test(value));
    },'存在@符号');
    //邮箱自动补全
    $('#email').autocomplete({
        delay : 0,
        autoFocus : true,
        source : function (request, response) {
    //获取用户输入的内容
    //alert(request.term);
   //绑定数据源的
    //response(['aa', 'aaaa', 'aaaaaa', 'bb']);
            var hosts = ['qq.com', '163.com',
                    '263.com', 'sina.com.cn','gmail.com', 'hotmail.com'],
                term = request.term, //获取用户输入的内容
                name = term, //邮箱的用户名
                host = '', //邮箱的域名
                ix = term.indexOf('@'), //@的位置
                result = []; //最终呈现的邮箱列表
            result.push(term);
        //当有@的时候，重新分别用户名和域名
            if (ix > -1) {
                name = term.slice(0, ix);
                host = term.slice(ix + 1);
            }
            if (name) {
     //如果用户已经输入@和后面的域名，
     //那么就找到相关的域名提示，比如bnbbs@1，就提示bnbbs@163.com
     //如果用户还没有输入@或后面的域名，
     //那么就把所有的域名都提示出来
                var findedHosts = (host ? $.grep(hosts,
                    function (value, index) {
                        return value.indexOf(host) > -1
                    }) : hosts),
                    findedResult = $.map(findedHosts,
                        function (value, index) {
                            return name + '@' + value;
                        });
                result = result.concat(findedResult);
            }
            response(result);
        }
    });
});

