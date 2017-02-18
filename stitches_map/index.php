<?php
	$conn=mysql_connect("localhost","root","") or die ("连接失败");
	mysql_query("set names utf8",$conn);
	mysql_select_db("sss",$conn);
	$strsql="SELECT *,SUM(jfls) FROM `ssaaa` where TIMESTAMPDIFF(DAY,rq,DATE(NOW())) < 7 GROUP BY rq,user";
	$strsql2="select * from `user`";
	$result=mysql_query($strsql,$conn);
	$result2=mysql_query($strsql2,$conn);
	$dates2="";
	for($i=-6;$i<1;$i++){
		$dates[]=date("Y/m/d",strtotime("+$i day"));
		$dates2.="'".date("Y-m-d",strtotime("+$i day"))."',";
	}
	while($row=mysql_fetch_array($result)){
		$jfls[$row['user']][$row['rq']]=$row['SUM(jfls)'];
	}
	while($user=mysql_fetch_array($result2)){
		$jfls_user=array();
		foreach($dates as $date){
			$jfls_user[]=isset($jfls[$user['user']][$date])?$jfls[$user['user']][$date]:0;
		}
		
		$datas[]=array(
			'name'=>$user['user'],
			'data'=>implode(",",$jfls_user)
		);
	}
	
?>
<html>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<script src="public/jquery-1.8.2.min.js" type="text/javascript"></script>
    <script src="public/highcharts.js"></script>
	<script type="text/javascript">
		$(document).ready(function() {
			var options={
								  chart: {
									 renderTo: 'container'
								  },
								  xAxis:{
									categories: [<?php echo rtrim($dates2,",");?>]
								  },
								  yAxis:{
									
								  },
								  legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
								  series: []
							};
			
			
			var items=<?php echo json_encode($datas)?>;
            $.each(items, function(itemNo, item) {
					var series = {
						data: []
					};
					series.name=item.name;
					var dats=item.data.split(",");
					for(var i=0;i<dats.length;i++)
						series.data.push(parseInt(dats[i]));
					options.series.push(series);
            });
            
            
			var chart = new Highcharts.Chart(options);
			});
	</script>
    <body>
		<div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
    </body>
</html>