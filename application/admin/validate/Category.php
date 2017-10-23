<?php
namespace app\admin\validate;
use think\Validate;

class Category extends Validate
{
	protected $rule    = [
		'name'             =>	['require'],
		'parent_id'        =>	['number'],
		'id'               =>	['number'],
		'status'           =>	['number','in:-1,0,1,2'],
		'listorder'		   =>	['number'],
	];
		
	protected $message = [
		'name.require'     =>	'名称不能为空',
		'status.in'        =>	'状态范围不合法',
	];

	/**场景设置**/
	protected $scene   = [
		'add'              => ['name','parent_id','id'],
		'index'            => ['id','listorder'],//只在排序方法中验证id和listorder这两个字段
        'status'           => ['id','status'],
	];
}