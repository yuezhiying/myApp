<?php
set_time_limit(600);
require_once('./class/c/doSql.class.php');

//读取取SKU
$array=file_get_contents('./SKU.txt');
$array = explode("\r\n", $array);
$sku = ''; 
 echo 'update SKU unactive:'.'<br/>';
foreach($array as $key=>$vo){
	if($vo != ''){
		$sku .= "'".$vo."',";		
 		echo '&nbsp;&nbsp;&nbsp;'.$vo.'<br/>';
	}
};
$sku = trim($sku,',');

//执行设置订单为不活动状态（productsIsActive=0）,为1则是活动状态
$doSql = new doSql;
$sql = "update erp_products_data set productsIsActive=0 where products_sku in(".$sku.")";
 $result = $doSql->query($sql);
if($result){
	echo "It's successful";
}else{
	echo "It's fail";
};