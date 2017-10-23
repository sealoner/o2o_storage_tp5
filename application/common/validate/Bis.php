<?php
namespace app\common\validate;
use think\Validate;

class Bis extends Validate
{
	//创建校验的规则
	//Tp5自带的校验的基本形式
	//require属性表示此字段为必填项
			protected $rule     = [
			'name|商户名称'         =>'require|max:50',
			'email|邮箱'          =>'email',
			'logo'              =>'require',
			'licence_logo|营业执照' =>'require',
			'city_id|所属城市'      =>'require',
			'bank_info|银行账户'    =>'require|number',
			'bank_name|开户行名称'   =>'chsAlpha',
			'bank_user|开户行姓名'   =>'chsAlpha',
			'faren|法人姓名'        =>'require',
			'faren_tel|法人电话'    =>'require',
			
			'tel|商家电话'          =>'number',
			'contact|联系人'       =>'require',
			'category_id|所属分类'  =>'require',
			'address|商户地址'      =>'require',
			//'open_time|营业时间'  =>'require',
			
			'username|用户名'      => 'chsAlphaNum|min:5',
			'password|密码'       =>'require',
			];
			
			/**场景设置**/
			protected $scene    = [
			'bis'               => ['name','email','logo','licence_logo','city_id','bank_info','bank_name','bank_user','faren','faren_tel'],
			'account'           => ['username','password'],
			'location'           => ['tel','contect','category_id','address','open_time'],
	];
}