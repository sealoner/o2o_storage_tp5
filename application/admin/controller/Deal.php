<?php
namespace app\admin\controller;
use think\Controller;
use Map;

class Deal extends Base
{
	
    public function index()
    {
        $ndata = [];
        $data = input('post.');

        $cityArr = $categoryArr = $provinceArr = [];
        //获取一级分类名称
        $categoryName = model('Category')->getNormalFirstCategory();
        foreach($categoryName as $categorys){
            $categoryArr[$categorys['id']] = $categorys['name'];
        }

        //获取省份名称
        $provinceName = model('City')->getNormalCitysByParentId();
        foreach ($provinceName as $provinces) {
            $provinceArr[$provinces['id']] = $provinces['name'];
        }

        //获取城市名称
        $cityName = model('City')->getNormalCitys();
        foreach ($cityName as $cityNames) {
            $cityArr[$cityNames['id']] = $cityNames['name'];
        }

        if(!empty($data['category_id'])){
            $ndata['category_id'] = $data['category_id'];
        }
        if(!empty($data['city_id'])){
            $ndata['city_id'] = $data['city_id'];
        }
        if(!empty($data['se_city_id'])){
            $ndata['se_city_id'] = $data['se_city_id'];
        }
        if(!empty($data['start_time']) && !empty($data['end_time']) && strtotime($data['end_time']) > strtotime($data['start_time'])){
            $ndata['create_time'] = [
                ['gt',strtotime($data['start_time'])],
                ['lt',strtotime($data['end_time'])],
            ];
        }
        if(!empty($data['name'])){
            $ndata['name'] = ['like','%'.$data['name'].'%'];
        }
        //dump($ndata);exit;
        $dealAllData = model('Deal')->getNormalDeals($ndata);
        return $this->fetch('',[
                'categoryName' => $categoryName,
                'cityName'     => $cityName,
                'provinceName' => $provinceName,  
                'dealAllData'  => $dealAllData,
                //对模板变量做判断，使得我们的搜索信息能够保留
                'categoryid'   => empty($data['category_id'])?'':$data['category_id'],
                'cityid'       => empty($data['city_id'])?'':$data['city_id'],
                'startTime'    => empty($data['start_time'])?'':$data['start_time'],
                'endTime'      => empty($data['end_time'])?'':$data['end_time'],
                'name'         => empty($data['name'])?'':$data['name'],

                'categoryArr'  => $categoryArr,
                'cityArr'      => $cityArr,
                'provinceArr'  => $provinceArr,
            ]);
    } 


    public function deallist()
    {
        $getDealDataByStatus = model('Deal')->getDealDataByStatus();
        return $this->fetch('',[
                'getDealDataByStatus' => $getDealDataByStatus,
            ]);
    }

}
