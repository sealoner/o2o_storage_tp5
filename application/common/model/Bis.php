<?php

namespace app\common\model;
use think\Model;
//在common目录下创建模型，当我们在其他地方实例化这个模型时，在TP5中，就是会默认去找和这个模型的名称相同的数据表
class Bis extends BaseModel
{
    //获取数据表中status=0的数据
    public function getBisByStatus($status=0)
    {
        $order = [
            'id'=>'desc',
        ];
        $data = [
            'status'=>$status,
        ];
        $result = $this->where($data)
                    ->order($order)
                    ->paginate();
        return $result;
    }
    //获取Bis数据表中所有数据
    public function getBisAllData(){
        $order = [
            'id'=>'desc',
        ];
        $status = [-1,1,2];
        $result = $this->where('status','in',$status)
                       ->order($order)
                       ->paginate();
        return $result;
    }
}