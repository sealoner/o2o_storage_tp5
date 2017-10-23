<?php
namespace app\api\controller;
use think\Controller;
use think\Request;

class City extends Controller
{
    private $obj;
    public function _initialize(){
        $this->obj = model("City");
    }
    /**
     * 显示资源列表
     *
     * @return \think\Response
     */
    public function getCitysByParentId()
    {
        //获取前台提交的json数据
        $id = input('post.id');
        if(!$id){
            $this->error('ID错误');
        }
        //根据上级城市id获取下一级的城市id
        $citys = $this->obj->getNormalCitysByParentId($id);
        //下面我们需要把获取到的$citys以一种规定的数据格式返回给前端，让JS可以获取到，并返回对应的数据
        //TP5自带有result方法，可以将数据返回固定的格式
        //但是这里我们也可以新建一个属于我们自己的方法
        //原因是，如果以后这个API被用于别的地方，或者说不再继承Controller这个类了，那么result方法也就不能用了
        //在当前模块（api）下的common.php中定义我们需要的方法
        if(!$citys){
            return show(0,'error');
        }
        return show(1,'success',$citys);     
    }
}