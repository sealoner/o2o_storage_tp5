<?php
namespace app\index\controller;
use think\Controller;

class Lists extends Base
{
	public function index (){
		$firArr = [];
		$data   = [];
		$orders = [];
		$secategoryData = [];
		$id = input('id',0,'intval');
		//获取一级分类数据
		$fircats = model('Category')->getNormalFirstCategory();
		//遍历一级分类的所有id，组合成数组
		foreach ($fircats as $fircat) {
			$firArr[] = $fircat->id;
		}

		//获取二级分类数据
		//分情况：
		//id=0时，数据没获取到；id为一级分类的id；id为二级分类的id
		//使用in_array()方法，判断获取到的id值是否在一级分类id集合的数组中，如果在的话就说明我们选择的是一级分类
		//最终的目的是通过parent_id字段，去category表中查询对应的值
		//
		//$categoryParentId的值总为一级分类的id
		if(in_array($id,$firArr)) {  //一级分类
			//如果获取到的$id存在于一级分类id组成的数组，那么用户选择的就是一级分类
			//把值赋给$categoryParentId
			$categoryParentId = $id;
			$data['category_id'] = $categoryParentId;
		}elseif($id) {	//二级分类
			//如果获取到的$id在$firArr数组中没有匹配值，则说明用户选择的不是一级分类
			//那我们假设用户选择的是二级分类
			$categoryData = model('Category')->get($id);
			if(!$categoryData || $categoryData->status != 1) {
				$this->error('无法获取数据');
			}
			$categoryParentId = $categoryData['parent_id'];
			$data['se_category_id'] = $id;
		}else {	//0
			$categoryParentId = 0;
			//print_r($categoryParentId);exit;
		}
		//判断用户点击的是何种分类之后，需要把该分类下的子分类列出来
		//根据上级分类的parent_id获取此分类的子分类
		if($categoryParentId) {
			$secategoryData = model('Category')->getNormalCategoryByParentId($categoryParentId);
		}
		//排序逻辑
		$order_sales = input('order_sales','');
		$order_price = input('order_price','');
		$order_time = input('order_time','');
		if(!empty($order_sales)) {
			$orderflag = 'order_sales';
			$orders['order_sales'] = $order_sales;
		}elseif(!empty($order_price)) {
			$orderflag = 'order_price';
			$orders['order_price'] = $order_price;
		}elseif(!empty($order_time)) {
			$orderflag = 'order_time';
			$orders['order_time']  = $order_time;
		}else {
			$orderflag = '';
		}
		//$orders是一个数组，设定的三个值都是1，这里设置$orders数组的主要作用就是为了当我们点击排序按钮时，让它可以传递来一个值，可以让程序知道对应的字段是有值的，也就代表着该排序按钮被选中了
		$deals = model('Deal')->getDealByConditions($data,$orders);
		$dealArr = $deals->toArray();
		return $this->fetch('',[
				'fircats'          =>$fircats,
				'categoryParentId' =>$categoryParentId,
				'id'               =>$id,
				'secategoryData'   =>$secategoryData,
				'orderflag'		   =>$orderflag,
				'deals'			   =>$deals,
				'dealArr'		   =>$dealArr,
			]);
	}
}