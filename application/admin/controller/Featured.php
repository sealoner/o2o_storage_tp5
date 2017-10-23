<?php
namespace app\admin\controller;
use think\Controller;
use Map;

class Featured extends Base
{
	private $obj;
    public function _initialize()
    {
        $this->obj = model("Featured");
    }

    public function index()
    {
        $data = input('get.');
        $types = input('get.type');
        if($types != null){
            //dump($types);
            $results = $this->obj->getFeaturedList($types);
        }else{
            $results = $this->obj->paginate();
        }
        $type = config('featured.featured_type');
        return $this->fetch('',[    
                'results'=>$results,
                'type' => $type,
                'showType' => empty([$types])?'':$types,
            ]);
    }

    public function add(){
        if(request()->isPost()){
            $data = input('post.');
            //对获取的前台信息进行验证
            $validate = validate('Featured');
            $result = $validate->scene('add')->check($data);
            $data['url'] = 'http://'.$data['url'];
            if($result){
                $id = model('Featured')->bisadd($data);
                if($id){
                    $this->success('推荐位添加成功');
                }else{
                    $this->error('添加失败，请重新添加');
                }
            }else{
                return $this->error($validate->getError());
            }
        }else{
        $type = config('featured.featured_type');
        return $this->fetch('',[
                'type' => $type,
            ]);
        }
    }
}

