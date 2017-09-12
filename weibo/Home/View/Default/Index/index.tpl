<extend  name="Base/common"/>
<block name="head">
    <script type="text/javascript" src="__JS__/index.js"></script>
    <script type="text/javascript" src="__JS__/rl_exp.js"></script>
    <script type="text/javascript" src="__JS__/lee_pic.js"></script>
    <script type="text/javascript" src="__UPLOAD__/jquery.uploadify.min.js"></script>
    <script type="text/javascript" src="__JS__/jquery.scrollUp.js"></script>
   <script>
(function(){
    var bp = document.createElement('script');
    var curProtocol = window.location.protocol.split(':')[0];
    if (curProtocol === 'https') {
        bp.src = 'https://zz.bdstatic.com/linksubmit/push.js';        
    }
    else {
        bp.src = 'http://push.zhanzhang.baidu.com/push.js';
    }
    var s = document.getElementsByTagName("script")[0];
    s.parentNode.insertBefore(bp, s);
})();
</script>
    <link rel="stylesheet" href="__CSS__/rl_exp.css">
    <link rel="stylesheet" href="__CSS__/index.css">
    <link rel="stylesheet" href="__UPLOAD__/uploadify.css">
</block>
<block name="main">
    <div class="main_left">
        <div class="weibo_form">
            <span class="left">和大家分享一点新鲜事吧?</span>
            <span class="right weibo_num">可以输入<strong>140</strong>个字</span>
            <textarea class="weibo_text" id="rl_exp_input"></textarea>
            <a href="javascript:void(0);" id="rl_exp_btn" class="weibo_face">表情<span class="face_arrow_top"></span></a>
            <a href="javascript:void(0);" id="pic_btn" class="weibo_pic">图片<span class="pic_arrow_top"></span></a>
            <div class="rl_exp" id="rl_bq" style="display:none;">
                <ul class="rl_exp_tab clearfix">
                    <li><a href="javascript:void(0);" class="selected">默认</a></li>
                    <li><a href="javascript:void(0);">拜年</a></li>
                    <li><a href="javascript:void(0);">浪小花</a></li>
                    <li><a href="javascript:void(0);">暴走漫画</a></li>
                </ul>
                <ul class="rl_exp_main clearfix rl_selected"></ul>
                <ul class="rl_exp_main clearfix" style="display:none;"></ul>
                <ul class="rl_exp_main clearfix" style="display:none;"></ul>
                <ul class="rl_exp_main clearfix" style="display:none;"></ul>
                <a href="javascript:void(0);" class="close">×</a>
            </div>
            <div class="weibo_pic_box" id="pic_box" style="display:none;">
                <div class="weibo_pic_header">
                <span class="weibo_pic_info">共<span class="weibo_pic_total">0</span>张，还能上传<span class="weibo_pic_limit">8</span>张（按住ctrl可选择多张）</span>
                <a href="javascript:void(0);" class="close">×</a>
                </div>
                <div class="weibo_pic_list">

                </div>
                <input type="file" name="file" id="file">
            </div>
            <input class="weibo_button" type="button" value="发布">
        </div>
        <div class="weibo_content" style="clear:both">
            <ul>
                <li><a href="javascript:void(0)" class="selected">我关注的<i class="nav_arrow"></i></a></li>
                <li><a href="javascript:void(0)" >互听的</a></li>
            </ul>
            <!--插入动态接点-->
            <volist name="topiclist" id="obj">
                <empty name="obj.reid">
                    <dl class="weibo_content_data">
                        <dt class="face">
                            <empty name="obj.face">
                                <a href="{:U('Space/index', array('id'=>$obj['uid']))}"><img src="__IMG__/small_face.jpg" alt=""></a>
                                <else />
                                <a href="{:U('Space/index', array('id'=>$obj['uid']))}"><img src="__ROOT__/{$obj.face}" alt=""></a>
                            </empty>
                        </dt>
                        <dd class="content">
                            <h4>
                                <empty name="obj.domain">
                                    <a href="{:U('Space/index', array('id'=>$obj['uid']))}">{$obj.username}</a>
                                    <else />
                                    <a href="__ROOT__/i/{$obj.domain}">{$obj.username}</a>
                                </empty>
                            </h4>
                            <p>{$obj.content}</p>
                            <switch name="obj.count">
                                <case value="0"></case>
                                <case value="1">
                                    <div class="img"><img src="__ROOT__/{$obj['images'][0]['thumb']}" alt=""></div>
                                    <div class="img_zoom" style="display:none">
                                        <ol>
                                            <li class="in"><a href="javascript:void(0)">收起</a></li>
                                            <li class="source"><a href="__ROOT__/{$obj['images'][0]['source']}" target="_blank">查看原图</a></li>
                                        </ol>
                                        <img data-src="__ROOT__/{$obj['images'][0]['unfold']}" src="__IMG__/loading_100.png" alt="">
                                    </div>
                                </case>
                                <default/>
                                <for start="0" end="$obj['count']">
                                    <div class="imgs"><img src="__ROOT__/{$obj['images'][$i]['thumb']}" alt="" unfold-src="__ROOT__/{$obj['images'][$i]['unfold']}" source-src="__ROOT__/{$obj['images'][$i]['source']}"></div>
                                </for>
                            </switch>
                            <div class="footer">
                                <span class="time">{$obj.time}</span>
                                <span class="handler">赞(0) | <a href="javascript:void(0)" class="re">转播{$obj.recount}</a> | 评论 | 收藏</span>
                                <div class="re_box" style="display:none;">
                                    <textarea class="re_text" name="commend"></textarea>
                                    <input type="hidden" name="reid" value="{$obj.id}"/>
                                    <input type="button" class="re_button" value="转播">
                                </div>
                            </div>
                        </dd>
                        </dl>
                    <else/>
                    <dl class="weibo_content_data">
                    <dt class="face">
                        <empty name="obj.face">
                            <a href="{:U('Space/index', array('id'=>$obj['uid']))}"><img src="__IMG__/small_face.jpg" alt=""></a>
                            <else />
                            <a href="{:U('Space/index', array('id'=>$obj['uid']))}"><img src="__ROOT__/{$obj.face}" alt=""></a>
                        </empty>
                    </dt>
                    <dd class="content">
                            <h4>
                                <empty name="obj.domain">
                                    <a href="{:U('Space/index', array('id'=>$obj['uid']))}">{$obj.username}</a>
                                    <else />
                                    <a href="__ROOT__/i/{$obj.domain}">{$obj.username}</a>
                                </empty>
                            </h4>
                        <p>{$obj.content}</p>
                        <div class="re_content" style="overflow:auto;">
                            <h5>
                            <empty name="obj.recontent.domain">
                                <a href="{:U('Space/index', array('id'=>$obj['recontent']['uid']))}">{$obj.recontent.username}</a>
                                <else />
                                <a href="__ROOT__/i/{$obj.recontent.domain}">@{$obj.recontent.username}</a>
                            </empty>
                            </h5>
                            <p>{$obj.recontent.content}</p>
                            <switch name="obj.recontent.count">
                                <case value="0"></case>
                                <case value="1">
                                    <div class="img"><img src="__ROOT__/{$obj['recontent']['images'][0]['thumb']}" alt=""></div>
                                    <div class="img_zoom" style="display:none">
                                        <ol>
                                            <li class="in"><a href="javascript:void(0)">收起</a></li>
                                            <li class="source"><a href="__ROOT__/{$obj['recontent']['images'][0]['source']}" target="_blank">查看原图</a></li>
                                        </ol>
                                        <img data-src="__ROOT__/{$obj['recontent']['images'][0]['unfold']}" src="__IMG__/loading_100.png" alt="">
                                    </div>
                                </case>
                                <default/>
                                <for start="0" end="$obj['recontent']['count']">
                                    <div class="imgs"><img src="__ROOT__/{$obj['recontent']['images'][$i]['thumb']}" alt="" unfold-src="__ROOT__/{$obj['recontent']['images'][$i]['unfold']}" source-src="__ROOT__/{$obj['recontent']['images'][$i]['source']}"></div>
                                </for>
                            </switch>
                            <div class="footer">
                                <span class="time">{$obj.recontent.time} 该微博被转播过{$obj.recontent.recount}次</span>
                            </div>
                        </div>
                        <div class="footer">
                            <span class="time">{$obj.time}</span>
                            <span class="handler">赞(0) | <a href="javascript:void(0)" class="re">转播</a> | 评论 | 收藏</span>
                            <div class="re_box" style="display:none;">
                                <textarea class="re_text" name="commend">|| @{$obj.username} : {$obj.textarea} </textarea>
                                <input type="hidden" name="reid" value="{$obj.reid}"/>
                                <input type="button" class="re_button" value="转播">
                            </div>
                        </div>
                    </dd>
                </dl>
                </empty>
            </volist>
            <div id="loadmore">加载更多<img src="__IMG__/loadmore.gif" alt=""></div>
            <div id="imgs">
                <ol>
                    <li class="source">
                        <a href="javascript:void(0)" target="_blank">查看原图</a>
                    </li>
                    <img src="__IMG__/loading_100.png" alt="">
                </ol>
            </div>
           <img src="__IMG__/close.png" class="imgs_close" alt="">
        </div>
    </div>
    <div class="main_right">
        <empty name="bigFace">
            <img src="__IMG__/big.jpg" alt="" class="face">
            <else />
            <img src="__ROOT__{$bigFace}" alt="" class="face">
        </empty>
        <span class="user">
            <a href="javascript:void(0)">{:session('user_auth')['username']}</a>
        </span>
    </div>
    <!--没有配图的HTML代码块-->
    <div id="ajax_html1" style="display:none;">
        <dl class="weibo_content_data">
            <dt class="face"><a href="javascript:void(0)">
                    <empty name="smallFace">
                        <img src="__IMG__/small_face.jpg" alt="">
                        <else />
                        <img src="__ROOT__/{$smallFace}" alt="">
                    </empty>
                </a></dt>
            <dd class="content">
                <h4><a href="javascript:void(0)">{:session('user_auth')['username']}</a></h4>
                <p>#内容#</p>
                <div class="footer">
                    <span class="time">刚刚发布</span>
                    <span class="handler">赞(0) | 转播| 评论| 收藏</span>
                </div>
            </dd>
        </dl>
    </div>
    <!--只有一张配图的HTML代码块-->
    <div id="ajax_html2" style="display:none">
        <dl class="weibo_content_data">
            <dt class="face"><a href="javascript:void(0)">
                    <empty name="smallFace">
                        <img src="__IMG__/small_face.jpg" alt="">
                        <else />
                        <img src="__ROOT__/{$smallFace}" alt="">
                    </empty>
                </a></dt>
            <dd class="content">
                <h4><a href="javascript:void(0)">{:session('user_auth')['username']}</a></h4>
                <p>#内容#</p>
                <div class="img" style="display:block;"><img src="#缩略图#" alt=""></div>
                <div class="img_zoom" style="display:none;">
                    <ol>
                        <li class="in"><a href="javascript:void(0)">收起</a></li>
                        <li class="source"><a href="#原图#" target="_blank">查看原图</a></li>
                    </ol>
                    <img data-src="#放大图#" src="__IMG__/loading_100.png" alt="">
                </div>
                <div class="footer">
                    <span class="time">刚刚发布</span>
                    <span class="handler">赞(0) | 转播| 评论| 收藏</span>
                </div>
            </dd>
        </dl>
    </div>
    <!--多图HTML代码块-->
    <div id="ajax_html3" style="display:none;">
        <dl class="weibo_content_data">
            <dt class="face"><a href="javascript:void(0)">
                    <empty name="smallFace">
                        <img src="__IMG__/small_face.jpg" alt="">
                        <else />
                        <img src="__ROOT__/{$smallFace}" alt="">
                    </empty>
                </a></dt>
            <dd class="content">
                <h4><a href="javascript:void(0)">{:session('user_auth')['username']}</a></h4>
                <p>#内容#</p>
                <div class="footer">
                    <span class="time">刚刚发布</span>
                    <span class="handler">赞(0) | 转播| 评论| 收藏</span>
                </div>
            </dd>
        </dl>
    </div>
</block>
