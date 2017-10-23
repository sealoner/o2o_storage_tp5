<?php
namespace app\api\controller;
use think\Controller;
use think\Request;
use think\File;

//Tp5自带了文件上传类
///thinkphp/library/think/Request.php中的file方法
class Image extends Controller
{
	public function upload(){
		$file = Request::instance()->file('file');
		//规定上传文件的存储目录
		//move()是TP5自带的方法，如果出现上传失败，很有可能是因为文件超过了默认值2M，需要在php配置文件中修改
		$info = $file->move('uploads');
		//sprint_r($info);exit;
		if($info && $info->getPathname()){
			//sucess后面的‘/’表示网站的入口文件（默认为public）
			return show(1,'文件上传成功','/'.$info->getPathname());
		}
			return show(0,'文件上传失败');
	}
}