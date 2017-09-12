
//微博上传图像js插件
$(function(){
    var lee_pic={
        uploadTotal:0,  //已上传数量
        uploadLimit:8,  //限制上传数量
        //文件上传
        uploadify:function(){
            $('#file').uploadify({
                swf:ThinkPHP['UPLOADIFY']+'/uploadify.swf',
                uploader:ThinkPHP['IMAGEURL'],
                buttonText:'上传图片',
                width:120,
                height:35,
                fileTypeDesc:'图片类型',
                fileTypeExts:'*.jpeg;*.jpg;*.png;*.gif',
                fileSizeLimit:'1MB',
                overrideEvents:['onSelectError','onSelect','onDialogClose'],
                onSelectError:function(file,errorCode,errorMsg){
                    switch (errorCode){
                        case -110:
                            $('#error').dialog('open').html('超过1024kb...');
                            setTimeout(function(){
                                $('#error').dialog('close').html('...');
                            },1000);
                            break;
                    }
                },
                onUploadStart:function(){
                    if(lee_pic.uploadTotal==8){
                        $('#file').uploadify('stop');
                        $('#file').uploadify('cancel');
                        $('#error').dialog('open').html('限制为8张');
                        setTimeout(function(){
                            $('#error').dialog('close').html('...');
                        },1000);
                    }else{
                        $('.weibo_pic_list').append('<div class="weibo_pic_content"><span class="remove"></span><span class="text">删除</span><img src="'+ThinkPHP['IMG']+'/loading_100.png" class="weibo_pic_img"></div>');
                    }
                },
                onUploadSuccess:function(file,data,response){
                        $('.weibo_pic_list').append('<input type="hidden" name="images" value='+data+'>');
                        var imageUrl= $.parseJSON(data);
                        lee_pic.thumb(imageUrl['thumb']);
                        lee_pic.hover();
                        lee_pic.remove();
                        lee_pic.uploadTotal++;
                        lee_pic.uploadLimit--;
                        $('.weibo_pic_total').text(lee_pic.uploadTotal);
                        $('.weibo_pic_limit').text(lee_pic.uploadLimit);
                }
            })
        },
        thumb:function(src){
            var img=$('.weibo_pic_img');
            var len=img.length;
            $(img[len-1]).attr('src',ThinkPHP['ROOT'] + src).hide();
            setTimeout(function(){
                if($(img[len-1]).width()>100){
                    $(img[len-1]).css('left',-($(img[len-1]).width()-100)/2);
                }
                if($(img[len-1]).height()>100){
                    $(img[len-1]).css('top',-($(img[len-1]).height()-100)/2);
                }
                $(img[len-1]).attr('src',ThinkPHP['ROOT'] + src).fadeIn();
            },50);
        },
        hover:function(){
            var content=$('.weibo_pic_content');
            var len=content.length;
            $(content[len-1]).hover(function(){
                $(this).find('.remove').show();
                $(this).find('.text').show();
            },function(){
                $(this).find('.remove').hide();
                $(this).find('.text').hide();
            });
        },
        remove:function(){
            var remove=$('.weibo_pic_content .text');
            var len=remove.length;
            $(remove[len-1]).on('click',function(){
                $(this).parent().remove();
                $(this).next('input[name="image"]').remove();
                lee_pic.uploadTotal--;
                lee_pic.uploadLimit++;
                $('.weibo_pic_total').text(lee_pic.uploadTotal);
                $('.weibo_pic_limit').text(lee_pic.uploadLimit);
            });
        },
        init:function(){
            /*绑定表情弹出按钮响应，初始化弹出默认表情。*/
            $("#pic_btn").bind('click',function(){
                var w = $(this).position();
                $('#pic_box').css({left:w.left-42,top:w.top+30}).show();
                $('.pic_arrow_top').show();
                lee_pic.uploadify();
            });
            /*绑定关闭按钮*/
            $('#pic_box a.close').bind('click',function(){
                $('#pic_box').hide();
                $('.pic_arrow_top').hide();
            });
            /*绑定document点击事件，对target不在rl_bq弹出框上时执行rl_bq淡出，并阻止target在弹出按钮的响应。*/
            $(document).bind('click',function(e){
                var target = $(e.target);
                if( target.closest("#pic_btn").length == 1  || target.closest(".weibo_pic_content .text").length == 1)
                    return;
                if( target.closest("#pic_box").length == 0 ){
                    $('#pic_box').hide();
                    $('.pic_arrow_top').hide();
                }
            });
        }
    };
    lee_pic.init();
    window.uploadCount={
        clear:function(){
            lee_pic.uploadTotal=0;
            lee_pic.uploadLimit=8;
        }
    }
});