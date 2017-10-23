<?php
namespace app\common\model;
use think\Model;

/*
公共模型方法，在其他模型中可直接继承本模型类
 */
class User extends BaseModel
{
    public function add($data=[])
    {
    	//dump($data);exit;
    	//先判断传递过来的值是否为数组，如果不是，给一个异常提示
    	if(!is_array($data)){
    		exception('注册信息提交有误');
    	}
        //先给某些字段一个默认值
        $data['status'] = 1;
        //如果一切都符合规则，则把数据存入数据库中
        //allowField(true);   过滤表中无用的字段的值
        return $this->allowField(true)->save($data);
    }

    /**
     * 通过username字段查询是否有符合的数据
     * @param  [type] $username [description]
     * @return [type]           [description]
     */
    public function getUserByUsername($username){
        if(!$username){
            exception('未获取用户名');
        }
        $data = [
            'username'  => $username,
        ];
        $result = $this
                ->allowField(true)
                ->where($data)
                ->find();
        return $result;
    }

    //更新用户最后一次登录时间
    public function updateUserLastTimeById($data,$id)
    {
        return $this->allowField(true)->save($data,['id'=>$id]);
    }
}