<?php
namespace app\index\controller;
use think\Controller;

class Index extends Base
{
    public function index()
    {
    	//获取前台大图、广告位图片信息
    	$featuredArr = [];
    	$type = config('featured.featured_type');
    	$featuredData = model('Featured')->getNomalFeatured();
    	foreach ($featuredData as $key => $featureds) {
    		$featuredArr[$featureds->type][]=[
    			'title'	=>  $featureds->title,
    			'image'	=>	$featureds->image,
    			'url'	=>	$featureds->url,	
    		];
    	}
        $this->assign('featuredArr',$featuredArr);

        //将产品详情放入页面
        //因为团购信息是根据栏目分类的，所以先获取美食类的信息放入
        //同时，信息是根据我们在页面头部的城市来获取的
        $dealDatas = model('Deal')->getNomalDealBySeCityId(33,$this->cityname->id);
        
        //根据经纬度获取地址
        foreach ($dealDatas as $dealData) {
            $lng = $dealData->xpoint;
            $lat = $dealData->ypoint;
            if($lng && $lat) {
                $dealDatasAddress = \Map::getAddressByLngLat($lng,$lat);
                $this->assign('dealDatasAddress',$dealDatasAddress);
            }
        }
        //获取美食的子分类
        $meishicats = model('Category')->getNormalCategoryByParentId(33);    	
    	return $this->fetch('',[
                'dealDatas'  =>$dealDatas,
                'meishicats' =>$meishicats,
            ]);
    }
}
