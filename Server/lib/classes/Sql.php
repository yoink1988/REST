<?php
class Sql
{
	public $table;
	protected $where;
	protected $columns;
	protected $join;
	protected $limit = null;
	protected $order;
	protected $params = array();
    public  $queryType;
    protected $query;
    protected $having;
    protected $group;
    protected $desc = false;
	protected $dist = false;


	public function select()
	{
        $this->queryType = 'select';
		return $this;
	}
	public function insert()
	{
		$this->queryType = 'insert';
		return $this;
	}
	public function delete()
	{
		$this->queryType = 'delete';
		return $this;
	}
	public function update()
	{
		$this->queryType = 'update';
		return $this;
	}

    public function join($join)
    {
        $this->join = ' inner join '.$join;
        return $this;
    }
    public function leftJoin($join)
    {
        $this->join = ' left outer join '.$join;
        return $this;
    }
    public function rightJoin($join)
    {
        $this->join = ' right outer join '.$join;
        return $this;
    }
    public function crossJoin($join)
    {
        $this->join = ' cross join '.$join;
        return $this;
    }
    public function naturalJoin($join)
    {
        $this->join = ' natural join '.$join;
        return $this;
    }

	public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    public function setDistinct($distinct)
    {
        $this->dist = $distinct;
        return $this;
    }

    public function setHaving($having)
    {
        $this->having = $having;
        return  $this;
    }

    public function setGroup($group)
    {
        $this->group = $group;
        return $this;
    }

    public function setTable($table)
	{
		$this->table = $table;
		return $this;
	}
	public function setWhere($where)
	{
		$this->where = $where;
		return $this;
	}
	public function setColumns($columns)
	{
		if($columns == '*')
		{
			$this->columns = '';
		}
		$this->columns = $columns;
		return $this;
	}
	public function setLimit($limit)
	{
		$this->limit = $limit;
		return $this;
	}
	public function setParams(array $params)
	{
		$this->params = $params;
		return $this;
	}

	public function exec()
	{
		$this->query ='';

		switch ($this->queryType)
		{
			case 'select':
                $this->query .= "select ";
                if($this->dist)
                {
                    $this->query .="distinct ";
                }
                $this->query .=$this->columns. " from ". "{$this->table}";
				if($this->join)
				{
					$this->query .= " {$this->join}";
				}
				if($this->where)
				{
					$this->query .= " where {$this->where}";
                }
                if($this->group)
                {
                    $this->query .=" group by {$this->group}";
                }
                if($this->having)
                {
                    $this->query .=" having {$this->having}";
                }
                if($this->order)
                {
                    $this->query .= " order by {$this->order}";//// asc desc
                }
                 if($this->limit)
				{
					$this->query .= " LIMIT {$this->limit}";
                }
 				break;
            case 'insert':

				$this->query .="insert into ". "{$this->table}";

                if($this->columns)
                {
                    $this->query .=" ({$this->columns})";
                }
				$values = implode(", ", $this->params);
				$this->query .=" values ($values)";
                break;


			case 'delete':
				$this->query .= "delete from ". "{$this->table}";
				if($this->where)
				{
					$this->query .=" where {$this->where}";
				}
				else
				{
					$this->query = "no where - no delete";
					break;
				}
				if($this->limit)
				{
					$this->query .= " LIMIT {$this->limit}";
                }

				break;
			case 'update':
				$this->query .= "update {$this->table} set ";

				foreach($this->params as $k => $v)
				{
					$this->query .= "{$k} = {$v}, ";
				}
				$this->query = substr($this->query, 0, -2);
				if($this->where)
				{
					$this->query .= " where {$this->where}";
				}
				
				else
				{
					$this->query = "no where - no update";
					break;
				}
				if($this->limit)
				{
					$this->query .=" LIMIT {$this->limit}";
                }
				break;
		}
	}
   public function __construct(){}
}
