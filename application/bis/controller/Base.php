<?php
namespace app\bis\controller;
use think\Controller;
class Base extends controller
{
	public $account;
	//在bis作用域下，判断用户是否登录（其实就是判断session是否存在），如果存在，则跳转到主后台页面，如果不存在跳转到登录页面
	//使用TP5自带的_initialize()方法，让别的控制器在继承此控制器是，自动执行此方法
	//在这里进行值的输出
	//我写的
	// public function _initialize(){
	// 	//判断session有没有被清除
	// 	$login = session('bisAccount','','bis');
	// 	if(!$login && !$login['id']){
	// 		$this->error('您已退出，没有权限访问此页面','login/index');
	// 	}
	// }
	//老师写的
	public function _initialize(){
		//判断session有没有被清除
		$isLogin = $this->isLogin();
			if(!$isLogin){
				return $this->error('您已退出，没有权限访问此页面','login/index');
			}
		}

	//判断是否登录
	//这这里进行值的判断
	public function isLogin(){
		//获取session
		$user = $this->getLoginUser();
		if($user && $user['id']){
			return true;
		}
		return false;
	}

	//在这里进行值的获取
	public function getLoginUser(){
		if(!$this->account){
			$this->account = session('bisAccount','','bis');
		}
		return $this->account;
	}

	/**
     * 点击修改状态/代码复用
     * @return [type] [description]
     */
    public function status(){
        $data = input('get.');
        if(!$data){
            $this->error('无法获取id值');
        }
        if(!is_numeric($data['status'])){
            $this->error('状态码出错');
        }
        $model = request()->controller();
        $result = model($model)->save(
                ['status' => $data['status']],
                ['id'     => $data['id']]
            );
        if($result){
            $this->success('状态修改成功');
        }else{
            $this->error('状态修改失败');
        }
    }
}
