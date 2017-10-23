<?php
namespace app\bis\controller;
use think\Controller;
use Map;
class Register extends Controller
{
	public function index()
	{
		//获取一级城市的数据
		$citys = model('City')->getNormalCitysByParentId();
		//获取一级分类的数据
		$categorys = model('Category')->getNormalCategoryByParentId();
		return $this->fetch('',[
			'citys'=>$citys,
			'categorys'=>$categorys,
			]);

	}

	public function add(){
		//判断是否通过get/post方式提交数据
		if(!request()->isPost()){
			$this->error('请求错误');
		}
		//获取表单的值
		$data = input('post.');
		//print_r($data);exit;
		
		//检查商户名是否被占用
		$bisnameResult = Model('Bis')->get(['name'=>$data['name']]);
		if($bisnameResult){
			$this->error('该商户名已存在，请重新输入。');
		}

		//检查用户名是否被占用
		$accountResult = Model('BisAccount')->get(['username'=>$data['username']]);
		if($accountResult){
			$this->error('用户名已被占用，请输入密码或使用其他用户名。');
		}

		//校验基本信息
		$validate = validate('Bis');
		if(!$validate->scene('bis')->check($data)){
			$this->error($validate->getError());
		}

		//校验总店信息
		if(!$validate->scene('location')->check($data)){
			$this->error($validate->getError());
		}

		//校验账户信息
		if(!$validate->scene('account')->check($data)){
			$this->error($validate->getError());
		}

		//获取经纬度
		$lnglat = Map::getLngLat($data['address']);
		//print_r($lnglat);exit;
		if(empty($lnglat) || $lnglat['status'] !=0 || $lnglat['result']['precise'] !=1){
			$this->error('无法获取地址数据，或地址不精准，请手动添加');
		}

		//商户基本信息入库
		$bisData = [
			'name'         =>$data['name'],
			'email'        =>$data['email'],
			'logo'         =>$data['logo'],
			'licence_logo' =>$data['licence_logo'],
			'city_id'      =>$data['city_id'],
			'city_path'    =>empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
			'bank_info'    =>$data['bank_info'],
			'bank_name'    =>$data['bank_name'],
			'bank_user'    =>$data['bank_user'],
			'faren'        =>$data['faren'],
			'faren_tel'    =>$data['faren_tel'],
			'description'  => empty($data['description']) ? '' : $data['description'],
		];
		$bisId = model('Bis')->bisAdd($bisData);

		//总店信息入库
		$data['cat'] = '';
		if(!empty($data['se_category_id'])){
			$data['cat'] = implode('|', $data['se_category_id']);
		}
		$bis_location_data = [
			'name'          =>$data['name'],
			'logo'          =>$data['logo'],
			'tel'           =>$data['tel'],
			'contact'       =>$data['contact'],
			'category_id'   =>$data['category_id'],
			'category_path' =>$data['category_id'].','.$data['cat'],
			'xpoint'        =>empty($lnglat['result']['location']['lng']) ? '' : $lnglat['result']['location']['lng'],
			'ypoint'        =>empty($lnglat['result']['location']['lat']) ? '' : $lnglat['result']['location']['lat'],
			'api_address'       =>$data['address'],
		 	'bank_info'     =>$data['bank_info'],
			'bis_id'        =>$bisId,
			'open_time'     =>empty($data['open_time']) ? '9:00~19:00' : $data['open_time'],
			'city_id'       =>$data['city_id'],
			'city_path'     =>empty($data['se_city_id']) ? $data['city_id'] : $data['city_id'].','.$data['se_city_id'],
			'content'       => empty($data['content']) ? '' : $data['content'],
			'is_main'		=>1,//默认当前为总店信息
		];
		$bis_location_data_id = model('BisLocation')->bisAdd($bis_location_data);
			
		//账户信息入库
		//自动生成为密码加盐的字符串
		//rand()与mt_rand()均可生成随机字符串，但mt_rand()比rand()快四倍
		$data['code'] = md5(mt_rand(10,100000));
		$bis_account_data = [
			'username' => $data['username'],
			'password' => md5($data['password'].$data['code']),
			'code'		=> $data['code'],
			'is_main'	=>1,//表示默认申请时，分配给总管理员
			'last_login_ip'=> $_SERVER["REMOTE_ADDR"],
			'last_login_time'=>date("Y-m-d H:i:s"),
			'bis_id'   =>$bisId,
		];
		$bis_account_data_id = model('BisAccount')->bisAdd($bis_account_data);	

		if(!$bis_account_data_id){
			$this->error('信息提交失败，请在核实后重新填写。');
		}

		//发送邮件
		//这个url为我们项目的url地址
		$url = request()->domain().url('bis/register/waiting',['id'=>$bisId]);
		$title = '商户入驻申请通知';
		$content = "您提交的<b style='color:red'>“".$data['name']."”</b>商户入驻申请正在等待平台方审核，您可以通过点击链接<a href='".$url."' target='_blank'>查看链接</a>，查看当前审核状态";

		\phpmailer\Email::send($data['email'],$title,$content);
		$this->success('申请成功',url('register/waiting',['id'=>$bisId]));
	}

		public function waiting($id){
			if(empty($id)){
				$this->error('商户信息不存在');
			}

			$detail = model('Bis')->get($id);
			return $this->fetch('',[
					'detail'=>$detail,
				]);
		}
}