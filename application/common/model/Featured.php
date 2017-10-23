<?php
namespace app\common\model;
use think\Model;

//在common目录下创建模型，当我们在其他地方实例化这个模型时，在TP5中，就是会默认去找和这个模型的名称相同的数据表
class Featured extends BaseModel
{
	public function getFeaturedList($types)
	{
		$data = [
			'type'	=> $types,
			'status' => ['neq',-1],
		];
		$order = [
			'id' =>	'desc',
		];
		$result = $this->where($data)
					->order($order)
					->paginate();
		return $result;
	}

	public function getNomalFeatured() {
		$data = [
			'status'	=> 1,
		];
		$order = [
			'id'		=>	'desc',
		];
		$result = $this->where($data)
					   ->order($order)
					   ->select();
		return $result;
	}
}