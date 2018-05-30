<?php

		$width 	    = 500; //显示的进度条长度，单位 px
		
		$htmlstr = '';
		$htmlstr .='
			<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/transitional.dtd">
			<html>
			<head>
			<title>动态显示服务器运行程序的进度条</title>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
			<meta name="Generator" content="JEdit">
			<meta name="Author" content="Krazy Nio">
			<style>
			body, div input { font-family: Tahoma; font-size: 9pt }
			</style>
			
			<script type="text/javascript" src="../js/jquery-1.8.2.js"></script>
			<script language="JavaScript">
			var c = 1;
			var t;
			function settime(){
					document.getElementById("time").innerHTML="总共用时:"+c+" s";
					c+=1;
			}
			t = setInterval(settime,1000);
			function updateProgress(sMsg, iWidth)
			{
				document.getElementById("status").innerHTML = sMsg;
				document.getElementById("progress").style.width = iWidth + "px";
				document.getElementById("percent").innerHTML = parseInt(iWidth / '.$width.' * 100) + "%";
			}

			function downloadLink(strMsg){
				document.getElementById("downloadList").innerHTML = strMsg;
			}
			</script>
			</head>

			<body id="body">
			<table width="600px;" bgcolor="#EAEAEA">
				<tr>
			    	<td align="center">
			        	<table>
			            	<td>
			                    <div style="margin: 4px; padding: 8px; border: 1px solid gray; background: #EAEAEA; width:'.$width.'px">
			                    <div><font color="black"><span id="msg">正在读取资源<img src="../images/onload.gif" width=11 height=11></span> <span id="time">总共用时0 s</span></font></div>
			                    <div style="padding: 0; background-color: white; border: 1px solid navy; width: '.$width.'px">
			                    <div id="progress" style="padding: 0; background-color: #FFCC66; border: 0; width: 0px; text-align: center; height: 16px"></div>
			                    </div>
			                    <div id="status">&nbsp;</div><br/>
			                    <div id="downloadList">
			                    请等待完成才点击下载:<a href="">_下载</a><br>
			</div>
                    <div id="percent" style="position: relative; top: -30px; text-align: center; font-weight: bold; font-size: 8pt">0%</div>
                    </div>
				</td>
            </table>
    	</td>
    </tr>
</table>
		';
		$htmlstr .='
			</body></html><br>
		';
		echo $htmlstr;
		ob_flush();
		flush();
		$re =array();
		for($i=0;$i<100000;$i++){
			$re[] = 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa';
		}
		if(empty($re)){
			echo "<script>
					var mess='<strong style=\'color:#F00\'>数据为空！请关闭窗口！</strong><br>';
					document.getElementById('body').innerHTML=mess;
				</script>";
			exit;
		}else{
			echo "<script>
					var mess='正在处理资源,请稍后<img src=\"../images/onload.gif\" width=11 height=11>';
					document.getElementById('msg').innerHTML=mess;
				</script>";
		}
		$totalNum = count($re);//总数
		
		$pix 	    = $width / $totalNum; //每条记录的操作所占的进度条单位长度
		$progress 	= 0; //当前进度条长度

		foreach($re as $key=>$v){
				echo '<script language="JavaScript">
			 	updateProgress("一共'.$totalNum.'条数据,正在操作第'.($key+1).'条 ....",'.min($width, intval($progress)) .');
			</script>';
			ob_flush();//将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。
			flush(); //将输出发送给客户端浏览器，使其可以立即执行服务器端输出的 JavaScript 程序。
			$progress += $pix;
		}
		$downlink = "<a href='#'>_下载</a>";
		echo '
		<script language="JavaScript">
			document.getElementById("msg").innerHTML="";	
			clearInterval(t);
			updateProgress("'.count($re).'条数据，导出完成！", '.$width.');
			downloadLink("'.$downlink.'");
		</script>
		';
		ob_flush();
		flush();