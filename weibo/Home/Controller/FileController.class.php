<?php
namespace Home\Controller;
use Think\Controller;
use Think\Image;
use Think\Upload;
class FileController extends HomeController{
    public function image(){
        $Upload=new Upload();
        $Upload->rootPath=C('UPLOAD_PATH');
        $Upload->maxSize=1048579;
        $info=$Upload->upload();
        if($info){
            //图片缩略图处理
            $imgPath=C('UPLOAD_PATH').$info['Filedata']['savepath'].$info['Filedata']['savename'];
            $image=new Image();
            //保存180缩略图
            $image->open($imgPath);
            $thumbPath=C('UPLOAD_PATH').$info['Filedata']['savepath'].'180_'.$info['Filedata']['savename'];
            $image->thumb(180,180)->save($thumbPath);
            $image->open($imgPath);
            $unfoldPath=C('UPLOAD_PATH').$info['Filedata']['savepath'].'550_'.$info['Filedata']['savename'];
            $image->thumb(550,550)->save($unfoldPath);

            $imageArr=array(
                'thumb'=>$thumbPath,
                'unfold'=>$unfoldPath,
                'source'=>$imgPath,
            );
            $this->ajaxReturn($imageArr);

        }else{
            echo  $Upload->getError();
        }
    }
    //头像上传
    public function face(){
        $Upload=new Upload();
        $Upload->rootPath=C('UPLOAD_PATH');
        $Upload->maxSize=1048579;
        $info=$Upload->upload();
        if($info){
            //图片缩略图处理
            $imgPath=C('UPLOAD_PATH').$info['Filedata']['savepath'].$info['Filedata']['savename'];
            $image=new Image();
            //保存500缩略图
            $image->open($imgPath);
            $thumbPath=C('UPLOAD_PATH').$info['Filedata']['savepath'].'500_'.$info['Filedata']['savename'];
            $image->thumb(500,500)->save($thumbPath);

            $this->ajaxReturn($thumbPath);

        }else{
            echo  $Upload->getError();
        }
    }
    //裁剪图片
    public function crop(){
        $File=D('File');
        $img=$File->crop(I('post.url'),I('post.x'),I('post.y'),I('post.w'),I('post.h'));
        $User=D('User');
        $User->updateFace(json_encode($img));
        echo json_encode($img);
    }
}