<?php

namespace app\Common\model;

use think\Model;

class City extends Model
{
	/**
	 * 获取city表中parentid=0的数据
	 * @param  integer $parentId [description]
	 * @return [type]            [description]
	 */
	//方法里面的$parentId是一个形参，它的默认值为0，当这个方法被实例化并传参过来时
	//传递的是一个实参，会替换这个形参的默认值
    public function getNormalCitysByParentId($parentId=0){
    	$data  = [
            'status'     => 1,
            'parent_id' => $parentId,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }
    
    /**
     * 获取城市名
     * @return [type] [description]
     */
    public function getNormalCitys(){
        $data = [
            'status' => 1,
            //parent_id必须是大于0的
            'parent_id' => ['gt',0],
        ];
        $order = [
            'id'=>'desc',
        ];
        $result = $this->where($data)
                    ->order($order)
                    ->select();
        return $result;
    }
}
