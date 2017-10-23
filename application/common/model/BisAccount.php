<?php

namespace app\common\model;

use think\Model;

//在common目录下创建模型，当我们在其他地方实例化这个模型时，在TP5中，就是会默认去找和这个模型的名称相同的数据表
class BisAccount extends BaseModel
{
	public function updateTimeById($date,$id){
		//使用allowField()来更新post提交的数组中，非数据表字段的数据
		return $this->allowField(true)->save(
				['last_login_time'=>$date],
				['id'=>$id]
			);
	}
}