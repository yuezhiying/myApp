<?php

$baseDir = 'excel/';
$downloadDir        = __DIR__.'/' ."html/" . $baseDir;
if (!is_dir($downloadDir)) {
	mkdir($downloadDir,0777,true);
}
$title = time()."_".rand(10000,90000);
$titlename  = $downloadDir .$title.".xls";
echo "\n".$titlename."\n";

$XmlHeader = "<?xml version=\"1.0\" encoding=\"%s\"?\>\n<Workbook xmlns=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:x=\"urn:schemas-microsoft-com:office:excel\" xmlns:ss=\"urn:schemas-microsoft-com:office:spreadsheet\" xmlns:html=\"http://www.w3.org/TR/REC-html40\">";
$XmlFooter = "</Workbook>";
$encoding = 'UTF-8';
$title = 'Sheet1';
$tableHeader = array (
	'名字',
	'班级',
	'年龄',
	'地区',
	'性别',
	'状态',
	'备注'
);
$row = array (
	'小米',
	'二年级',
	'12',
	'广东',
	'女',
	'正常',
	'超级美少女'
);
$tempFilename = tempnam(sys_get_temp_dir(), 'exportdata');
$tempFile = fopen($tempFilename, "w");
//开始
fwrite($tempFile, generateHeader());

//写数据
fwrite($tempFile, generateRow($tableHeader));

for($i=0;$i<1000000;$i++){
	//写数据
	fwrite($tempFile, generateRow($row));
}
//结束
fwrite($tempFile, generateFooter());

fclose($tempFile);

rename($tempFilename, $titlename);

echo "\nend\n";exit;


function generateHeader() {
	global $XmlHeader,$encoding,$title;
	// workbook header
	$output = stripslashes(sprintf($XmlHeader, $encoding)) . "\n";

	// Set up styles
	$output .= "<Styles>\n";
	$output .= "<Style ss:ID=\"sDT\"><NumberFormat ss:Format=\"Short Date\"/></Style>\n";
	$output .= "</Styles>\n";

	// worksheet header
	$output .= sprintf("<Worksheet ss:Name=\"%s\">\n    <Table>\n", htmlentities($title));

	return $output;
}
function generateRow($row) {
	$output = '';
	$output .= "        <Row>\n";
	foreach ($row as $k => $v) {
		$output .= generateCell($v);
	}
	$output .= "        </Row>\n";
	return $output;
}
function generateCell($item) {
	$output = '';
	$style = '';

	// Tell Excel to treat as a number. Note that Excel only stores roughly 15 digits, so keep
	// as text if number is longer than that.
	if(preg_match("/^-?\d+(?:[.,]\d+)?$/",$item) && (strlen($item) < 15)) {
		$type = 'Number';
		/*if($item!=0 && strpos($item, '0') === 0){//add by zqt //add by zqt,以0开头并且!=0的数据当做为String
			 $type = 'String';
		 }*/
	}
	// Sniff for valid dates; should look something like 2010-07-14 or 7/14/2010 etc. Can
	// also have an optional time after the date.
	//
	// Note we want to be very strict in what we consider a date. There is the possibility
	// of really screwing up the data if we try to reformat a string that was not actually
	// intended to represent a date.
	elseif(preg_match("/^(\d{1,2}|\d{4})[\/\-]\d{1,2}[\/\-](\d{1,2}|\d{4})([^\d].+)?$/",$item) &&
		($timestamp = strtotime($item)) &&
		($timestamp > 0) &&
		($timestamp < strtotime('+500 years'))) {
		$type = 'DateTime';
		$item = strftime("%Y-%m-%dT%H:%M:%S",$timestamp);
		$style = 'sDT'; // defined in header; tells excel to format date for display
	}
	else {
		$type = 'String';
	}

	$item = str_replace('&#039;', '&apos;', htmlspecialchars($item, ENT_QUOTES));
	$output .= "            ";
	$output .= $style ? "<Cell ss:StyleID=\"$style\">" : "<Cell>";
	$output .= sprintf("<Data ss:Type=\"%s\">%s</Data>", $type, $item);
	$output .= "</Cell>\n";

	return $output;
}
function generateFooter() {
	$output = '';
	global $XmlFooter;
	// worksheet footer
	$output .= "    </Table>\n</Worksheet>\n";

	// workbook footer
	$output .= $XmlFooter;

	return $output;
}