<?php
$ch = curl_init(); 
$url = "http://localhost/myApp/changeIP/service.php"; 
$header = array( 
'CLIENT-IP:58.68.44.61', 
'X-FORWARDED-FOR:58.68.44.61', 
'REMOTE_ADDR:8.8.8.8'
); 
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_HTTPHEADER, $header); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true); 
$page_content = curl_exec($ch); 
curl_close($ch); 
echo $page_content.'(4)'; 