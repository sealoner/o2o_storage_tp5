<?php
namespace app\common\validate;
use think\Validate;

class Register extends Validate
{
	protected $rule    = [
		'username|用户名'             =>		['require','chsAlphaNum','min'=>5,'max'=>20,'unique'=>'user'],
		'password|密码'				  =>	['require','confirm'],
		'email|邮箱'					  =>	['require','email','unique'=>'user'],	
	];
		
	protected $message = [
		'username.require'     =>	'用户名不能为空',
		'username.min'         =>	'用户名最少为5个字符',
		'username.max'         =>	'用户名最多不能超过20个字符',
		'username.chsAlphaNum' =>	'用户名只可以是汉字、字母和数字',
		'username.unique'	   =>	'此用户名已存在，请使用此用户名登录或重新注册',
		'password.require'     =>	'你不填密码怎么登陆呢??!!',
		'password.confirm'	   =>	'两次输入的密码不正确，请检查后重新输入',
		'email.email'	   	   =>	'邮箱格式不正确',
		'email.unique'	   	   =>	'此邮箱已被注册',
	];

	/**场景设置**/
	protected $scene   = [
		'register'              => ['username','password','email'],
	];
}