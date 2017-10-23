<?php
namespace app\common\model;
use think\Model;

/*
公共模型方法，在其他模型中可直接继承本模型类
 */
class BaseModel extends Model
{
    protected $autoWriteTimestamp = true;
    public function bisAdd($data)
    {
        //先给某些字段一个默认值
        $data['status'] = 0;
        $this->save($data);
        return $this->id;
    }

    //根据id，获取当前表中的所有数据
	public function getDataById($id)
	{	
		$data = [
			'id'=>$id,
		];
		$result = $this->where($data)
						->find();
		return $result;
	}
}