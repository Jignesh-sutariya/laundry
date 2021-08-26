<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Sub_category_model extends Admin_model
{
	public $table = "sub_category sc";
	public $select_column = ['sc.id', 'sc.sub_cat_name', 'c.cat_name', 'sc.sub_cat_image'];
	public $search_column = ['sc.id', 'sc.sub_cat_name', 'c.cat_name', 'sc.sub_cat_image'];
    public $order_column = [null, 'sc.sub_cat_name', 'c.cat_name', 'sc.sub_cat_image', null];
	public $order = ['sc.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['sc.is_deleted' => 0, 'c.is_deleted' => 0])
                 ->join('category c', 'sc.cat_id = c.id');

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('sc.id')
		         ->from($this->table)
		         ->where(['sc.is_deleted' => 0, 'c.is_deleted' => 0])
                 ->join('category c', 'sc.cat_id = c.id');
		            	
		return $this->db->get()->num_rows();
	}
}