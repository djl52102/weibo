<?php
namespace Home\Controller;
use Think\Controller;

class SettingController extends HomeController{
    //显示资料
    public  function index(){
        if($this->login()){
            $User=D('User');
            $this->assign('user',$User->getUser());
            $this->display();
        }
    }
    //更改用户数据
    public function updateUser(){
        if(IS_AJAX){
            $User=D('User');
            echo($User->updateUser(I('post.email'),I('post.intro')));
        }else{
            $this->error('非法访问');
        }
    }

    //显示用户头像
    public function avatar(){
        if($this->login()){
            $User=D('User');
            $this->assign('face',$User->getFace());
            $this->display();
        }
    }

    //注册域名
    public function registerDomain(){
        if(IS_AJAX){
            $User=D('User');
            echo($User->registerDomain(I('post.domain')));
        }else{
            $this->error('非法访问');
        }
    }

    //显示用户头像
    public function domain(){
        if($this->login()){
            $User=D('User');
            $this->assign('domain',$User->getDomain());
            $this->display();
        }
    }
}