<?php
namespace app\admin\controller;
use think\Controller;

class Bis extends Controller
{
    private $obj;
    public function _initialize(){
        $this->obj = model("Bis");
    }

/**
 * 获取审核通过的商家列表
 * @return [type] [description]
 */
    public function index(){
        $status = input('get.status');

        if($status){
            $bis = $this->obj->getBisByStatus($status);
           
        }else{
            $bis = $this->obj->getBisAllData();
        }
        //dump($bis);exit;
        return $this->fetch('',[
            'bis'       =>$bis,
            ]);
        }
/**
 * 后台商户申请列表
 * @return [type] [description]
 */
    public function apply()
    {   
        $bis = $this->obj->getBisByStatus();
        return $this->fetch('',[
                'bis' => $bis,
            ]);
    }
    public function dellist(){
        $bis = $this->obj->getBisByStatus(-1);
        return $this->fetch('',[
            'bis'=>$bis,
            ]);
    }

/**
 * 商户申请详情页
 * @return [type] [description]
 */
    public function detail(){
        $id = input('get.id');
        if(empty($id)){
            return error('无此ID');
        }
        //获取一级城市的数据
        $citys = model('City')->getNormalCitysByParentId();
        //获取一级分类的数据
        $categorys = model('Category')->getNormalCategoryByParentId();

        //获取bis表中的数据
        $bisData = model('bis')->get($id);
        //获取bis_location表中的数据
        $locationData = model('bis_location')->get(['bis_id'=>$id,'is_main'=>1]);
        $accountData = model('bis_account')->get(['bis_id'=>$id,'is_main'=>1]);

        return $this->fetch('',[
            'citys'=>$citys,
            'categorys'=>$categorys,
            'bisData'=>$bisData,
            'locationData'=>$locationData,
            'accountData'=>$accountData,
            ]);
    }

    public function delete(){
        $data = input('get.');
        if($data['status'] == -1){
            $res = $this->obj->save(
            ['status' => $data['status']],
            ['id'     => $data['id']]
            );
        $locationRes = model('BisLocation')->save(
            ['status' =>$data['status']],
            ['bis_id' =>$data['id'],'is_main'=>1] 
            );
        $accountRes = model('BisAccount')->save(
            ['status' =>$data['status']],
            ['bis_id' =>$data['id'],'is_main'=>1]
            );
        if($res && $locationRes && $accountRes){
            $this->success('商户删除成功');
        }else{
            $this->error('商户删除失败');
        }
        }else{
            $this->error('状态码错误');
        }
    }

    /**
     * 点击修改审核状态
     * -1->删除 0->待审核 1->审核通过 2->审核不通过
     * @param  [type] $id     [description]
     * @param  [type] $status [description]
     * @return [type]         [description]
     */
    public function status($id,$status){
        $data = input('get.');
        $validate = validate('category');
        if(!$validate->scene('status')->check($data)){
           $this->error('error');
        }
        $res = $this->obj->save(
            ['status' => $data['status']],
            ['id'     => $data['id']]
            );
        $locationRes = model('BisLocation')->save(
            ['status' =>$data['status']],
            ['bis_id' =>$data['id'],'is_main'=>1] 
            );
        $accountRes = model('BisAccount')->save(
            ['status' =>$data['status']],
            ['bis_id' =>$data['id'],'is_main'=>1]
            );
        if($res && $locationRes && $accountRes){
            $title = '【审核结果】商户入驻申请';
            $status = $data['status'];
            $bisData = model('bis')->get($data['id']);
            if($status == 1){
                $content = "商户【".$bisData['name']."】恭喜您，审核已通过。<br />";
            }elseif($status == 2) {
                 $content = "商户【".$bisData['name']."】非常抱歉，您的审核未通过。<br />";
            }
            \phpmailer\Email::send($bisData['email'],$title,$content);
            $this->success('状态修改成功');
        }else{
            $this->error('状态修改失败');
        }
    }
}