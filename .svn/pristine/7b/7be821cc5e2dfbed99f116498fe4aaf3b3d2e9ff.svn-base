<?php
namespace Home\Model;
use Think\Model;
use Think\Image;
use Think\Upload;
class FileModel{
    //裁剪图片
    public function  crop($url,$x,$y,$w,$h){
        $bigPath=C('FACE_PATH').session('user_auth')['id'].'.jpg';
        $smallPath=C('FACE_PATH').session('user_auth')['id'].'_small.jpg';
        $image=new Image();
        $image->open($url);
        $image->crop($w,$h,$x,$y)->save($url);

        $image->thumb(200,200,Image::IMAGE_THUMB_FIXED)->save($bigPath);
        $image->thumb(50,50,Image::IMAGE_THUMB_FIXED)->save($smallPath);

        $imageArr=array(
            'big'=>$bigPath,
            'small'=>$smallPath
        );
        return $imageArr;
    }
}