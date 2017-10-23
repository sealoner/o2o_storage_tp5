<?php

namespace app\common\model;

use think\Model;

class Category extends Model
{
    public function add($data)
    {
        //先给某些字段一个默认值
        $data['status'] = 1;
        return $this->save($data);
    }

    //从数据库中获取一级栏目
    public function getNormalFirstCategory()
    {
        $data  = [
            'status'     => 1,
            'parent_id' => 0,
        ];
        $order = [
            'id' => 'desc',
        ];
        return $this->where($data)
            ->order($order)
            ->select();
    }

    public function getFirstCategorys($parentId = 0){
        $data = [
            "parent_id" => $parentId,
            "status" => ['neq',-1],
        ];
        $order = [
            "listorder" => "desc",
            "id"        => "desc",
        ];
        $result = $this->where($data)
            ->order($order)
            ->paginate();//TP5自带的分页类,默认显示15条，已在config.php中修改为默认显示10条
        //使用TP5自带的调试方法：getLastSql();
        //此方法可以打印最后一句sql语句在视图中
        //echo $this->getLastSql();
        return $result;
    }

     /**
     * 默认获取category表中parentid=0的数据
     * @param  integer $parentId [description]
     * @return [type]            [description]
     */
    //方法里面的$parentId是一个形参，它的默认值为0，当这个方法被实例化并传参过来时
    //传递的是一个实参，会替换这个形参的默认值
    public function getNormalCategoryByParentId($parentId=0)
    {
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
     * 前台首页获取一级分类信息
     * @param  integer $id    [赋值给parentId]
     * @param  integer $limit [取前五条数据]
     * @return [type]         [description]
     */
    public function getFirstCategoryByParentId($id=0,$limit=5)
    {
        $data = [
            'parent_id'=>$id,
            'status'   =>1,
        ];
        $order = [
        //也就是说规定两种排序条件，如果listorder字段中的值都相同，就根据id字段的值进行排序
            'listorder' =>'desc',
            'id'        =>'desc',
        ];
        $result = $this->where($data)
                       ->order($order);
        //判断是否有limit这个参数，如果有，就做结果数量限制处理
        //当然，也可以在最后的条件查询中直接调用limit方法，但是这样做更严谨
        if($limit){
            $result = $result->limit($limit);
        }
        return $result->select();
    }

    //把$parentIds作为查询二级分类的查询条件
    public function getSecCategoryByParentId($ids)
    {
        $data = [
            'parent_id'=>['in',implode(',',$ids)],
            'status'   =>1,
        ];
        $order = [
        //也就是说规定两种排序条件，如果listorder字段中的值都相同，就根据id字段的值进行排序
            'listorder' =>'desc',
            'id'        =>'desc',
        ];
        $result = $this->where($data)
                       ->order($order)
                       ->select();
        return $result;
    }
}