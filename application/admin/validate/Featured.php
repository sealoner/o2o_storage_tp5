<?php
namespace app\common\validate;
use think\Validate;

class Featured extends Validate
{
	//创建校验的规则
	//Tp5自带的校验的基本形式
	//require属性表示此字段为必填项
			protected $rule     = [
			'title|商户名称'         =>'require|max:50',
			'image|推荐图'           =>'require',
			'type|所属分类'          =>'require',
			'url|跳转地址'           =>'require',
			'description|推荐位描述' =>'require',
			];

			/**
			 * 提示信息
			 */
			
			protected $message = [
				'title.require' => '推荐标题不能为空',
				'type.require' => '请选择所属分类',
				'url.require' => '推荐位点击跳转地址不能为空',
			];

			/**场景设置**/
			protected $scene    = [
			'add' => ['title','image','type','url','description'],
	];
}