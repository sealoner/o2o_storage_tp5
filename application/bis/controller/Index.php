<?php
namespace app\bis\controller;
use think\Controller;
use think\DB;
class Index extends Base
{

    public function index()
    {	
    	return $this->fetch();
    }
}
