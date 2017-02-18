<?php

$url = array(
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.2.KP12ni&id=531890861498',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.4.KP12ni&id=531868784341',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.6.KP12ni&id=531868108974',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.8.KP12ni&id=531785852159',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.10.KP12ni&id=531758897603',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.12.KP12ni&id=531738542252',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.14.KP12ni&id=531734266151',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.16.KP12ni&id=531688487045',
		'https://item.taobao.com/item.htm?spm=a1z10.1-c.w4004-14226472182.18.KP12ni&id=531679447790',
		'https://hontozer.taobao.com/'
	);
$ww = '';
for($i=0;$i<10;$i++){
	$vurl =$url[rand(0,9)];

	$vip = rand(11,250).'.'.rand(11,250).'.'.rand(11,250).'.'.rand(11,250);
	$ww.=$vip."\r\n";
	//$vurl = "http://localhost/myApp/changeIP/service2.php";
	$res=visite($vurl,$vip);
	echo $i.':';
	var_dump($res);echo $vip;echo "<br/>";
	//sleep(1);
}

function visite($url,$ip){
	$ch = curl_init(); 
	curl_setopt($ch, CURLOPT_URL,$url ); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:'.$ip, 'CLIENT-IP:'.$ip,'REMOTE_ADDR'.$ip)); //构造IP 
	curl_setopt($ch, CURLOPT_REFERER, "http://www.jb51.net/"); //构造来路 
	curl_setopt($ch, CURLOPT_HEADER, 1); 
	$errno = curl_errno( $ch );
	$out = curl_exec($ch); 
	curl_close($ch); 
	return $errno;
}

