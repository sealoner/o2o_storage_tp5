<?php
namespace app\admin\controller;
use think\Controller;

class Register extends Controller
{
    public function index()
    {
        if(request()->isPost()){
        $data = input('post.');
        $data['verify'] = mt_rand(1000,9999);
        dump($data);exit;
        $title = '后台注册验证码';
        $content = "尊敬的用户：".$data['user']."，您的验证码为：".$data['verify'];
        $success = \phpmailer\Email::send($data['email'],$title,$content);
        if($success){
        	$this->success('发送成功');
        }else{
        	echo $this->error('):');
        }
        print_r($data);
        }else{
            return $this->fetch();
        }
    }
}