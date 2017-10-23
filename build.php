<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

return [
    // 生成应用公共文件
    '__file__' => ['common.php', 'config.php', 'database.php'],

    // 定义demo模块的自动生成 （按照实际定义的文件名生成）
    // 'demo'     => [
    //     '__file__'   => ['common.php'],
    //     '__dir__'    => ['behavior', 'controller', 'model', 'view'],
    //     'controller' => ['Index', 'Test', 'UserType'],
    //     'model'      => ['User', 'UserType'],
    //     'view'       => ['index/index'],
    // ],
    // 其他更多的模块定义
    
    //公共模块
        'common'     => [
            '__dir__'    => ['model'],
            'model'      => ['Category','Admin'],
        ],
        //前台模块
        'index'      =>[
            '__dir__'    =>['view'],
            'view'       =>['index/index','public/head','public/nav'],
        ],
        //主后台模块
        'admin'      =>[
            '__dir__'    => ['controller','view'],
            'controller' =>['Index'],
            'view'       =>['index/index'],
        ],
        //接口模块
        'api'        =>[
            '__dir__'    =>['controller','view'],
            'controller' =>['Index','Image'],
        ],
        //商家后台模块
        'useradmin' =>[
            '__dir__'=>['controller','view'],
            'controller'=>['Index'],
            'view'      =>['index','public'], 
        ],
        'bis' => [
            '__dir__' => ['controller','view'],
            'controller'=> ['Register','Login'],
        ],

];
