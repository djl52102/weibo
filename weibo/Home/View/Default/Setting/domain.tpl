<extend  name="Base/common"/>
<block name="head">
  <script type="text/javascript" src="__JS__/jquery.Jcrop.js"></script>
  <script type="text/javascript" src="__JS__/setting.js"></script>
  <link rel="stylesheet" href="__CSS__/setting.css">
</block>
<block name="main">
  <div class="main_left">
    <ul>
      <li><a href="{:U('Setting/index')}">个人设置</a></li>
      <li><a href="{:U('Setting/avatar')}">头像设置</a></li>
      <li><a href="{:U('Setting/domain')}" class="selected">域名设置</a></li>
    </ul>
  </div>
  <div class="main_right">
    <h2>个性域名</h2>
    <dl>
        <dd>
            个性域名必须是4-10个字符范围内，只能是数字，字母组成，且必须没有被注册！注册后，无法修改!
        </dd>
        <empty name="domain">
            <dd><input type="text" name="domain" class="text"><b style="color:red;">*</b></dd>
            <dd><input type="submit" value="注册" class="register" style="margin:0;"></dd>
            <else/>
            <dd>您的个性域名地址为:<a href="__ROOT__/i/{$domain}">http://{:$_SERVER['SERVER_NAME']}__ROOT__/i/{$domain}</a></dd>
        </empty>
    </dl>
  </div>
</block>