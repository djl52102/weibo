<?php
namespace Home\Controller;

class IndexController extends HomeController {
    public function index(){
        if($this->Login()) {
            $Topic=D('Topic');
            $topicList=$Topic->getList(0,10);
            //print_r($topicList);
            //print_r(session('user_auth'));
            $this->assign('topiclist',$topicList);
            $this->assign('smallFace',session('user_auth')['face']->small);
            $this->assign('bigFace',session('user_auth')['face']->big);
            $this->display();
        }
    }
}