<?php
namespace app\common\validate;
use think\Validate;

class Login extends Validate
{
	protected $rule    = [
		'username|用户名'             =>		['require','min'=>5,'max'=>25,],
		'password|密码'				  =>	['require'],
	];
		
	protected $message = [
		'username.require'     =>	'用户名不能为空',
		'username.min'         =>	'用户名最少为5个字符',
		'username.max'         =>	'用户名最多为25个字符',
		'password.require'     =>	'你不填密码怎么登陆呢??!!',
	];

	/**场景设置**/
	protected $scene   = [
		'login'              => ['username','password'],
	];
}