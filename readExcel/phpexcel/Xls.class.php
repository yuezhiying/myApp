<?php
/* 
 * Excel -> Array
 * add njz 2014.03.24
*/
require_once 'PHPExcel.php';
class Xls 
{
	public $PHPExcel;
	public $PHPReader;
	
	public function __construct()
	{
		
		/**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
		$this->PHPReader = new PHPExcel_Reader_Excel2007();
	}
	/* 
	 *  excel文件路径 、第几个工作表、第几行开始取、取多少行
	 */
	public function getNewArray($filePath,$page,$start=1)
   {

		if(!$this->PHPReader->canRead($filePath)){
			$this->PHPReader = new PHPExcel_Reader_Excel5();
			if(!$this->PHPReader->canRead($filePath)){
				echo 'no Excel';
			return ;
			}
		}
		$PHPExcel = $this->PHPReader->load($filePath);
		/**读取excel文件中的第一个工作表*/
		$currentSheet = $PHPExcel->getSheet($page);
		/**取得最大的列号*/
		$allColumn = $currentSheet->getHighestColumn();
		/**取得一共有多少行*/
		$allRow = $currentSheet->getHighestRow();
		/**从第二行开始输出，因为excel表中第一行为列名*/

		$str='';
		for($currentRow = $start;$currentRow <= $allRow;$currentRow++){
		/**从第A列开始输出*/
			for($currentColumn= 'A';$currentColumn<= $allColumn; $currentColumn++){
				$val = $currentSheet->getCellByColumnAndRow(ord($currentColumn) - 65,$currentRow)->getValue();
				//$str.=iconv('UTF-8','gb2312', $val)."*";
				$str.=$val."*";
			}
			$str.="|";
		}

	     $newarr=explode('|',$str);
		 foreach($newarr as $vale)
		{
			$xx[]=array_filter(explode('*',$vale));
		}
		
		return array_filter($xx);
	}
	
	/* 
	 * 添加key值
	 * 得到的数组、key值
	 */
	function addKey($arrObj,$arrkey)
	{
		if( empty($arrObj) && empty($arrkey) )
		{
			echo '数据为空';
			return false;
		}
		$i=1;
		foreach ( (array)$arrObj as $value )
		{
			$j=0;
			foreach($arrkey as $val)
			{
				$new[$val]=$value[$j];
				$j++;
			}
			$n[$i]=$new;
			$i++;
		}
		return $n;
	}
	
	/* 
	 * 生成以array形式的文本
	 * array、保存文件名
	 */
	function getPhpArrayTxt($array,$file='NewArray.php')
	{
		$str='<?php return ';
		$str.=var_export($array,true);
		$str.=';';
		file_put_contents($file,$str);
	}
		
	
}


?>
