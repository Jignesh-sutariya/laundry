<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Address_model extends Admin_model
{
	public $table = "shop_address a";
	public $select_column = ['a.id', 'a.address'];
	public $search_column = ['a.id', 'a.address'];
    public $order_column = [null, 'a.address', null];
	public $order = ['a.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['a.is_deleted' => 0]);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('a.id')
		         ->from($this->table)
		         ->where(['a.is_deleted' => 0]);
		            	
		return $this->db->get()->num_rows();
	}
}