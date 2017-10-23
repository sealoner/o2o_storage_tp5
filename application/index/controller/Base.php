<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
class Base extends Controller
{
	public function _initialize() {
		//先获取城市名列表
		//$citys是一个对象，包含所有的城市的数据
		$citys = model('City')->getNormalCitys();
		//dump($citys);exit;
		$this->assign('citys',$citys);

		//获取用户选择的城市名，或session中存储的城市名
		$cityname = $this->getCity($citys);
		$this->assign('cityname',$cityname);

		//获取当前登录的用户的session信息
		$this->assign('useraccount',$this->getLoginUser());

		//调用获取分类信息的方法，再赋值给模板
		$cats = $this->getRecommendcats();
		$this->assign('cats',$cats);

		//动态分配加载文件
		//request()->controller()是获取当前控制器名称；
		//但因为获取到的控制器名称的首字母是大写，所以要使用strtolower()方法把大写的首字母变成小写
		$this->assign('controller',strtolower(request()->controller()));

		//动态分配页面标题名称，先给定一个默认值，如果要动态修改，去对应的控制器及方法中修改
		$this->assign('title','团购商场首页');

		//获取当前url中所带的参数
		$params = request()->param();
		$this->assign('params',$params);
	}

	public function getCity($citys) {
		//因为传递过来的$citys值是一个包含所有城市信息的对象，所以我们对这个对象进行遍历，如果这些数据中的某一个数据中的is_default字段的值为1，
		//则将这条数据的uname值赋给$defaultuname，并break结束遍历
		foreach ($citys as $city) {
			$city = $city->toArray();
			if($city['is_default'] == 1){
				$defaultuname = $city['uname'];
				//如果没有数据的is_default值为1的话，使用三元运算符做一个判断，给它一个默认值
				//这个$defaultname就是在没有选择城市的时候提供给页面的默认值
				//获取数据表中默认显示的城市名，若没有默认则自己规定一个。当选择城市名时，会自动更新为当前选择的用户名
				$defaultuname = $defaultuname ? $defaultuname : 'chuzhou';
				break;
			}
		}
		//接下来，我把把获取到的$defaultname的值保存到session中去
		//input方法，第一个参数为获取到的数据，第二个参数为默认值，第三个参数为作用域
		//
		//如果服务器端存有session值且没有接收到前台传来的1数据，那么就用session中保存的值
		if(session('cityuname','','index') && !input('get.city')){
			$cityuname = session('cityuname','','index');

		//否则（即：没有session值，但是接收到了前台传递过来的数据，那么就把数据保存到session值中）
		}else{
			$cityuname = input('get.city',$defaultuname);
			session('cityuname',$cityuname,'index');
		}
		return $this->cityname = model('City')->where(['uname'=>$cityuname])->find();
	}

	//前台页面的登录退出注册功能已经完成，用户登录时的信息已经存放在session中，所以我们只需要获取session中的信息即可
	public function getLoginUser()
	{
		$useraccount = session('o2o_user','','index');
		if(!$useraccount){
			$useraccount = session('o2o_user','','index');
		}
		return $useraccount;
	}
	/**
	 * 获取后台分类列表（Category表中的数据），将获取到的一级、二级列表数据组合成数组的形式，并在前台页面中显示
	 * @return [type] [description]
	 */
	public function getRecommendcats()
	{
		$parentIds = $sedcatArr = $recomCats = [];
		//首页从category表中获取首页的全部分类中的一级分类
		//getFirstCategoryByParentId第一个参数表示parentId默认为0，第二个参数表示获取前5个数据
		$cats = model('Category')->getFirstCategoryByParentId(0,5);
		//dump($cats);exit;
		//因为$cats获取的是一个数组，但数组中的值是对象，所以需要对这个数组进行foreach遍历，获取到里面的变量
		//又因为，我们需要获取到一级分类全部的parent_id的值，所以需要先声明$parentIds是一个数组，不然最后的返回值就只有一个，就是最后一个数组的值
		foreach ($cats as $cat) {
			//将当前的一级分类的id赋给$parentIds，作为查询它的二级分类的查询条件
			$parentIds[] = $cat->id;
		}
		//把$parentIds作为查询二级分类的查询条件
		$SecCats = model('Category')->getSecCategoryByParentId($parentIds);
		//$SecCats获取到的也是一个数组，但数组中的值是对象，所以也要对它进行遍历
		foreach ($SecCats as $key=>$SecCat) {
			$sedcatArr[$SecCat->parent_id][] = [
				'id'   => $SecCat->id,
				'name' => $SecCat->name,
			];
		}
		//然后把数据进行组合
		foreach ($cats as $key=>$cat) {
			$recomCats[$cat->id] = [$cat->name,empty($sedcatArr[$cat->id]) ? [] : $sedcatArr[$cat->id]];
		}
		return $recomCats;
	}
}
