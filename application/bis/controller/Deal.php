<?php
namespace app\bis\controller;
use think\Controller;
use think\DB;
class Deal extends Base
{

    public function index()
    {	
    	$bisid = $this->getLoginUser()->bis_id;
    	$dealdata = model('Deal')->getDealDataByBisId($bisid);
	    return $this->fetch('',[
	    		'dealdata'=>$dealdata,
	    	]);
    }

    public function add(){

    	//根据bis_id获取门店列表
    	$bisid = $this->getLoginUser()->bis_id;
    	$bislocations = model('BisLocation')->getNomalByBisId($bisid);
    	//获取表单提交数据并校验
		if(request()->isPost()){
			$dealData = input('post.');
			$validate = validate('Deal');
			if(!$validate->check($dealData)){
				$this->error($validate->getError());
			}
			//获取第一个门店的经纬度，然后存入数据表
			//这句话的意思就是：先实例化BisLocation的模型类，连接到数据表，然后根据表单提交的数据，获取location_ids这一字段值，使用它的第一个数组的值作为查询条件
			$dealname=$dealData['location_ids'][0];
			$location = model('BisLocation')->get(['name'=>$dealname]);
			//验证通过，团购信息入库
			$bisDeal = [
				'name'               =>$dealData['name'],
				'category_id'        =>$dealData['category_id'],
				'se_category_id'     =>empty($dealData['se_category_id'])?'':implode(',',$dealData['se_category_id']),
				'bis_id'             =>$bisid,
				'location_ids'       =>empty($dealData['location_ids'])?'':implode(',',$dealData['location_ids']),
				'image'              =>$dealData['image'],
				'description'        =>$dealData['description'],
				'start_time'         =>strtotime($dealData['start_time']),
				'end_time'           =>strtotime($dealData['end_time']),
				'origin_price'       =>$dealData['origin_price'],
				'current_price'      =>$dealData['current_price'],
				'city_id'            =>$dealData['city_id'],
				'se_city_id'         =>empty($dealData['se_city_id'])?'':$dealData['se_city_id'],
				'total_count'        =>$dealData['total_count'],
				'coupons_begin_time' =>strtotime($dealData['coupons_begin_time']),
				'coupons_end_time'   =>strtotime($dealData['coupons_end_time']),
				'description'        =>$dealData['description'],
				'notes'              =>$dealData['notes'],
				'xpoint'             =>$location->xpoint,
				'ypoint'             =>$location->ypoint,
			];
			$id = model('Deal')->bisAdd($bisDeal);
			if($id){
				$this->success("提交成功，请等待审核",url('deal/index'));
			}else{
				$this->error('团购方案提交失败，请检查后重新提交');
			}
		}else{
			//获取一级城市的数据
			$citys = model('City')->getNormalCitysByParentId();
			//获取一级分类的数据
			$categorys = model('Category')->getNormalCategoryByParentId();
			//获取前台的传输数据
			return $this->fetch('',[
			'citys'=>$citys,
			'categorys'=>$categorys,
			'bislocations'=>$bislocations,
			]);
		}
    }
}



