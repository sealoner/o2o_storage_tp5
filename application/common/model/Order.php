<?php

namespace app\common\model;

use think\Model;

class Order extends Model
{
    public function add($data)
    {
        //先给某些字段一个默认值
        $data['status'] = 1;
        $result = $this->save($data);
        return $result;
    }

}