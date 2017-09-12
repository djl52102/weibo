$(function(){
    //鼠标悬浮展开，关闭菜单选项
    $('.app').hover(function(){
        $(this).css({
            'background':'#fff',
            'color':'#333'
        }).find('.list').show();
    },function(){
        $(this).css({
            'background':'none',
            'color':'#fff'
        }).find('.list').hide();
    });

    //错误提示
    $('#error').dialog({
        autoOpen: false,
        modal: true,
        closeOnEscape: false,
        resizable: false,
        draggable: false,
        width:190,
        height:140
    }).parent().find('.ui-widget-header').hide();

    //loading对话框
    $('#loading').dialog({
        autoOpen: false,
        modal: true,
        closeOnEscape: false,
        resizable: false,
        draggable: false,
        width:190,
        height:140
    }).parent().find('.ui-widget-header').hide();
});
