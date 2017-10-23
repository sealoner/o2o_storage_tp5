<?php
/**
 * 将数据按固定格式返回的方法
 * @param  [type] $status  [状态]
 * @param  [type] $message [提示信息]
 * @param  array  $data    [返回的数据。默认为数组]
 * @return [type]          [description]
 */
function show($status,$message,$data=[]){
	return [
		//intval();   php原生函数，将变量装换成整数类型
		'status'  =>intval($status),
		'message' =>$message,
		'data'    =>$data,
	];
}