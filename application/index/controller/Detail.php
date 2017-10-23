<?php
namespace app\index\controller;
use think\Controller;

class Detail extends Base
{
    public function index() {
        $flag = '';
        $id = input('get.');
        $deal = model('Deal')->get($id);
        if(!$id || !intval($id)) {
            $this->error('无法获取商品信息','index/index');
        }
        if(!$deal){
            $this->error('此商品已下架','lists/index');
        }

        //获取当前分类信息
        $categorys = model('Category')->get($deal->category_id);

        //获取当前团购信息,只获deal表中的location_ids字段中的第一个值，以此为条件进行查询
        $locations = model('BisLocation')->getLocationsById($deal->location_ids);

        //获取团购商品的门店信息，并将门店信息遍历到前台模块中
        $location_name = explode(',',$deal['location_ids']);
        $locationData = model('BisLocation')->getLocationByLocationName($location_name);

        //组合团购开始时间（时分秒）
        //给一个变量（$flag），用0和1来划定团购开始状态
        //若$flag_begin=0，则团购未开始；若$flag_begin=1，则团购开始
        //start_time表示团购开始时间，如果start_time大于当前时间，则表示团购未开始
        if($deal->start_time < time() && time()<$deal->end_time) {
            //团购已开始，计算团购结束时间
            $flag = 1;
            $dtime = $deal->end_time-time();
            //计算天
            $d = floor($dtime/(3600*24));
            //计算时
            $m = floor($dtime%(3600*24)/3600);
            //计算分
            $s = floor($dtime%(3600*24)%3600/60);
            //组合
            $endtime = $d.'天'.$m.'小时'.$s.'分';
            $this->assign('endtime',$endtime);
        }elseif($deal->start_time > time()) {
             //团购未开始，计算团购开始时间
            $flag = 0;
            $dtime = $deal->start_time-time();
            //计算天
            $d = floor($dtime/(3600*24));
            //计算时
            $m = floor($dtime%(3600*24)/3600);
            //计算分
            $s = floor($dtime%(3600*24)%3600/60);
            //组合
            $begintime = $d.'天'.$m.'小时'.$s.'分';
            $this->assign('begintime',$begintime);
        } elseif($deal->end_time < time()) {
            $flag = -1;
        }

        /**
         * surplus为产品剩余数
         */
        return $this->fetch('',[
                'deal'      =>$deal,
                'categorys' =>$categorys,
                'locations' =>$locations,
                'surplus'   =>$deal->total_count-$deal->buy_count,
                'title'     =>$deal['name'],
                'flag'      =>$flag,
                'baiduMap'  =>$locations[0]['xpoint'].','.$locations[0]['ypoint'],
                'locationData'=>$locationData,
            ]);
    }
}
