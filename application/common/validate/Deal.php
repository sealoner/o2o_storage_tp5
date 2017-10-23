<?php
namespace app\common\validate;
use think\Validate;

class Deal extends Validate
{
	//创建校验的规则
	//Tp5自带的校验的基本形式
	//require属性表示此字段为必填项
			protected $rule               = [
			'name|团购名称'                   =>'require|max:50',
			'city_id|所属城市'                   =>'require',
			'category_id|所属分类'              =>'require',
			'location_ids|支持门店'         =>'require',
			'image|缩略图'                   =>'require',
			'start_time|团购开始时间'           =>'require',
			'end_time|团购结束时间'             =>'require',
			'total_count|库存数'             =>'require|number',
			'origin_price|原价'             =>'require|number',
			'current_price|团购价'           =>'require|number',
			'coupons_begin_time|消费券生效时间：' =>'require',
			'coupons_end_time|消费券结束时间'    =>'require',
			'description|团购描述：'           =>'require',
			'notes|购买须知：'                 =>'require',
			];
			
			/**场景设置**/
			
}