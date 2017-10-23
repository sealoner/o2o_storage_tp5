<?php
namespace app\index\controller;
use think\Controller;

class User extends Controller
{
    public function login()
    {
    	$user = session('o2o_user','','index');
    	if($user && $user->id){
    		$this->redirect(url('index/index'));
    	}
    	return $this->fetch();
    }

    /**
     * 注册信息提交校验、入库
     * @return [type] [description]
     */
    public function register()
    {
    	if(request()->isPost()){
			$data = input('post.');
			$validate = validate('Register');
			$result = $validate->scene('register')->check($data);
			if(!captcha_check($data['verifyCode'])){
				$this->error('验证码错误，请重新输入');
			}
			if(!$result){
				$this->error($validate->getError());
			}else{
				$data['code'] = md5(mt_rand(10000,99999));
				$data['password'] = md5($data['code'].$data['password']);
				//try  catch的意思就是：现在try中执行逻辑，同时对结果进行判断，如果为真，跳过catch，如果为假，执行catch中的语句
				try{
					$res = model('User')->add($data);
				}catch (\Exception $e){
					$this->error($e->getMessage());
				}
				//dump($res);exit;
				if($res){
					$this->success('注册成功',url('user/login'));
				}else{
					$this->error('注册失败');
				}
			}
			//dump($data);exit;
    	}else{
    		return $this->fetch();
    	}
    }

/**
 * 登录信息验证
 * @return [type] [description]
 */
    public function logincheck()
    {
    	//判断是否有用post提交的数据
    	if(request()->isPost()){
    		$data = input('post.');
    		//对数据进行校验
    		$validate = validate('Login');
    		$result = $validate->scene('login')->check($data);
    		if($result){
    			try{
					//通过username字段去数据库中查询是否有这条数据
					$user = model('User')->getUserByUsername($data['username']);
    			}catch(\Exception $e){
    				return $this->error($e->getMessage());
    			}
    			$data['code'] = md5(mt_rand(10000,99999));
    			
    			//判断返回结果的用户名是否正确
    			if(!$user || $user->status!=1){
    				$this->error('用户名不正确或已被封号');
    			}
    			//验证输入的密码与数据库中的密码是否正确
    			if(md5($user['code'].$data['password'])!=$user->password){
    				$this->error('密码错误，请重新输入！');
    			}
    			//用户名及密码正确，更新最后一次登录时间
    			model('User')->updateUserLastTimeById(['last_login_time'=>time()],$user->id);
    			//将用户信息保存在session中
    			session('o2o_user',$user,'index');
    			return $this->success('登录成功',url('index/index'));
    			//
    		}else{
    			return $this->error($validate->getError());
    		}		
    	}else{
    		return $this->fetch();
    	}
    }
    
    /**
     * 用户退出逻辑
     * @return [type] [description]
     */
    public function logout(){
    	session(null,'index');
    	return $this->redirect(url('user/login'));
    }
}
