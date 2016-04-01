<?php
//根据IP地址，获取IP地区
function getIPLoc($queryIP){
$url = 'http://ip.qq.com/cgi-bin/searchip?searchip1='.$queryIP;
$ch = curl_init($url);
curl_setopt($ch,CURLOPT_ENCODING ,'utf-8');
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
$result = curl_exec($ch);
curl_close($ch);
preg_match("@<span>(.*)</span></p>@iU",$result,$ipArray);
$loc = $ipArray[1];
return $loc;
}
function is_mobile()
{
    //php判断客户端是否为手机
    $agent = $_SERVER['HTTP_USER_AGENT'];
    return (strpos($agent,"NetFront") || strpos($agent,"iPhone") || strpos($agent,"MIDP-2.0") || strpos($agent,"Opera Mini") || strpos($agent,"UCWEB") || strpos($agent,"Android") || strpos($agent,"Windows CE") || strpos($agent,"SymbianOS"));
}

function isIP(strIP) {
	var re=/^(\d+)\.(\d+)\.(\d+)\.(\d+)$/g //匹配IP地址的正则表达式
	if(re.test(strIP)){
	        if( RegExp.$1 <256 && RegExp.$2<256 && RegExp.$3<256 && RegExp.$4<256) return true;
	   }return false;
}
