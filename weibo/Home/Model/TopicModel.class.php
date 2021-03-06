<?php
namespace Home\Model;
use Think\Image;
use Think\Model;

//加载relationmodel
class TopicModel extends Model\RelationModel{
    //自动验证
    protected $_validate=array(
        array('allContent','0,255',-1,self::EXISTS_VALIDATE),
    );
    //表单自动完成
    protected $_auto=array(
        array('create','time',self::MODEL_INSERT,'function')
    );
    //一条微博对应多张图片
    protected $_link=array(
        'images'=>array(
            'mapping_type'=>self::HAS_MANY,
            'class_name'=>'Image',
            'foreign_key'=>'tid',
            'mapping_fields'=>'data'
        )
    );
    //发布微博
    public function publish($allContent,$uid,$reid=0){
        //分离微博内容
        $len=mb_strlen($allContent,'utf8');
        if($len>255){
            $content=mb_substr($allContent,0,255,'utf8');
            $content_over=mb_substr($allContent,255,25,'utf8');
        }else{
            $content=$allContent;
        }


        //新增数组
        $data=array(
            'content'=>$content,
            'ip'=>get_client_ip(1),
            'uid'=>$uid,
        );
        if($reid>0){
            $data['reid']=$reid;
        }

        //$content_over不为空时添加到数组
        if(!empty($content_over)){
            $data['content_over']=$content_over;
        }

        if($this->create($data)){
            $tid=$this->add();
            //转播数+1
            $this->reCount($reid);
            return $tid?$tid:0;
        }else{
            $this->getError();
        }
    }

    private function reCount($reid){
        $map['id']=$reid;
        $this->where($map)->setInc('recount');
    }
    //分离json图片
    public function format($list){
        foreach($list as $key=>$value){
            //将json解析为数组
            if(!is_null($value['images'])){
                foreach($value['images'] as $key2=>$value2){
                    $value['images'][$key2]=json_decode($value2['data'],true);
                }
            }
            $list[$key]=$value;
            //设置显示时间
            $time=NOW_TIME-$list[$key]['create'];
            if($time<60){
                $list[$key]['time']='刚刚发布';
            }else if($time<60*60){
                $list[$key]['time']=floor($time/60).'分钟之前';
            }else if(date('Y-m-d')==date('Y-m-d',$list[$key]['create'])){
                $list[$key]['time']='今天'.date('H:s',$list[$key]['create']);
            }else if(date('Y-m-d',strtotime("-1 day"))==date('Y-m-d',$list[$key]['create'])){
                $list[$key]['time']='昨天'.date('H:s',$list[$key]['create']);
            }else if(date('Y')==date('Y',$list[$key]['create'])){
                $list[$key]['time']=date('m月d日 H:i',$list[$key]['create']);
            }else{
                $list[$key]['time']=date('Y年m月d日 H:i',$list[$key]['create']);
            }
            //配图数目
            $list[$key]['count']=count($value['images']);
            //表情解析
            $list[$key]['content'].=$list[$key]['content_over'];
            $list[$key]['content']=preg_replace('/\[(a|b|c|d)_([0-9])+\]/i','<img src="'.__ROOT__.'/Public/'.MODULE_NAME.'/face/$1/$2.gif" border="0">',$list[$key]['content']);

            //@账号
            $list[$key]['content'].=' ';
            $pattern='/(@\S+)\s/i';
            $list[$key]['content']=preg_replace($pattern,'<a href="'.__ROOT__.'/$1" target="_blank" class="space">$1</a>',$list[$key]['content']);
            //头像解析
            $list[$key]['face']=json_decode($list[$key]['face'])->small;

            //textare专用
            $list[$key]['textarea']=$list[$key]['content'];

            //获取转发微博
            if($list[$key]['reid']>0){
                $list[$key]['recontent']=$this->getReContent($list[$key]['reid']);
            }
        }
        return $list;
    }

    //获取微博内容列表
    public function getList($first,$total){
        return $this->format($this->relation(true)
                    ->table('__TOPIC__ a,__USER__ b')
                    ->field('a.id,a.content,a.content_over,a.create,a.uid,a.reid,b.username,b.face,b.domain')
                    ->limit($first,$total)
                    ->order('a.create DESC')
                    ->where('a.uid=b.id')
                    ->select()
        );
    }

    //获取转发微博内容
    private function getReContent($reid){
        return $this->format2($this->relation(true)
            ->table('__TOPIC__ a,__USER__ b')
            ->field('a.id,a.content,a.content_over,a.create,a.uid,a.reid,a.recount,b.username,b.face,b.domain')
            ->where('a.uid=b.id AND a.id='.$reid)
            ->find());
    }

    //格式化转发微博
    private function format2($list){
        if(!is_null($list['images'])){
            foreach($list['images'] as $key=>$value){
                $list['images'][$key]=json_decode($value['data'],true);
            }
        }
        $list['count']=count($list['images']);
        //表情解析
        $list['content'].=$list['content_over'];
        $list['content']=preg_replace('/\[(a|b|c|d)_([0-9])+\]/i','<img src="'.__ROOT__.'/Public/'.MODULE_NAME.'/face/$1/$2.gif" border="0">',$list['content']);
        //@账号
        $list['content'].=' ';
        $pattern='/(@\S+)\s/i';
        $list['content']=preg_replace($pattern,'<a href="'.__ROOT__.'/$1" target="_blank" class="space">$1</a>',$list['content']);

        //设置显示时间
        $time=NOW_TIME-$list['create'];
        if($time<60){
            $list['time']='刚刚发布';
        }else if($time<60*60){
            $list['time']=floor($time/60).'分钟之前';
        }else if(date('Y-m-d')==date('Y-m-d',$list['create'])){
            $list['time']='今天'.date('H:s',$list['create']);
        }else if(date('Y-m-d',strtotime("-1 day"))==date('Y-m-d',$list['create'])){
            $list['time']='昨天'.date('H:s',$list['create']);
        }else if($time<60*60*365){
            $list['time']=date('m月d日 H:i',$list['create']);
        }else{
            $list['time']=date('Y年m月d日 H:i',$list['create']);
        }
        //转播次数

        return $list;
    }
}