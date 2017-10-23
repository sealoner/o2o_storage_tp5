<?php
namespace app\bis\controller;
use think\Controller;

class Location extends Base{

	public function index(){
		//通过session获取主键id，然后根据主键id去查询当前账号下的分店目录
    	$bisid = $this->getLoginUser()->bis_id;
    	$LocData = model('BisLocation')->getDataByBisId($bisid);
    	//dump($LocData);exit;
        return $this->fetch('',[
        		"LocData" => $LocData,
        	]);
		
	}

	public function add(){
		//将提交的数据存入数据库中
		//那就先需要做一个判断，看看是否有post数据提交
		if(request()->isPost()){
			//如果是的话，就获取当前申请的商户的主键ID
			//但是在POST提交的数据中，都是商户的申请信息，并看不到主键ID
			//因为我们继承的是Base控制器，所以可以通过session来获取主键ID
			//调用Base控制器下的getLoginUser方法
			$data = input('post.');
			$bisId = $this->getLoginUser()->bis_id;
			//校验总店信息
			$validate = validate('Bis');
			if(!$validate->scene('location')->check($data)){
				$this->error($validate->getError());
			}
			//获取经纬度
			$lnglat = \Map::getLngLat($data['address']);
			//dump($lnglat);exit;
			if(empty($lnglat) || $lnglat['status'] !=0){
				$this->error('无法获取地址数据，或地址不精准，请手动添加');
			}
			
			$data['cat'] = '';
			if(!empty($data['se_category_id'])){
				$data['cat'] = implode('|', $data['se_category_id']);
			}

			//信息入库
			$bis_location_data = [
			'bis_id'        =>$bisId,
			'name'          =>$data['name'],
			'logo'          =>$data['logo'],
			'tel'           =>$data['tel'],
			'contact'       =>$data['contact'],
			'category_id'   =>$data['category_id'],
			'category_path' =>$data['category_id'].','.$data['cat'],
			'xpoint'        =>empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
			'ypoint'        =>empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
			'api_address'   =>$data['address'],
			'open_time'     =>empty($data['open_time']) ? '9:00~19:00' : $data['open_time'],
			'city_id'       =>$data['city_id'],
			'city_path'     =>empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
			'content'       => empty($data['content']) ? '' : $data['content'],
			'is_main'		=>0,//默认当前为总店信息
		];
			$bis_location_data_id = model('BisLocation')->bisAdd($bis_location_data);
			//对入库结果进行判断
			if($bis_location_data_id){
				$this->success('申请提交成功');
			}else{
				$this->error('申请提交失败');
			}
		}else{
		//获取一级城市的数据
		$citys = model('City')->getNormalCitysByParentId();
		//获取一级分类的数据
		$categorys = model('Category')->getNormalCategoryByParentId();
		return $this->fetch('',[
			'citys'=>$citys,
			'categorys'=>$categorys,
			]);
		}
	}

	/**
     * 点击修改状态/代码复用
     * @return [type] [description]
     */
    public function status(){
        $data = input('get.');
        if(!$data){
            $this->error('无法获取id值');
        }
        if(!is_numeric($data['status'])){
            $this->error('状态码出错');
        }
        //$model = request()->controller();
        $result = model('BisLocation')->save(
                ['status' => $data['status']],
                ['id'     => $data['id']]
            );
        if($result){
            $this->success('状态修改成功');
        }else{
            $this->error('状态修改失败');
        }
    }
}