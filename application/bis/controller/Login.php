<?php
namespace app\bis\controller;
use think\Controller;
class Login extends Controller
{
	public function index(){
		//判断是否用post方法进行数据提交
		if(request()->isPost()){
			//获取使用post方法提交的数据
			$data = input('post.');
			$username = $data['username'];
			//dump($id);exit;
			//对数据进行校验
			$validate = validate('Login');
			if(!$validate->scene('login')->check($data)){
				$this->error($validate->getError());
			}else{
				$res = model('BisAccount')->get(['username'=>$username]);
				$code = $res['code'];
				// $a = $data['password'].$code;
				// dump($a);exit;
				 if(!$res){
				 	$this->error('用户不存在');
				 }elseif($res && $res['status']!=1){
				 	$this->error('入驻申请已提交，但未通过审核，请耐心等待。');
				 }

				 if($res->password != md5($data['password'].$code)){
				 	$this->error('密码错误,请重新输入');
				}

				model('BisAccount')->updateTimeById(time(),$res['id']);
				session('bisAccount',$res,'bis');
				$this->success('登录成功，页面即将跳转...',url('index/index'));
				
			}	
		}else{
			$account = session('bisAccount','','bis');
			//dump($account);exit;
			if(!$account && $account['id']){
				return $this->redirect('login/index');
			}
				return $this->fetch();
		}
	}

	//用户退出方法
	public function logout(){
		//使用TP5助手函数，清除session
		session(null,'bis');
		$this->success("退出成功",'login/index');
		//return $this->redirect('login/index');
	}
}