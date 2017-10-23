<?php
namespace app\admin\controller;
use think\Controller;
use Map;

class Index extends Controller
{
	
    public function index()
    {
       return $this->fetch();
    }

    public function map(){
    	return Map::staticimage('安徽省滁州市琅琊区成业家园');
    }

    public function test(){
    	//return '这里是Admin模块的Index控制器的test方法';
		Map::getLngLat('安徽省滁州市琅琊区成业家园');
		return '1234';
    }
    public function welcome(){
        $email = \phpmailer\Email::send('',1,1);
        if($email == true){
            return "邮件发送成功";
        }else{
            return '信息提交有误，请重新输入！';
        }
        
        //return "测试测试ceshi";
    }

}
