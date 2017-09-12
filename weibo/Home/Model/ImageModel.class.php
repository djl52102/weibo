<?php
namespace Home\Model;
use Think\Model;
use Think\Image;

class ImageModel extends Model{
    public function storage($img,$tid){
        //统计配图id
        // $iid='';
        //批量新增
        foreach($img as $key=>$value){
            $data=array(
                'data'=>$value,
                'tid'=>$tid
            );
            if(!$this->add($data)){
                return 0;
            }
        }
        return 1;
    }
}