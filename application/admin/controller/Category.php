<?php
namespace app\admin\controller;
use think\Controller;

class Category extends Base
{
    private $obj;
    public function _initialize(){
        $this->obj = model("Category");
    }
    public function index()
    {
        $parentId = input('get.parent_id',0,'intval');
        $categorys = $this->obj->getFirstCategorys("$parentId");
        return $this->fetch('',[
            "categorys"=>$categorys,
        ]);
    }

    public function add()
    {
        $categorys = $this->obj->getNormalFirstCategory();

        return $this->fetch('', [
                'categorys'=>$categorys,
                ]);
    }
    public function save()
    {
        /**
         * 校验
         * 因为form表单规定使用post方式提交的
         */
        if(!request()->isPost()){
            $this->error('请求失败');
        }

        $data           = input('post.');
        $validate       = validate('Category');
        //场景识别：如果validate验证层的Category类中的scene();方法中的从add.html页面提交上来的数据为空，则报错
        //并且在add场景中，只验证'name','parent_id','id'这三个字段
        if (!$validate->scene('add')->check($data)) {
            $this->error($validate->getError());
        }
        //对提交的id字段的值进行校验
        if(!empty($data['id'])){
            return $this->update($data);
        }

        //将$data提交给model层，存入数据库
        $res = $this->obj->add($data);
        if ($res) {
            $this->success('新增成功');
        } else {
            $this->error('添加失败');
        }
    }

    /**
     * 编辑页面
     */
    public function edit($id = 0)
    {
            if(intval($id)<1) {
            $this->error('id：' . $id . '参数不合法');
            }
            //这里我们使用get()方法来获取前台传来的id的值
            //在前面我们实例化了obj，就是在最开始我们设定的$obj->model('category');
            //但是在model层的category类中并没有get();这个方法
            //原因是我们在Category类中继承了model的系统自带的类，这个类中有这个方法
            $category   = $this->obj->get($id);//获取id所在字段的所有数据
            
            $categorys  = $this->obj->getNormalFirstCategory();
            // dump($categorys);exit;
            return $this->fetch('', [
            'categorys' =>$categorys,
            'category'  =>$category,
            ]);
    }


    public function update($data)
    {
        //model层中的save();方法
        $res = $this->obj->save($data,['id'=>intval($data['id'])]);
        if($res){
            $this->success("哦呦，更新成功~");
        }else{
            $this->error("呵呵，更新失败！");
        }
    }

    //排序逻辑（方法）
    public function listorder($id,$listorder){
         //原理就是通过主键id去修改listorder字段的值
        //特别注意！
        //save方法的第二个参数为更新条件
        $res = $this->obj->save(['listorder'=>$listorder],['id'=>$id]);
        if($res){
            $this->result($_SERVER['HTTP_REFERER'],1,'排序更新成功');
        }else{
            $this->result($_SERVER['HTTP_REFERER'],0,'排序更新失败');
        }
    }


}