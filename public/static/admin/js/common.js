/*页面 全屏-添加*/
function o2o_edit(title,url){
	var index = layer.open({
		type: 2,
		title: title,
		content: url
	});
	layer.full(index);
}

/*添加或者编辑缩小的屏幕*/
function o2o_s_edit(title,url,w,h){
	layer_show(title,url,w,h);
}
/*-删除*/
function o2o_del(url){
	
	layer.confirm('确认要删除吗？',function(index){
		window.location.href=url;
	});
}


$('.listorder input').blur(function(){
	//编写index页面中抛送的逻辑
	//获取主键id
	var id = $(this).attr('attr-id');//attr();->设置或返回被选元素的属性值
	// alert(id);
	//获取排序值
	var listorder = $(this).val();//var();->设置会返回被选元素的值，若该方法未设置参数，则返回被选元素的当前值
	// alert(listorder);

	//将上面获取到的两个数据组装成一个数组
	var postData = {
        'id': id,
        'listorder': listorder,
	};
	//获取在前台页面中抛送的url地址，因为排序是一个共用的方法，这样写可以提高代码的复用性
	var url = SCOPE.listorder_url;
	//将编写好的数组抛送给上面的url地址(这就是我们异步请求)
	$.post(url,postData,function(result){
		//实现逻辑
		//如果coed=1,表示更新成功
		if(result.code == 1){
			location.href=result.data;
		}else{
			alert(result.msg);
		}
	},"json");
});

/**
 * 城市相关内容分类
 */
$(".cityId").change(function(){
	city_id = $(this).val();
	//将city_id的值抛送给接口，然后进入到数据库中查到对应的值
	//抛送请求
	url = SCOPE.city_url;
	//这里的url指定的是将数据传递到哪个接口中去
	//alert(url);return;
	postData = {'id':city_id};
	$.post(url,postData,function(result){
		//获取这些数据之后会回调给result，根据result的值来处理相关业务
		if(result.status == 1){
			//如果成功，将获取到的对应的信息填充到html中
			data = result.data;
			city_html = "";
			$(data).each(function(i){
				city_html += "<option value='"+this.id+"'>"+this.name+"</option>";
			});
			document.getElementById("city_id_se").style="";
			$('.se_city_id').html(city_html);
		}else if(result.status == 0){
			document.getElementById("city_id_se").style="display: none;";
			$('.se_city_id').html('');
		}else if(result.code == 0){
			document.getElementById("city_id_se").style="display: none;";
		}
	},'json');
});

/**
 * 分类相关内容分类
 */
$(".categoryId").change(function(){
	category_id = $(this).val();
	//将city_id的值抛送给接口，然后进入到数据库中查到对应的值
	//抛送请求
	url = SCOPE.category_url;
	//这里的url指定的是将数据传递到哪个接口中去
	//alert(url);return;
	postData = {'id':category_id};
	$.post(url,postData,function(result){
		//获取这些数据之后会回调给result，根据result的值来处理相关业务
		if(result.status == 1){
			data = result.data;
			category_html = "";
			$(data).each(function(i){
				category_html += '<input name="se_category_id[]" type="checkbox" id="checkbox-moban" value="'+this.id+'" />'+this.name;
				category_html += '<label for="checkbox-moban">&nbsp;</label>';
			});
			$('.se_category_id').html(category_html);
		}else if(result.status == 0){
			$('.se_category_id').html('');
		}
	},'json');
});

















