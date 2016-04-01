<?php
$dir = 'img';
function my_scandir($dir){
    $files = array();
    $dir_list = scandir($dir);
    foreach($dir_list as $file){
       if($file != ".." && $file != "."){
          if(is_dir($dir.$file)){
           $files[$file] = my_scandir($dir.$file."/");
              }else{
               $files[] = iconv('GB2312','UTF-8',$file);
          }
       }
    }
return $files;
}
$result = my_scandir($dir);
$imgcount = count($result);//图片个数
$page = empty($_GET['page'])?1:(int)$_GET['page'];//第几页
$perCount = 64;//每页展示图片个数
$pageCount = ceil($imgcount/$perCount);//总页数
$page = $page<1?1:($page>$pageCount?$pageCount:$page);
$start = ($page-1) * $perCount;//第几个图片开始
$url = __FILE__;
//0-44,45-89,90-134
$style= "<style>
		*{padding:0;margin:0;}
		body{width:1550px;margin:auto}
		img{width:150px;height:150px;}
		.imgdiv{width:150px;heigth:150px;float:left;margin:20px;text-align:center;}
		.pdiv{clear:both;width:500px;height:50px;margin:auto;line-height:50px;}
		.pdiv ul{clear:both;}
		.pdiv ul li{list-style:none;float:left;margin-left:5px;height:50px;width:50px;text-align:center;}
		a:link,a:visited,a:active{color:black;text-decoration:underline;}
		a:hover{color:blue;text-decoration:underline;}
		.tz{width:50px}
		.tzdiv{clear:both;}
		h1{text-align:center;}
		.imgtitle{width:130px;height:18px;overflow:hidden;font-size:17px;}
	 </style>";
$str = '';//图片

for($i = 0;$i < $perCount;$i++){
	$img = $start + $i;
	if($img > ($imgcount-1)){
		break;
	}
	$str .= "<div class='imgdiv'>";
	$str.="<a href='".$dir.'/'.$result[$img]."?page=1' target='_blank'><img src='".$dir.'/'.$result[$img]."'/></a>";
	$str .= "<div class='imgtitle'>".$result[$img]."</div>";
	$str .= "</div>";
}

$pageStr = '';
$pageStr .= "<div class='pdiv'><ul>";
$pageStr .= "&nbsp;总共".$pageCount."页,当前第".$page."页";
$pageStr .= "<a href='?page=".($page-1)."' ><li>上一页</li></a>";
$pageStr .= "<a href='?page=".($page+1)."' ><li>下一页</li></a>";
$pageStr .= "";
$pageStr .= "<li style='width:150px'><div class='tzdiv'>跳转到 <input type='text' class='tz'/>  页</div></li>";
$pageStr .="</ul></div>";

$script ='';
$script .='<script>';
$script .="$('.tz').blur(function(){
			var inp = $(this).val();
			inp = parseInt(inp);
			var ex = /^\d+$/;
			if (ex.test(inp)) {
			   window.location.href = '?page='+inp;
			}else{
				alert('请输入正整数');
				return false;
			}
		})";
$script .='</script>';

$printInfo='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
				<html xmlns="http://www.w3.org/1999/xhtml">
				<head>
				<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
				<script src="jquery-1.8.0.min.js""></script>
				<title></title>
				</head><body><h1>图片浏览</h1>';
$printInfo.= $style.$str.$pageStr.$script;
$printInfo.='</body></html>';
echo $printInfo;