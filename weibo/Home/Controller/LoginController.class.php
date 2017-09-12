<?php
namespace Home\Controller;
use Think\Model;
use THink\Controller;
use Think\Verify;

class LoginController extends Controller{
    public function index(){
        if(!session('?user_auth')){
            $this->display();
        }else{
            $this->redirect('Index/index');
        }

    }
    //生成验证码
    public function verify(){
        $Verify=new Verify();
        $Verify->entry(1);
    }
}