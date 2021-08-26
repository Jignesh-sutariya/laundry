<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Banner_model extends Admin_model
{
	public $table = "banner b";
	public $select_column = ['b.id', 'b.banner'];
	public $search_column = ['b.id', 'b.banner'];
    public $order_column = [null, 'b.banner', null];
	public $order = ['b.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table);

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('b.id')
		         ->from($this->table);
		            	
		return $this->db->get()->num_rows();
	}
}