<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:81:"F:\Aaron\GitHub\o2o_storage_tp5\public/../application/index\view\index\index.html";i:1499180002;s:81:"F:\Aaron\GitHub\o2o_storage_tp5\public/../application/index\view\public\head.html";i:1499224099;s:80:"F:\Aaron\GitHub\o2o_storage_tp5\public/../application/index\view\public\nav.html";i:1499096213;s:81:"F:\Aaron\GitHub\o2o_storage_tp5\public/../application/index\view\public\foot.html";i:1498985999;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="x-ua-compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $title; ?>【<?php echo $cityname['name']; ?>】</title>
    <link rel="shortcut icon" href="">
    <link rel="stylesheet" href="__STATIC__/index/css/base.css" />
    <link rel="stylesheet" href="__STATIC__/index/css/common.css" />
    <link rel="stylesheet" href="__STATIC__/index/css/<?php echo $controller; ?>.css" />
    <script type="text/javascript" src="__STATIC__/index/js/html5shiv.js"></script>
    <script type="text/javascript" src="__STATIC__/index/js/respond.min.js"></script>
    <script type="text/javascript" src="__STATIC__/index/js/jquery-1.11.3.min.js"></script>
</head>
<body>
    <div class="header-bar">
        <div class="header-inner">
            <ul class="father">
                <li><a><?php echo $cityname['name']; ?></a></li>
                <li>|</li>
                <li class="city">
                    <a>切换城市<span class="arrow-down-logo"></span></a>
                    <div class="city-drop-down">
                        <h3>热门城市</h3>
                        <ul class="son">
                        <?php if(is_array($citys) || $citys instanceof \think\Collection || $citys instanceof \think\Paginator): $i = 0; $__LIST__ = $citys;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li><a href="<?php echo url('index/index',['city'=>$vo['uname']]); ?>"><?php echo $vo['name']; ?></a></li>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </div>
                </li>
                <?php if($useraccount): ?>
                <li><a href="<?php echo url('user/logout'); ?>">退出</a></li>
                <li>|</li>
                <li>
                <img src="__STATIC__/index/image/touxiang.jpg" class="touxiang">
                <a>欢迎回来：<?php echo $useraccount['username']; ?></a>
                </li>
                <?php else: ?>
                <li><a href="<?php echo url('user/register'); ?>">注册</a></li>
                <li>|</li>
                <li><a href="<?php echo url('user/login'); ?>">登录</a></li>
                <?php endif; ?>
                <li><a href="<?php echo url('bis/login/index'); ?>">商户中心</a></li>
            </ul>
        </div>
    </div>
    <div class="search">
        <a href="<?php echo url('index/index'); ?>">
            <img src="__STATIC__/index/image/logo.png" />
        </a>
    </div>

    <div class="nav-bar-header">
        <div class="nav-inner">
            <ul class="nav-list">
                <li class="nav-item">
                    <span class="item">全部分类</span>
                    <div class="left-menu">

                    <?php if(is_array($cats) || $cats instanceof \think\Collection || $cats instanceof \think\Paginator): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?>
                        <div class="level-item">
                            <div class="first-level">
                                <dl>
                                    <dt class="title"><a href="<?php echo url('lists/index',['id'=>$key]); ?>" target="_blank"><?php echo $cat[0]; ?></a></dt>
                                    <?php if(is_array($cat[1]) || $cat[1] instanceof \think\Collection || $cat[1] instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($cat[1]) ? array_slice($cat[1],0,2, true) : $cat[1]->slice(0,2, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                    <dd><a href="<?php echo url('lists/index',['id'=>$vo['id']]); ?>" target="_blank" class=""><?php echo $vo['name']; ?></a></dd>
                                    <?php endforeach; endif; else: echo "" ;endif; ?>
                                </dl>
                            </div>
                            <div class="second-level">
                                <div class="section">
                                    <div class="section-item clearfix no-top-border">
                                        <h3>热门分类</h3>
                                        <ul>
                                            <?php if(is_array($cat[1]) || $cat[1] instanceof \think\Collection || $cat[1] instanceof \think\Paginator): $i = 0; $__LIST__ = $cat[1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                            <li><a target="_blank" href="<?php echo url('lists/index',['id'=>$vo['id']]); ?>"><?php echo $vo['name']; ?></a></li>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; endif; else: echo "" ;endif; ?>

                    </div>
                </li>
                <li class="nav-item"><a class="item first active">首页</a></li>
                <li class="nav-item"><a class="item">团购</a></li>
                <li class="nav-item"><a class="item">商户</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="top-container">
            <div class="mid-area">
                <div class="slide-holder" id="slide-holder">
                    <a href="#" class="slide-prev"><i class="slide-arrow-left"></i></a>
                    <a href="#" class="slide-next"><i class="slide-arrow-right"></i></a>
                    <ul class="slideshow">
                    <?php if(is_array($featuredArr[0]) || $featuredArr[0] instanceof \think\Collection || $featuredArr[0] instanceof \think\Paginator): $i = 0; $__LIST__ = $featuredArr[0];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li><a href="<?php echo $vo['url']; ?>" class="item-large"><img class="ad-pic" src="<?php echo $vo['image']; ?>" /></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                    </ul>
                </div>
                <div class="list-container">
                    
                </div>
            </div>
        </div>
        <div class="right-sidebar">
            <div class="right-ad">
                <ul class="slidepic">
                    <?php if(is_array($featuredArr[1]) || $featuredArr[1] instanceof \think\Collection || $featuredArr[1] instanceof \think\Paginator): $i = 0; $__LIST__ = $featuredArr[1];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                        <li><a><img src="<?php echo $vo['image']; ?>" /></a></li>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </ul>
            </div>
            
        </div>
        <div class="content-container">
            <div class="no-recom-container">
                <div class="floor-content-start">
                    
                    <div class="floor-content">
                        <div class="floor-header">
                            <h3>吃货天堂</h3>
                            <ul class="reco-words">
                            <?php if(is_array($meishicats) || $meishicats instanceof \think\Collection || $meishicats instanceof \think\Paginator): $i = 0;$__LIST__ = is_array($meishicats) ? array_slice($meishicats,0,4, true) : $meishicats->slice(0,4, true); if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                                <li><a href="<?php echo url('lists/index',['id'=>$vo['id']]); ?>" target="_blank"><?php echo $vo['name']; ?></a></li>
                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                <li><a href="<?php echo url('lists/index',['id'=>$vo['id']]); ?>" target="_blank" style="border-right: none;">全部〉</a></li>
                            </ul>
                        </div>
                        <ul class="itemlist eight-row-height">
                        <?php if($dealDatas): if(is_array($dealDatas) || $dealDatas instanceof \think\Collection || $dealDatas instanceof \think\Paginator): $i = 0; $__LIST__ = $dealDatas;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
                            <li class="j-card">
                                <a>
                                    <div class="imgbox">
                                        <ul class="marketing-label-container">
                                            <li class="marketing-label marketing-free-appoint"></li>
                                        </ul>
                                        <div class="range-area">
                                            <div class="range-bg"></div>
                                            <div class="range-inner">
                                                <span class="white-locate"></span>
                                                <?php echo $dealDatasAddress['result']['formatted_address']; ?>
                                            </div>
                                        </div>
                                        <div class="borderbox">
                                            <img src="<?php echo $vo['image']; ?>" />
                                        </div>
                                    </div>
                                </a>
                                <div class="contentbox">
                                    <a href="<?php echo url('detail/index',['id'=>$vo['id']]); ?>" target="_blank">
                                        <div class="header">
                                            <h4 class="title ">【<?php echo countLocation($vo['location_ids']); ?>店通用】<?php echo $vo['name']; ?></h4>
                                        </div>
                                        <p><?php echo $vo['name']; ?></p>
                                    </a>
                                    <div class="add-info"></div>
                                    <div class="pinfo">
                                        <span class="price"><span class="moneyico">¥</span><?php echo $vo['current_price']; ?></span>
                                        <span class="ori-price">价值<span class="price-line">¥<span><?php echo $vo['origin_price']; ?></span></span></span>
                                    </div>
                                    <div class="footer">
                                        <span class="comment">4.6分</span><span class="sold">已售<?php echo $vo['buy_count']; ?></span>
                                        <div class="bottom-border"></div>
                                    </div>
                                </div>
                            </li>
                            <?php endforeach; endif; else: echo "" ;endif; else: ?>
                                <span style="color: red;font-size: 30px;">抱歉，此城市暂未开通服务，敬请期待！</span>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="footer-content">
        <div class="copyright-info">

            
        </div>
    </div>

    <script>
        var width = 800 * $("#slide-holder ul li").length;
        $("#slide-holder ul").css({width: width + "px"});

        //轮播图自动轮播
        var time = setInterval(moveleft,5000);

        //轮播图左移
        function moveleft(){
            $("#slide-holder ul").animate({marginLeft: "-737px"},600, function () {
                $("#slide-holder ul li").eq(0).appendTo($("#slide-holder ul"));
                $("#slide-holder ul").css("marginLeft","0px");
            });
        }

        //轮播图右移
        function moveright(){
            $("#slide-holder ul").css({marginLeft: "-737px"});
            $("#slide-holder ul li").eq(($("#slide-holder ul li").length)-1).prependTo($("#slide-holder ul"));
            $("#slide-holder ul").animate({marginLeft: "0px"},600);
        }

        //右滑箭头点击事件
        $(".slide-next").click(function () {
            clearInterval(time);
            moveright();
            time = setInterval(moveleft,5000);
        });

        //左滑箭头点击事件
        $(".slide-prev").click(function () {
            clearInterval(time);
            moveleft();
            time = setInterval(moveleft,5000);
        });
    </script>
</body>
</html>