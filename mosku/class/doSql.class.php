<?php
ini_set('memory_limit', '1024M');
require_once ('connect.class.php');
class doSql {
	private $db_hand;
	public $affected_rows;
	public $hwcDbName = 'salamoer_database';
	function doSql(){
		//$this->db_hand = connect::get()->getConn();
		$db_hand = new connect;
		$this->db_hand = $db_hand->getConn();
		$this -> affected_rows = 0;
	}
	/**插入，删除，更新操作，如果是插入就会返回插入的ID*/
	function query($str_sql){
        
		$result = mysql_query($str_sql, $this->db_hand);
        if ( !$result ) {
            $msg = 'Invalid query: ' . mysql_error() . "---- Your sql:" . $str_sql;
            debug($msg);
            return false;
        }
		$this -> affected_rows = mysql_affected_rows();
        $insert_id = mysql_insert_id($this->db_hand);
		return $insert_id > 0 ? $insert_id : $result;
	}
	function query_($str_sql){
		$result = mysql_query($str_sql, $this->db_hand);
        if ( !$result ) {
            $msg = 'Invalid query: ' . mysql_error() . "---- Your sql:" . $str_sql;
            debug($msg);
            return false;
        }        
		return $result;
	}  
	//update/del 影响行数
	function get_affected_rows($str_sql)
	{
		mysql_query($str_sql, $this->db_hand);
		$rows=mysql_affected_rows($this->db_hand);
		return $rows;
	}
	//select 
	function get_num_rows($str_sql)
	{
		$result=mysql_query($str_sql, $this->db_hand);
		return mysql_num_rows($result);
	} 
	/**
	 * 针对查询的方法，返回的是二维数组，在里面层是以表头做下标*/
	function doSelect($str_sql){
		$result = array();
		$fetch_array = $this->query_($str_sql);
		//make a test?
        if ( $fetch_array ) {
            $i = 0;
            while($row = mysql_fetch_array($fetch_array, MYSQL_ASSOC)){
                $result[$i] = $row;
                $i++;
            }
        }
		return $result;
	}
    
	  function getOne($sql) {
		$res = $this->query_( $sql );
		if ( $res !== false && is_resource($res) ) {
			return mysql_fetch_array($res, MYSQL_ASSOC);
		} else {
			return array();
		}
	  }    
	/**
	 * 统计消息数目*/
	public function numRow($str_sql) {
		$result = $this->query_($str_sql);
		if ( is_resource($result) ) $numrows = mysql_num_rows($result);
        else $numrows = 0;
		return $numrows;
	}
	
		
	/**
	 * 插入数据
	 *
	 * @param string $table			表名<br />
	 * @param array $field_values	数据数组<br />
	 * @return id					最后插入ID
	 */
	  function insert($table, $field_values) {
		$field_names = $this->getCol ( 'DESC ' . $table );
		$fields = array ();
		$values = array ();
		foreach ( $field_names as $value ) {
			if (array_key_exists ( $value, $field_values ) == true) {
				$fields [] = $value;
				$values [] = "'" . $field_values [$value] . "'";
			}
		}
		if (! empty ( $fields )) {
			$sql = 'INSERT INTO ' . $table . ' (' . implode ( ', ', $fields ) . ') VALUES (' . implode ( ', ', $values ) . ')';		
		}
		//die($sql);
		if ($sql) {
			return $this->query ( $sql );
		} else {
			return false;
		}
	}
	
	//建立插入数据的 sql语句
    function insertSql($table=null,$data=array()) {
        if(!$table || !$data) return false;
        $sql = 'INSERT INTO '.$table.' ';
        $keys = '';
        $values = '';
        foreach($data as $k=>$v) {
            $keys .= $k.',';
            
            $v_str = null;
            if ( is_null($v) ){
                $v_str = "''";
            }else{
                $v_str = "'" . mysql_real_escape_string($v) . "'";
            }

            $values .= $v_str.',';
        }
        $keys = '('.trim($keys,',').') VALUES (';
        $values = trim($values,',').')';
        //die($sql.$keys.$values);

        $rs = $this->query($sql.$keys.$values);
        
        if(!$rs){
            return false;
        }	
        return $rs;
    }

	/**
	 *update 数据库
	 *@param $condition 可为数组，也可为$pkname对应的更新条件的值
	 * $updaterow 为更新的字段
	 */
	function updateSQL($table = null, $updaterow = array(), $condition) {
		
		if (null == $table || empty ( $updaterow ))
			return false;
			
		$sql = "UPDATE $table SET ";
		$content = null;
		
		foreach ( $updaterow as $k => $v ) {
			$v_str = null;
			if (is_null ( $v ))
				$v_str = "''";
			else if (is_array ( $v ))
				$v_str = $v [0]; //for plus/sub/multi; 
			else
				$v_str = "'" . $v . "'";
			$content .= "$k=$v_str,";
		}
		
		$content = trim ( $content, ',' );
		$sql .= $content;
		$sql .= " WHERE $condition";
	    //echo ($sql.'<br/>');
		$rs = $this->query ( $sql );
		
		if (false == $rs) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * 更新数据
	 *
	 * @param string $table			要更新的表<br />
	 * @param array $field_values	要更新的数据，使用而为数据例:array('列表1'=>'数值1','列表2'=>'数值2')
	 * @return bool	
	 */
	  function update($table, $field_values, $where = '') {
		$field_names = $this->getCol ( 'DESC ' . $table );
		$sets = array ();
		foreach ( $field_names as $value ) {
			if (array_key_exists ( $value, $field_values ) == true) {
				$sets [] = $value . " = '" . $field_values [$value] . "'";
			}
		}
		if (! empty ( $sets )) {
			$sql = 'UPDATE ' . $table . ' SET ' . implode ( ', ', $sets ) . ' WHERE ' . $where;
		}
		//die($sql);
		if ($sql) {
			return $this->query ( $sql );
		} else {
			return false;
		}
	}
	
	/**
	 * 删除数据
	 *
	 * @param string $table	要删除的表<br />
	 * @param string $where	删除条件，默认删除整个表
	 * @return bool
	 */
	function delete($table, $where = '') {
		if (empty ( $where )) {
			$sql = 'DELETE FROM ' . $table;
		} else {
			$sql = 'DELETE FROM ' . $table . ' WHERE ' . $where;
		}
		if ($this->query ( $sql )) {			
			return true;
		} else {
			return false;
		}
	}
	

	
	/**
	 * 获取列
	 *
	 * @param string $sql
	 * @return array
	 */
	  function getCol($sql) {
		$res = $this->query ( $sql );
		if ( $res !== false && is_resource($res) ) {
			$arr = array ();
			while ( $row = mysql_fetch_row ( $res ) ) {
				$arr [] = $row [0];
			}
			return $arr;
		} else {
			return false;
		}
	  }
}


function debug($msg)
{
    static $start_time = NULL;
    static $start_code_line = 0;

    $calls =  debug_backtrace() ;
    $contents = array();
    $contents[] = $msg . "\n";
    foreach ( $calls as $call_info ) {
    
        $content = "\n";
        $code_line = $call_info['line'];
        $info_line = explode('/', $call_info['file']);
        $file = array_pop( $info_line );
        if( $start_time === NULL )
        {
            $content .=  "debug ".$file."> initialize\n";
            $start_time = time() + microtime();
            $start_code_line = $code_line;
            continue;
        }

        $content .= sprintf("debug %s> code-lines: %d-%d time: %.4f mem: %d KB\n", $file, $start_code_line, $code_line, (time() + microtime() - $start_time), ceil( memory_get_usage()/1024));
        $start_time = time() + microtime();
        $start_code_line = $code_line;
        $contents[] = $content;
        
    }
    //wirte debug log to file
    //$handle = fopen($_SERVER['DOCUMENT_ROOT'] ."/db_log/".date('Y-m-d-H-i-s').".log", "ab");
    $handle = fopen("/data/db_log/" . date('Y-m-d-H-i-s') . ".log", "ab");
    fwrite($handle, implode("\n", $contents));
    fclose($handle);

}
?>