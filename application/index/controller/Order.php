<?php
namespace app\index\controller;
use think\Controller;

class Order extends Base {
	/**
	 * 支付信息入库
	 * @return [type] [description]
	 */
	public function index() {
		//判断用户是否登录
		$user = $this->getLoginUser();
		if(!$user) {
			$this->error('请先登录','user/login');
		}
		//获取支付商品的id
		$id = input('get.id',0,'intval');
		if(!$id) {
			$this->error('参数获取失败，请重新支付','order/confirm');
		}
		//根据id获取商品信息
		$deal = model('Deal')->get($id);
		if(!$deal || $deal->status!=1) {
			$this->error('商品不存在','index/index');
		}	
		//判断url格式是否正确
		//$_SERVER['HTTP_REFRERE']  获取当前页面的前一页面的url地址
		if(empty($_SERVER['HTTP_REFERER'])) {
			$this->error('请求错误！');
		}
		//获取url中的另外两个参数
		$dealCount  = input('get.deal_count',0,'intval');
		$totalPrice = input('get.total_price');
		//生成out_trade_no，订单编号
		$orderNum = setOrderNum();
		//数据入库
		$data = [
			'out_trade_no' => $orderNum,
			'user_id'=>$user->id,
			'username'=>$user->username,
			'deal_id'=>$id,
			'deal_count'=>$dealCount,
			'total_price'=>$totalPrice,
			'referer'=>$_SERVER['HTTP_REFERER'],
		];
		//错误校验机制
		try {
			$order = model('Order')->add($data);
		}catch(\Exception $e) {
			$this->error('订单支付失败');
		}
		$orderId = model('Order');
		$this->redirect(url('pay/index',['id'=>$orderId->id]));
	}

	/**
	 * 支付逻辑
	 * @return [type] [description]
	 */
	public function confirm() {
		//判断是否登录
		if(!$this->getLoginUser()) {
			$this->error('请登录','user/login');
		}
		//获取选择的商品的信息
		$count = input('get.count',1,'intval');
		$id = input('get.id',0,'intval');
		if(!$id) {
			$this->error('数据获取异常');
		}
		//当前的$deal为对象的格式
		$deal = model('Deal')->find($id);
		if(!$deal || $deal['status']!=1) {
			$this->error('商品不存在');
		}
		//将$deal的数据类型装换为数组，当然不转换也可以，但是数据格式好看
		$deal = $deal->toArray();
		//dump($deal);exit;
		return $this->fetch('',[
				'controller'	=>'pay',
				'deal'			=>$deal,
			]);
	}
}