<extend  name="Base/common"/>
<block name="head">
    <script type="text/javascript" src="__JS__/setting.js"></script>
    <script type="text/javascript" src="__JS__/jquery.Jcrop.js"></script>
    <link rel="stylesheet" href="__CSS__/setting.css">
    <link rel="stylesheet" href="__CSS__/jquery.Jcrop.css">
</block>
<block name="main">
    <div class="main_left">
        <ul>
            <li><a href="{:U('Setting/index')}" class="selected">个人设置</a></li>
            <li><a href="{:U('Setting/avatar')}">头像设置</a></li>
            <li><a href="{:U('Setting/domain')}">域名设置</a></li>
        </ul>
    </div>
    <div class="main_right">
        <h2>个人设置</h2>
        <dl>
            <dd>帐号名称:{$user[0]['username']}</dd>
            <dd>电子邮箱:<input type="text" name="email" class="text" value="{$user[0]['email']}"><strong style="color:red;">*</strong></dd>
            <dd><span>个人简介:</span><textarea name="intro">{$user[0].extend.intro}</textarea></dd>
            <dd><input type="submit" class="submit" value="修改"></dd>
        </dl>
    </div>
</block>