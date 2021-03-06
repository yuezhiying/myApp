<?php
define('ROOT_PATH','./');
require(ROOT_PATH . 'phpexcel/PHPExcel.php');//引入PHP EXCEL类,地址http://phpexcel.codeplex.com/
function format_excel2array($filePath='',$sheet=0){
        if(empty($filePath) or !file_exists($filePath)){die('file not exists');}
        $PHPReader = new PHPExcel_Reader_Excel2007();        //建立reader对象
        if(!$PHPReader->canRead($filePath)){
                $PHPReader = new PHPExcel_Reader_Excel5();
                if(!$PHPReader->canRead($filePath)){
                        echo 'no Excel';
                        return ;
                }
        }
        $PHPExcel = $PHPReader->load($filePath);        //建立excel对象
        $currentSheet = $PHPExcel->getSheet($sheet);        //**读取excel文件中的指定工作表*/
        $allColumn = $currentSheet->getHighestColumn();        //**取得最大的列号*/
        $allRow = $currentSheet->getHighestRow();        //**取得一共有多少行*/
         ++$allColumn;
        $data = array();
        for($rowIndex=1;$rowIndex<=$allRow;$rowIndex++){        //循环读取每个单元格的内容。注意行从1开始，列从A开始
                for($colIndex='A';$colIndex!=$allColumn;$colIndex++){
                        $addr = $colIndex.$rowIndex;
                        //不兼容时间写法
                        //$cell = $currentSheet->getCell($addr)->getValue();

                        //兼容时间写法
                        if($colIndex=='M'||$colIndex=='N') //M列和O列是时间
                        {
                            $cell = gmdate("Y-m-d H:i:s", PHPExcel_Shared_Date::ExcelToPHP($PHPExcel->getActiveSheet()->getCell("$colIndex$rowIndex")->getValue()));   
                        }else{  
                            $cell = $PHPExcel->getActiveSheet()->getCell("$colIndex$rowIndex")->getValue(); 
                        }
                                
                        if($cell instanceof PHPExcel_RichText){ //富文本转换字符串
                                $cell = $cell->__toString();
                        }
                        $data[$rowIndex][$colIndex] = $cell;
                }
        }
        return $data;
}
$filePath = ROOT_PATH.'md.xlsx';        //钻石库存文件
$data = format_excel2array($filePath);

echo "<pre/>";var_dump($data);exit;



 foreach($data as $key=>$v){
	if($key <3){
		continue;
	}

}
echo "<pre/>";var_dump($data);




exit;


