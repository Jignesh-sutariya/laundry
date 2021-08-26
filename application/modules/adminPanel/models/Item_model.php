<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Item_model extends Admin_model
{
	public $table = "item i";
	public $select_column = ['i.id', 'i.item_name', 'price', 'sc.sub_cat_name', 'c.cat_name'];
	public $search_column = ['i.id', 'i.item_name', 'price', 'sc.sub_cat_name', 'c.cat_name'];
    public $order_column = [null, 'i.item_name', 'price', 'sc.sub_cat_name', 'c.cat_name', null];
	public $order = ['i.id' => 'DESC'];

	public function make_query()
	{  
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['i.is_deleted' => 0, 'sc.is_deleted' => 0, 'c.is_deleted' => 0])
                 ->join('category c', 'i.cat_id = c.id')
                 ->join('sub_category sc', 'i.sub_cat_id = sc.id');

        $this->datatable();
	}

	public function count()
	{
		$this->db->select('i.id')
		         ->from($this->table)
		         ->where(['i.is_deleted' => 0, 'sc.is_deleted' => 0, 'c.is_deleted' => 0])
                 ->join('category c', 'i.cat_id = c.id')
                 ->join('sub_category sc', 'i.sub_cat_id = sc.id');
		            	
		return $this->db->get()->num_rows();
	}
}