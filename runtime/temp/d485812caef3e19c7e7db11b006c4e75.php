<?php if (!defined('THINK_PATH')) exit(); /*a:3:{s:71:"F:\Aaron\GitHub\tp5_o2o\public/../application/admin\view\bis\index.html";i:1496818880;s:75:"F:\Aaron\GitHub\tp5_o2o\public/../application/admin\view\public\header.html";i:1497836203;s:75:"F:\Aaron\GitHub\tp5_o2o\public/../application/admin\view\public\footer.html";i:1497844136;}*/ ?>
<!--包含头部文件-->
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<meta name="renderer" content="webkit|ie-comp|ie-stand">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no" />
<meta http-equiv="Cache-Control" content="no-siteapp" />
<LINK rel="Bookmark" href="/favicon.ico" >
<LINK rel="Shortcut Icon" href="/favicon.ico" />
<!--[if lt IE 9]>
<script type="text/javascript" src="lib/html5.js"></script>
<script type="text/javascript" src="lib/respond.min.js"></script>
<script type="text/javascript" src="lib/PIE_IE678.js"></script>
<![endif]-->
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui/css/H-ui.min.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui.admin/css/H-ui.admin.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/lib/Hui-iconfont/1.0.8/iconfont.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/lib/icheck/icheck.css" />
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui.admin/skin/default/skin.css" id="skin" />
<link rel="stylesheet" type="text/css" href="__STATIC__/admin/hui/static/h-ui.admin/css/style.css" />
<link rel="stylesheet" href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link rel="stylesheet" type="text/css" href="__STATIC__/admin/css/common.css" />
  <link rel="stylesheet" type="text/css" href="__STATIC__/admin/uploadify/uploadify.css" />
<!--[if IE 6]>
<script type="text/javascript" src="http://lib.h-ui.net/DD_belatedPNG_0.0.8a-min.js" ></script>
<script>DD_belatedPNG.fix('*');</script>
<![endif]-->
<title>o2o平台</title>
<meta name="keywords" content="tp5打造o2o平台系统">
<meta name="description" content="o2o平台">
</head>
<body>
<nav class="breadcrumb"><i class="Hui-iconfont">&#xe67f;</i> 首页 <span class="c-gray en">&gt;</span> 商家管理 <span class="c-gray en">&gt;</span> 未通过审核商户列表 <a class="btn btn-success radius r" style="line-height:1.6em;margin-top:3px" href="javascript:location.replace(location.href);" title="刷新" ><i class="Hui-iconfont">&#xe68f;</i></a></nav>
<div class="page-container">
	
	<span class="dropDown"> <a class="dropDown_A" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">选择状态分类</a>
		<ul class="dropDown-menu menu radius box-shadow">
			<li><a href="<?php echo url('bis/index',['status'=>-1]); ?>">删除</a></li>
			<li><a href="<?php echo url('bis/index',['status'=>2]); ?>">未通过</a></li>
			<li><a href="<?php echo url('bis/index',['status'=>1]); ?>">正常</a></li>
		</ul>
	</span>

	<div class="mt-20">
		<table class="table table-border table-bordered table-bg table-hover table-sort">
			<thead>
				<tr class="text-c">
					<th width="80">ID</th>
					<th width="100">商户名称</th>
					<th width="30">法人</th>
					<th width="150">联系电话</th>
					<th width="60">申请时间</th>
					<th width="60">状态</th>
					<th width="100">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php if(is_array($bis) || $bis instanceof \think\Collection || $bis instanceof \think\Paginator): $i = 0; $__LIST__ = $bis;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>
				<tr class="text-c">
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['name']; ?></td>
					<td class="text-c"><?php echo $vo['faren']; ?></td>
					<td class="text-c"><?php echo $vo['faren_tel']; ?></td>
					<td><?php echo $vo['create_time']; ?></td>
					<td class="td-status">
						<?php echo status($vo['status']); ?>
					</td>
					<td class="td-manage">
						<a style="text-decoration:none" class="ml-5" onClick="o2o_edit('商户申请资料详情','<?php echo url('bis/detail',['id'=>$vo['id']]); ?>')" href="javascript:;" title="编辑"><i class="Hui-iconfont">&#xe6df;</i></a>
						<a style="text-decoration:none" class="ml-5" onClick="o2o_del('<?php echo url('bis/delete',['id'=>$vo['id'],'status'=>-1]); ?>')" href="javascript:;" title="删除"><i class="Hui-iconfont">&#xe6e2;</i></a>
						<a style="text-decoration:none" class="ml-5" href="<?php echo url('bis/status',['id'=>$vo['id'],'status'=>2]); ?>" title="不通过"><i class="Hui-iconfont">&#xe6dd;</i></a>
					</td>
				</tr>
			<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
	</div>
</div>
<?php echo $bis->render(); ?>
<!--包含头部文件-->
<script type="text/javascript" src="__STATIC__/admin/hui/lib/jquery/1.9.1/jquery.min.js"></script>
<script type="text/javascript" src="__STATIC__/admin/hui/lib/layer/2.4/layer.js"></script> 
<script type="text/javascript" src="__STATIC__/admin/hui/static/h-ui/js/H-ui.js"></script> 
<script type="text/javascript" src="__STATIC__/admin/hui/static/h-ui.admin/js/H-ui.admin.js"></script>
<script type="text/javascript" src="__STATIC__/admin/hui/lib/My97DatePicker/4.8/WdatePicker.js"></script> 
<script type="text/javascript" src="__STATIC__/admin/hui/lib/jquery.validation/1.14.0/jquery.validate.js"></script> 
<script type="text/javascript" src="__STATIC__/admin/hui/lib/jquery.validation/1.14.0/validate-methods.js"></script>
<script type="text/javascript" src="__STATIC__/admin/hui/lib/jquery.validation/1.14.0/messages_zh.js"></script>  
<script type="text/javascript" src="__STATIC__/admin/js/common.js"></script>
<script type="text/javascript" src="__STATIC__/admin/uploadify/jquery.uploadify.min.js"></script>
<script type="text/javascript" src="__STATIC__/admin/js/image.js"></script>