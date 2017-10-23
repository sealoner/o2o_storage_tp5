<?php
namespace app\common\model;
use think\Model;

//在common目录下创建模型，当我们在其他地方实例化这个模型时，在TP5中，就是会默认去找和这个模型的名称相同的数据表
class BisLocation extends BaseModel
{
	//根据bis_id来获取BisAccount表中的数据(有分页)
	public function getDataByBisId($bisid)
	{
		$order = [
			'id' => 'desc',
		];
		$data = [
			'bis_id' => $bisid
		];
		$result = $this->where($data)
					   ->order($order)
					   ->paginate(10);
		// dump($result);exit;
		return $result;
	}
	//根据bis_id获取底下的分店（无分页）
	public function getNomalByBisId($bisid){
		$data = [
			'bis_id'=>$bisid,
		];
		$order = [
			'id'=>'desc',
		];
		$result = $this->where($data)
					->order($order)
					->select();
		return $result;
	}

	public function getLocationsById($id) {
		$ids = explode(',',$id);
		$data = [
			'name' => ['in',$ids[0]],
			'status' => 1,
		];
		return $this->where($data)->select();

	}

	//根据门店名称获取门店信息
	public function getLocationByLocationName($names) {
		$data = [
			'name'=>['in',$names],
			'status'=>1,
		];
		$order = [
			'listorder' =>'desc',
			'id'	=>'desc',
		];
		return $result = $this->where($data)->order($order)->select();
	}
}