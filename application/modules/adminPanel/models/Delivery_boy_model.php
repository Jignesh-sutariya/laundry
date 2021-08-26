<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Delivery_boy_model extends Admin_model
{
	public $table = "delivery_boy d";
	public $select_column = ['d.id', 'd.name', 'd.mobile', 'd.email', 'd.address'];
	public $search_column = ['d.name', 'd.mobile', 'd.email', 'd.address'];
    public $order_column = [null, 'd.name', 'd.mobile', 'd.email', 'd.address', null];
	public $order = ['d.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['d.is_deleted' => 0]);

        $this->datatable();
	}

	public function count()
	{
		return $this->db->select('d.id')
						->from($this->table)
						->where(['d.is_deleted' => 0])
                        ->get()
						->num_rows();
	}
}