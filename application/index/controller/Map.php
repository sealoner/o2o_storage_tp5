<?php
namespace app\index\controller;
use think\Controller;

class Map extends Controller
    {
        public function getMapImage($center) {
            return \Map::staticimage($center);
    }
}