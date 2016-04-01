<?php

$array=file_get_contents('./wwww.txt');
$array = explode("\r\n", $array);
$name="test.csv";
$handle =fopen($name,'rb');
$fc=fread($handle,filesize($name));
$exc = new ExcelFileParser();
$res = $exc->ParseFromString($fc);
$ws_number = count($exc->worksheet['name']);//取得工作薄数量
echo $ws_number;
//echo "<pre>";var_dump($array);
// foreach($array as $key=>$v){
// 	$v = iconv('utf-8','gb2312',$v);
// 		fputcsv($handle, explode('  ',$v));
// 		echo $key."<br>";
// }
//fclose($handle);