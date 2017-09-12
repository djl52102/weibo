<?php
namespace Home\Controller;
use Think\Model;
use THink\Controller;
class UserController extends Controller{
    //注册页面
    public function register(){
        if(IS_AJAX){
            $User=D('User');
            $uid=$User->register(I('post.username'),I('post.password'),I('post.repassword'),I('post.email'),I('post.verify'));
            echo $uid;
        }else{
            $this->error('非法操作');
        }
    }
    //登陆帐户，密码
    public function login(){
        if(IS_AJAX){
            $User=D('User');
            $uid=$User->login(I('post.username'),I('post.password'),I('post.auto'));
            echo $uid;
        }else{
            $this->error('非法操作');
        }
    }
    //ajax验证用户名是否重复
    public function checkUserName(){
        if(IS_AJAX){
            $User=D('User');
            $uid=$User->checkField(I('post.username'),'username');
            echo $uid>0?'true':'false';
        }
    }
    //ajax验证邮箱是否重复
    public function checkEmail(){
        if(IS_AJAX){
            $User=D('User');
            $uid=$User->checkField(I('post.email'),'email');
            echo $uid>0?'true':'false';
        }
    }
//    //ajax验证码是否重复
//    public function checkVerify(){
//        if(IS_AJAX){
//           if(check_verify(I('post.verify'))){
//                echo '验证码正确';
//           }else{
//               echo '验证码错误';
//           }
//        }
//    }
    //ajax验证邮箱是否重复
    public function checkVerify(){
        if(IS_AJAX){
            $User=D('User');
            $uid=$User->checkField(I('post.verify'),'verify');
            echo $uid>0?'true':'false';
        }
    }
    //退出登录方法
    public function logOut(){
        //清空session
        session(null);
        //清空cookie
        cookie('auto',null);
        //跳转到登录页面
        $this->success('退出成功',U('Login/index'));
    }

}