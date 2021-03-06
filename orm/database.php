<?php

require_once('log/log.php');

class Database
{
	private $host;
	private $user;
	private $pass;
	private $dbname;
	
	private static $instance;
	
	private $connection;
	private $results;
	private $numrows;
	
	private $selectables = array();
	private $table;
	private $whereclause;
	private $limit;
	private $orderby;
	
	
	
	function __construct()
	{
		
	}
	
	static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	

	static public function prepare(){
		return self::$instance;

	}

	static public function execute(){
		return self::$instance;

	}

	static public function fetchAll(){
		return self::$instance;
	}


	function connect($host, $user, $pass,$dbname)
	{
		$this->host = $host = 'localhost';
		$this->user = $user = 'root';
		$this->pass = $pass = '';
		$this->dbname = $dbname;
		
		$this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
		if (mysqli_connect_errno())
		{
			die("Failed to connect to MySQL: " . mysqli_connect_error());
		}
	}
	
	function executeQuery($query)
	{
		$this->results = mysqli_query($this->connection, $query);
		$this->numrows = mysqli_affected_rows($this->connection);
	
	}
	
	function loadSingleObject()
	{
		$obj = "";		
		if($this->numrows)
		{
			$obj = mysqli_fetch_assoc($this->results);
		}
		return $obj;
	}
	
	function loadObjectList()
	{
		$obj = array();
		if($this->numrows)
		{
			while($row = mysqli_fetch_assoc($this->results))
			{
				array_push($obj, $row);
			}
		}
		return $obj;
	}
	
	function affectedRowsCount()
	{
		return $this->numrows;
	}
	
	function select()
	{
		$this->selectables = func_get_args();
		return $this;
	}
	
	function from($table)
	{
		$this->table = $table;
		return $this;
	}
	
	function where($clause)
	{
		$this->whereclause = $clause;
		return $this;
	}
	
	function limit($limit)
	{
		$this->limit = $limit;
		return $this;
	}
	
	function orderby($orderby)
	{
		$this->orderby=$orderby;
		return $this;
	}
	function Join($join){
		$this->join=$join;
		return $this;
	}
	
	function result()
	{
		try{
			$query = "SELECT ".join(",", $this->selectables)." FROM {$this->table}";
		if (!empty($this->whereclause))
			$query .= " WHERE {$this->whereclause} ";
		if (!empty($this->limit))
			$query .= " LIMIT {$this->limit} ";
		if (!empty($this->orderby))
			$query .= " ORDERBY {$this->orderby} ";
		if(!empty($this->join))
			$query .= "JOIN {$this->join}";
		$this->executeQuery($query);
			var_dump($query);
		}catch(Exception $e){
				$err = new ErrorLog;
				die('Il y a eu une erreur.');
		}
	}
}

