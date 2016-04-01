<?php

////////////////////////////////////实现双击修改start////////////////////////////////
/*
<tr>
	<td class="center">
	  <input type="checkbox" name="ids[]" value="<?php echo $da->id?>" <?php echo ($da->is_upload==2) ? 'disabled' : ''?>/>
	</td>
	<td class="center">
		<a href="<?php echo $da->original_main_image ?>" target="_blank">
		  <img src="<?php echo $da->original_main_image ?>" style="width:80px;height:80px;" />
		</a>
	</td>
	<td class="center"><?php echo $userInfo[$da->account]?></td>
	<td class="center"><?php echo $da->productID?></td>
	<td class="center" atype="parent_sku">
	    <a class="skuInfo" data-id="<?php echo $da->id?>" style="cursor:pointer;">
	       <?php echo $da->parent_sku?>
		</a><input type="text" class="datahide" value="<?php echo $da->parent_sku?>"/>
	</td>
	<td class="center" atype="product_name"><?php echo $da->product_name?><input type="text" class="datahide" value="<?php echo $da->product_name?>"/></td>
	<td class="center" atype="Tags"><span><?php echo $da->Tags?></span><input type="text" class="datahide" value="<?php echo $da->Tags?>"/></td>
	<td class="center" atype="price"><?php echo $da->price?><input type="text" class="datahide" value="<?php echo $da->price?>"/></td>
	<td class="center" atype="shipping"><?php echo $da->shipping?><input type="text" class="datahide" value="<?php echo $da->shipping?>"/></td>
	<td class="center"><?php echo $products_auditing[$da->auditing_status]?></td>
	<td class="center"><?php echo $products_upload[$da->is_upload]?></td>
</tr>
*/
$(".dataTable tr td").dblclick(function(){
//      var inval = $(this).html();                            //获得td里的html内容
//      var infd = $(this).attr("fd");                        //获得td的fd属性的值
//      var inid = $(this).parent().attr("id");                //获得td的父节点id属性的值
//     
//  //把td里的html内容变为input框，并赋值
//      $(this).html("<input type='text' id='edit"+infd+inid+"' value='"+inval+"'>");
//     
//  //input框获得焦点，以及失去焦点后的处理   
//      $("#edit"+infd+inid).focus().live("blur",function() {
//          var editval = $(this).val();                //获得input框中的值
//
//          $(this).parent().html(editval);                //把得到的值赋给input框父节点的html
//         
//      //post表单提交
////          $.post("jquery_dblclick.php",{id:inid,fd:infd,val:editval},function(data) {
////              alert(data);
////          })
//      })
	var url ="<?php echo admin_base_url('publish/wish/ajaxmodifyorder');?>";
	var type = $(this).attr('atype');
	if(type != 'parent_sku' && type != 'product_name' && type != 'Tags' && type != 'price' && type != 'shipping'){
		return false;
	}
	var oBid = $(this).parents('tr').find('td').find('input[type=checkbox]');
	var orderid = $(oBid).val();
	var oBinput = $('input',this);
	var oBthis = $(this);
	var width = $(this).width();
	var height = $(this).height();
	var ipval = $(oBinput).val();
	if(typeof(ipval) == 'undefined'){return false;}
	var html = "<textarea>"+ipval+"</textarea>";
	$(this).html(html);
	$('textarea',this).width(width);
	$('textarea',this).height(height);
	$('textarea').focus();
	//textarea失去焦点事件
	$('textarea').blur(function(){
		var txtval = $(this).val();
		var newval = ipval;
		if(txtval !== ipval){
			if(confirm("此数据值已经改变,确定修改吗?")){
				var newval = txtval;
				var data ='id='+orderid+'&'+type+'='+newval;
				//修改数据
				$.ajax({
					url:url,
					data:data,
					type:'post',
					dataType:'text',
					success:function(msg){
						var mes = eval("(" + msg + ")");
						if(mes['status'] =='1' ){
							//修改成功
							alert('修改成功');
						};
						if(mes['status'] =='2'){
							//修改2失败
						
							alert('修改失败');
						}
					}
				});
				
			}
		}
		var newhtml = '';
		if(type == 'parent_sku'){
			newhtml = "<a class='skuInfo' data-id="+orderid+" style='cursor:pointer;'>"+newval+"</a>"+"<input type='text' class='datahide' value='"+newval+"'/>";
		}else{
			newhtml = "<span>"+newval+"</span>"+"<input type='text' class='datahide' value='"+newval+"'/>";
		}
		
		$(oBthis).html(newhtml);
		//给SKU绑定事件
		if(type == 'parent_sku'){
			$(".skuInfo").click(function(){
			  var id=$(this).attr("data-id");
			  $.layer({
					type   : 2,
					shade  : [0.4 , '' , true],
					title  : ['记录详情',true],
					iframe : {src : '<?php echo admin_base_url("publish/wish/getInfoByID?id=");?>'+id},
					area   : ['800px' , '600px'],
					success : function(){
						layer.shift('top', 400)
					}
				});
				return false;
			});
		}
	});
})

    ////////////////////////////////////双击修改END////////////////////////////////
    ////////////////////////////////////双击修改END////////////////////////////////
