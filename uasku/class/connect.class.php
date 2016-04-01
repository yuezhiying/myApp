<?php
global $mysql_server_name;
global $database;
global $mysql_username;
global $mysql_password;
class connect {
	//private static $db_hand;
	private $db_hand;
    function connect() {
		$mysql_server_name = "localhost";
		$mysql_username = "root";
		$mysql_password = "root";
		$this->db_hand = mysql_connect($mysql_server_name, $mysql_username, $mysql_password) or die("连接数据库失败");
		mysql_select_db('new_erp_database_newest', $this->db_hand);
		mysql_query('set character_set_client = utf8', $this->db_hand);
		mysql_query('set character_set_connection = utf8', $this->db_hand);
		mysql_query('set character_set_results = utf8', $this->db_hand);        
		return $this->db_hand;    
    }
     /*
	private function __construct() {
		$mysql_server_name = "localhost";
		$mysql_username = "wenjunbing";
		$mysql_password = "kjdKD5C8E@^&545S";
		$this->db_hand = mysql_connect($mysql_server_name, $mysql_username, $mysql_password) or die("连接数据库失败");
		mysql_select_db('erp_database_newest', $this->db_hand);
		mysql_query('set character_set_client = utf8', $this->db_hand);
		mysql_query('set character_set_connection = utf8', $this->db_hand);
		mysql_query('set character_set_results = utf8', $this->db_hand);        
		return $this->db_hand;
	}
    private function __clone() {
	}
   
	static function get() {
	 	self :: $db_hand = new connect();
		if (FALSE == (self :: $db_hand instanceof self)) {
			self :: $db_hand = new connect();
		}
		return self :: $db_hand;

	}

    */
	function getConn(){
		return $this->db_hand;
	}    
}

?>