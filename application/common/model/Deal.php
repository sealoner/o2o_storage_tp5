<?php

namespace app\common\model;

use think\Model;

//在common目录下创建模型，当我们在其他地方实例化这个模型时，在TP5中，就是会默认去找和这个模型的名称相同的数据表
class Deal extends BaseModel
{
	/**
	 * 根据bisid获取团购信息表
	 * @param  [type] $bisid [description]
	 * @return [type]        [description]
	 */
	public function getDealDataByBisId($bisid){
		if(!$bisid){
			return '';
		}else{
			$data=[
				'bis_id' => $bisid,
			];
			$order=[
				'id'	=>'desc',
			];
			$result = $this->where($data)
					->order($order)
					->paginate();
			return $result;
		}
	}

	/**
	 * 获取bis表中的所有未通过申请的数据
	 */
	public function getDealDataByStatus($status = 0)
	{
		$order = [
			'id'=>'desc',
		];
		$data = [
			'status' => $status,
		];
		$result = $this->where($data)
						->order($order)
						->paginate();
		return $result;
	}

	public function getNormalDeals($ndata = [])
	{
		$order = [
			'id'=>'desc',
		];
		$ndata['status'] = 1;
		$result = $this->where($ndata)
					->order($order)
					->paginate();
		//echo $this->getLastSql();
		return $result; 
	}

	/**
	 * 通过我们选择的城市名的城市id，去deal表中获取对应的se_city_id字段的值（城市id）
	 * @param  [type]  $catId  [分类表中的id]
	 * @param  [type]  $cityId [获取到的城市id]
	 * @param  integer $limit  [获取的数据的总条数]
	 * @return [type]          [description]
	 */
	public function getNomalDealBySeCityId($catId,$secityId,$limit=10)  {
		$data = [
			'end_time'    => ['gt',time()],
			'category_id' => $catId,
			'se_city_id'  => $secityId,
			'status'      => 1,
		];
		$order = [
			'listorder'	=>	'desc',
			'id'		=>	'desc',
		];
		$result = $this->where($data)
						->order($order);
		if($limit){
			$result = $result->limit($limit);
		}
		$result  = $result->select();
		return $result;
	}

	public function getDealByConditions($data=[],$orders=[]) {
		//print_r($orders);exit;
		if(!empty($orders['order_sales'])) {
			$order['buy_count']	 = 'desc';
		}elseif(!empty($orders['order_price'])) {
			$order['current_price']	 = 'desc';
		}elseif(!empty($orders['order_time'])) {
			$order['create_time']	 = 'desc';
		}else {
			$order['id'] = 'desc';
		}
		return $result = $this->where($data)
					   ->order($order)
					   ->paginate();
	}
}