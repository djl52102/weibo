<?php
namespace Home\Model;
use Think\Model;

class UserModel extends Model\RelationModel{
    //批量验证
    //protected $patchValidate=true;
    //服务器验证
    protected $_validate=array(
        //用负值显示验证结果
        array('username','/^[^@]{2,20}$/i',-1,self::EXISTS_VALIDATE),
        array('password','6,30',-2,self::EXISTS_VALIDATE,'length'),
        array('repassword','password',-3,self::EXISTS_VALIDATE,'confirm'),
        array('email','email',-4,self::EXISTS_VALIDATE),
        array('username','',-5,self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
        array('email','',-6,self::EXISTS_VALIDATE,'unique',self::MODEL_INSERT),
        array('verify','check_verify',-7,self::EXISTS_VALIDATE,'function'),
        //登陆用户名长度
        array('login_username','2,50',-8,self::EXISTS_VALIDATE,'length'),
        //登陆用户不是邮箱
        array('login_username','email','noemail',self::EXISTS_VALIDATE)
    );
    //表单自动完成
    protected $_auto=array(
        array('password','sha1',self::MODEL_BOTH,'function'),
        array('create','time',self::MODEL_INSERT,'function')
    );
    //注册帐户，密码
    public function register($username,$password,$repassword,$email,$verify)
    {
        //注册一条数据
        $data=array(
            'username'=>$username,
            'password'=>$password,
            'repassword'=>$repassword,
            'email'=>$email,
            'verify'=>$verify,
            'last_login'=>time(),
            'last_ip'=>get_client_ip(1)
        );
        if($this->create($data)){
            $uid=$this->add();
            return $uid?$uid:0;
        }else{
            return $this->getError();
        }
    }
    //登陆帐户，密码
    public function login($username,$password,$auto){
        $data=array(
            'login_username'=>$username,
            'password'=>$password
        );

        $map=array();

        if($this->create($data)){
            //采用邮箱登陆
            $map['email']=$username;
        }else{
            //采用帐号登陆
            if($this->getError()=='noemail'){
                $map['username']=$username;
            }
            else{
                $this->getError();
            }
        }

        //判断密码是否正确
        $user=$this->field('id,username,password,last_login,face')->where($map)->find();

        if($user['password']==sha1($password)){
            //验证正确后写入日志
            $update=array(
                'id'=>$user['id'],
                'last_login'=>NOW_TIME,
                'last_ip'=>get_client_ip(1)
            );
            $this->save($update);

            //写入cookie
            if($auto=='on'){
                $value=encryption($user['username'].'|'.get_client_ip());
                cookie('auto',$value,3600*24*30);
            }

                //记录要写入session和cookie的数据
                $auth=array(
                    'id'=>$user['id'],
                    'username'=>$user['username'],
                    'last_login'=>NOW_TIME,
                    'face'=>json_decode($user['face'])
                );
                //写入session
                session('user_auth',$auth);


            return $user['id'];

        }else{
            return -9;        //密码不正确
        }
    }
    //验证用户名，密码是否被占用
    public function checkField($field,$type)
    {
        $data=array();
        switch($type){
            case 'username':
                $data['username']=$field;
                break;
            case 'email':
                $data['email']=$field;
                break;
            case 'verify':
                $data['verify']=$field;
                break;
            default:
                return 0;
        }
        return($this->create($data))?1:$this->getError();
    }

    //一对一获取用户数据连接表
    protected $_link=array(
        'extend'=>array(
            'mapping_type'=>self::HAS_ONE,
            'class_name'=>'UserExtend',
            'foreign_key'=>'uid',
            'mapping_fields'=>'intro'
        )

    );

    //获取一对一关联用户数据
    public function getUser($id=0){
        if($id==0){
            $map['id']=session('user_auth')['id'];
        }else{
            $map['id']=$id;
        }

        $user=$this->relation(true)->field('id,username,email,face')->where($map)->select();
        if(!is_array($user[0]['extend'])){
            $data=array(
                'uid'=>$map['id']
            );
            $UserExtend=D('UserExtend');
            $UserExtend->add($data);
        };
        return $user;
    }

    //通过domain获取用户数据
    public function getUser2($domain=''){
        $map['domain']=$domain;

        $user=$this->relation(true)->field('id,username,email,face,domain')->where($map)->select();
        return $user;
    }

    //通过用户名获取用户信息
    public function getUser3($username){
        $map['username']=$username;

        $user=$this->field('id,domain')->where($map)->find();
        return $user;
    }

    //更改用户设置
    public function updateUser($email,$intro){
        $data=array(
            'email'=>$email,
            'extend'=>array(
                'intro'=>$intro
            )
        );

        $map['id']=session('user_auth')['id'];
        return $this->relation(true)->where($map)->save($data);
    }

    //更新用户头像
    public function updateFace($img){
        $update=array(
            'face'=>$img
        );
        $map['id']=session('user_auth')['id'];
        $this->where($map)->save($update);
    }

    //显示用户头像
    public function getFace(){
        $map['id']=session('user_auth')['id'];
        return json_decode($this->field('face')->where($map)->find()['face'])->big;
    }

    //设置个性域名
    public function registerDomain($domain){
        $data=array(
            'domain'=>$domain
        );
        $map['id']=session('user_auth')['id'];
        $uid=$this->where($map)->save($data);
        return $uid?$uid:0;
    }

    //显示用户头像
    public function getDomain(){
        $map['id']=session('user_auth')['id'];
        return $this->field('domain')->where($map)->find()['domain'];
    }
}