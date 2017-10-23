<?php
namespace app\admin\controller;
use think\Controller;
use Map;

class Base extends Controller
{
     /**
     * 点击修改状态/代码复用
     * @return [type] [description]
     */
    public function status(){
        $data = input('get.');
        if(!$data){
            $this->error('无法获取id值');
        }
        if(!is_numeric($data['status'])){
            $this->error('状态码出错');
        }
        $model = request()->controller();
        $result = model($model)->save(
                ['status' => $data['status']],
                ['id'     => $data['id']]
            );
        if($result){
            $this->success('状态修改成功');
        }else{
            $this->error('状态修改失败');
        }
    }
    /**
     * 点击进行编辑
     * @return [type] [description]
     */
    public function edit()
    {
        //获取get方法传递的值
        $id = input('get.id');
        $types = input('get.type');
        $model = request()->controller();   
        $type = config('featured.featured_type');
        if(!$id && intval($id)<1){
            $this->error('无法获取ID值');
        }else{
            $results = model($model)->getDataById($id);
            //dump($results);exit;
        }
        return $this->fetch('featured/edit',[
                'results' => $results,
                'type' => $type,
                'showType' => empty([$types])?'':$types,
            ]); 
    }

    /**
     * 查看/只能查看不能修改
     */
    public function show()
    {
        $data = input('get.');
        $id = $data['id'];
        $model = request()->controller(); 

        //获取一级分类名称
        $categoryName = model('Category')->getNormalFirstCategory();

        //获取省份名称
        $provinceName = model('City')->getNormalCitysByParentId();

        //获取城市名称
        $cityName = model('City')->getNormalCitys();

        if(!$id && intval($id)<1){
            $this->error('无法获取ID值');
        }else{
            $results = model($model)->getDataById($id);
            //dump($results);exit;
        };

        return $this->fetch('',[
                'results' => $results,
                'cityName' => $cityName,
                'categoryName' => $categoryName,
                'provinceName' => $provinceName,
            ]);
    }
}
