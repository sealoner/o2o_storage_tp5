<?php
namespace app\admin\controller;
use think\Controller;

class Login extends Controller
{
    public function index()
    {
        if(request()->isPost()){
        $data = input('post.');
        $data['verify'] = mt_rand(1,10000);
        dump($data);exit;
        }else{
            return $this->fetch();
        }
    }
}