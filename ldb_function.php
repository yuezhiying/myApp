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

/**
 * Curl https Post 数据
 * 使用方法：
 * $post_string = "app=request&version=beta";
 * request_by_curl('https://www.test.cn/restServer.php',$post_string);
 */
public function postCurlHttpsData($url, $data) { // 模拟提交数据函数
	$curl = curl_init (); // 启动一个CURL会话
	curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
	curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 ); // 对认证证书来源的检查
	curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, 1 ); // 从证书中检查SSL加密算法是否存在
	curl_setopt ( $curl, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] ); // 模拟用户使用的浏览器
	curl_setopt ( $curl, CURLOPT_FOLLOWLOCATION, 1 ); // 使用自动跳转
	curl_setopt ( $curl, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
	curl_setopt ( $curl, CURLOPT_POST, 1 ); // 发送一个常规的Post请求
	curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data ); // Post提交的数据包
	curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 ); // 设置超时限制防止死循环
	curl_setopt ( $curl, CURLOPT_HEADER, 0 ); // 显示返回的Header区域内容
	curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
	$tmpInfo = curl_exec ( $curl ); // 执行操作
	if (curl_errno ( $curl )) {
		print_r(curl_error ( $curl ));
		die(curl_error ( $curl )); //异常错误
	}
	curl_close ( $curl ); // 关闭CURL会话
	return $tmpInfo; // 返回数据
}

	/**
	 * Curl https Post 数据
	 * 使用方法：
	 * $post_string = "app=request&version=beta";
	 * request_by_curl('https://www.test.cn/restServer.php',$post_string);
	 */
	public function postCurlHttpsData($url, $data) { // 模拟提交数据函数
		$curl = curl_init (); // 启动一个CURL会话
		curl_setopt ( $curl, CURLOPT_URL, $url ); // 要访问的地址
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYPEER, 0 ); // 对认证证书来源的检查
		curl_setopt ( $curl, CURLOPT_SSL_VERIFYHOST, 1 ); // 从证书中检查SSL加密算法是否存在
		curl_setopt ( $curl, CURLOPT_USERAGENT, $_SERVER ['HTTP_USER_AGENT'] ); // 模拟用户使用的浏览器
		curl_setopt ( $curl, CURLOPT_FOLLOWLOCATION, 1 ); // 使用自动跳转
		curl_setopt ( $curl, CURLOPT_AUTOREFERER, 1 ); // 自动设置Referer
		curl_setopt ( $curl, CURLOPT_POST, 1 ); // 发送一个常规的Post请求
		curl_setopt ( $curl, CURLOPT_POSTFIELDS, $data ); // Post提交的数据包
		curl_setopt ( $curl, CURLOPT_TIMEOUT, 30 ); // 设置超时限制防止死循环
		curl_setopt ( $curl, CURLOPT_HEADER, 0 ); // 显示返回的Header区域内容
		curl_setopt ( $curl, CURLOPT_RETURNTRANSFER, 1 ); // 获取的信息以文件流的形式返回
		$tmpInfo = curl_exec ( $curl ); // 执行操作
		if (curl_errno ( $curl )) {
			$this->setCurlErrorLog(curl_error ( $curl ));
			die(curl_error ( $curl )); //异常错误
		}
		curl_close ( $curl ); // 关闭CURL会话
		return $tmpInfo; // 返回数据
	}