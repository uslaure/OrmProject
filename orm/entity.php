<?php

class Entity
{
	protected $pkeys = null;
	protected $tablename = null;
	protected $aikeys = null;
	
	
	function __construct()
	{
		
	}
	
	function bind($data)
	{
		foreach ($data as $key=>$value)
		{
			$this->$key = $value;
		}
	}
	
	
	function load()
	{			
		$dbo = Database::getInstance();
		$query = $this->prepareQuery('select');
		$dbo->executeQuery($query);
		$row = $dbo->loadSingleObject();
		if($row!="")
		{
			foreach ($row as $key=>$value)
			{
				$this->$key = $value;
			}
		}
	}
	function loadMultiple()
	{
		$objs = array();
		$dbo = Database::getInstance();
		$query = $this->prepareQuery('select');
		$dbo->executeQuery($query);
		$rows = $dbo->loadObjectList();
	
		if (!empty($rows))
		{
			$cn = get_class($this);
			foreach ($rows as $row)
			{
				$nobj = new $cn;
				foreach ($row as $key=>$value)
				{				
					$nobj->$key = $value;
					
				}
				array_push($objs, $nobj);
				
			}
			
		}
		return $objs;
		
	}
	
	function add()
	{
		$dbo = Database::getInstance();
		$query = $this->prepareQuery('insert');		
		$dbo->executeQuery($query);
	}
	
	function update()
	{
		$dbo = Database::getInstance();
		$query = $this->prepareQuery('update');		
		$dbo->executeQuery($query);
	}
	
	function remove()
	{
		$dbo = Database::getInstance();
		$query = $this->prepareQuery('delete'); 
		$dbo->executeQuery($query);
		
	}
	
	protected function prepareQuery($operation)
	{
		$query = "";
		if($operation == 'insert')
		{
			$cvars = get_class_vars(get_class($this));
			$fieldnames = "";
			$fieldvalues = "";
			foreach ($cvars as $key=>$value)
			{
				if($key == "tablename"|| $key == "pkeys" || $key == "aikeys" || in_array($key, $this->aikeys))
				{
					continue;
				}	
				$fieldnames .= "{$key},";
				$fieldvalues .= "'{$this->$key}',";
			}
			$fieldnames = substr($fieldnames, 0, -1);
			$fieldvalues = substr($fieldvalues, 0, -1);
			$query = "INSERT INTO {$this->tablename} ({$fieldnames}) VALUES({$fieldvalues})";
		
		}
		else if($operation == 'update')
		{
			$cvars = get_class_vars(get_class($this));
			$fieldsets = "";
			$where = "";
			foreach ($this->pkeys as $key)
			{
				$where .= "{$key} = '{$this->$key}' && ";
			}
			$where = substr($where, 0, -3);
			
			foreach ($cvars as $key=>$value)
			{
				if($key == "tablename"|| $key == "pkeys" || $key == "aikeys" || in_array($key, $this->aikeys))
				{
					continue;
				}	
				
				
				$fieldsets .= "{$key} = '{$this->$key}',";
			}
			$fieldsets = substr($fieldsets, 0, -1);
			$query = "UPDATE {$this->tablename} SET  {$fieldsets} WHERE {$where}";
			
		}
		else if ($operation == 'delete')
		{
			$where = "";
			foreach ($this->pkeys as $key)
			{
				$where .= "{$key} = '{$this->$key}' && ";
			}
			$where = substr($where, 0, -3);
			$query = "DELETE FROM {$this->tablename} WHERE {$where}";
			
		}
		else if($operation == 'select')
		{
			$cvars = get_class_vars(get_class($this));				
			$where = "";
			
			foreach ($cvars as $key=>$value)
			{
				if($key == "tablename"|| $key == "pkeys" || $key == "aikeys" || $this->$key == null)
				{
					continue;
				}	
				
				$where .= "{$key} = '{$this->$key}' && ";			
			}
			
			$where = substr($where, 0, -3);
			$query = "SELECT * FROM {$this->tablename} WHERE {$where}";
		}
		return $query;
	}
	
}
 
?>