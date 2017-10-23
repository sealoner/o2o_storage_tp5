<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件
function status($status){
    if($status == 1){
        $str = "<span class='label label-success radius'>正常</span>";
    }elseif($status == 0) {
        $str = "<span class='label label-danger radius'>待审</span>";
    }elseif($status == -1){
        $str = "<span class='label label-default radius'>删除</span>";
    }elseif($status == 2){
    	$str = "<span class='label label-secondary radius'>未通过</span>";
    }
    return $str;
}

/**
 * 判断是否为总店
 * is_main=1，为总店，=0为分店
 */
function is_main($is_main){
	if($is_main == 1){
		$str = "<span class='label label-warning radius'>总店</span>";
	}elseif($is_main == 0){
		$str = "<span class='label label-primary radius'>分店</span>";
	}
	return $str;
}

/**
 * [去Map类库中的getLngLat方法传递来的$url地址中去获取我们需要的数据]
 * @param  [type]  $url  [description]
 * @param  integer $type [0->get;1->post]
 * @param  array   $data [description]
 * @return [type]        [description]
 */
function doCurl($url,$type=0,$data=[]){
	//初始化一个新的curl会话
	$ch = curl_init();
	//设置选项
	//为一个curl设置会话参数
	curl_setopt($ch, CURLOPT_URL, $url);
	//设置只返回结果不返回内容
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	//启用时会将头文件的信息作为数据流输出，如果为0，则不输出
	curl_setopt($ch, CURLOPT_HEADER, 0);

	if($type == 1){
		//设置post方式
		curl_setopt($ch, CURLOPT_POST, 1);
		//表示全部数据使用http协议中的post操作来发送
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	};

	//执行并获取内容
	$output = curl_exec($ch);
	//释放curl句柄
	curl_close($ch);
	return $output;
}

function bisRegister($status){
	if($status == 1){
		$str = "恭喜您，入驻成功";
	}elseif($status == 0){
		$str = "您的信息正在审核中，请耐心等待。若审核通过，我们将以邮件的形式进行通知。";
	}elseif($status == 2){
		$str = "非常抱歉，您提交的材料不符合条件，请重新提交。";
	}else{
		$str = "根据相关法律法规，该申请已被删除。";
	}
	return $str;
}

//自定义分页样式，无需加载Bootstrap
function pagination($obj){
	if(!$obj){
		return '';
	}else{
		$params = request()->param();
		return '<div class="cl pd-5 bg-1 bk-gray mt-20 tp5-o2o">'.$obj->appends($params)->render().'</div>';
	}
}

//分割city_path中的字符串，组合成数组
function getSeCityName($path){
	if(empty($path)){
		return '';
	}
	//preg_match:php原生函数，用来按照我们指定的规则分割字符串
	if(preg_match('/,/',$path)){
		$cityPath = explode(',',$path);
		$cityId = $cityPath[1];
	}else{
		return $cityName = '无';
	}
	$city = model('city')->get($cityId);
	$cityName = $city['name'];
	return $cityName;
}

//分割city_path中的字符串，组合成数组
function getSeCategoryName($path){
	if(empty($path)){
		return '';
	}
	//preg_match:php原生函数，用来按照我们指定的规则分割字符串
	if(preg_match('/,/',$path)){
		$categoryPath = explode(',',$path);
		$categoryPath = $categoryPath[1];
	}else{
		return $categoryName = '无';
	}
	$category = model('category')->get($categoryPath);
	$categoryName = $category['name'];
	return $categoryName;
}

function countLocation($locationIds) {
	//preg_match:php原生函数，用来按照我们指定的规则分割字符串,返回值要么为1（存在匹配规则可以分割），要么为0（没有匹配）
	$pregArr = preg_match('/,/',$locationIds);
	if(!$pregArr) {
		return 1;
	}elseif ($pregArr) {
		$arr = explode(',',$locationIds);
		return count($arr);
	}
}

//支付订单编号生成
function setOrderNum() {
	list($t1,$t2) = explode(' ',microtime());
	$t3 = explode('.',$t1*100000);
	$date = date('YmdHi');
	return $date.$t3[0].(rand(1000,9999));
}
