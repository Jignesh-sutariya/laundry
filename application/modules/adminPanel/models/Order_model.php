<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Order_model extends Admin_model
{
	public $table = "orders o";
	public $select_column = ['o.id', 'u.name', 'u.mobile', 'o.delivery_date', 'd.name del_boy'];
	public $search_column = ['o.id', 'u.name', 'u.mobile', 'o.delivery_date', 'd.name'];
    public $order_column = [null, 'o.id', 'u.name', 'u.mobile', 'o.delivery_date', 'd.name', null];
	public $order = ['o.id' => 'DESC'];

	public function make_query()
	{  
        $status = $this->input->post('status') ? $this->input->post('status') : 'Completed';
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['o.orders_status' => $status])
                 ->join('users u', 'o.u_id = u.id')
                 ->join('delivery_boy d', 'o.del_boy = d.id', 'left');

        $this->datatable();
	}

	public function count()
	{
        $status = $this->input->post('status') ? $this->input->post('status') : 'Completed';
		$this->db->select('o.id')
		         ->from($this->table)
		         ->where(['o.orders_status' => $status])
                 ->join('users u', 'o.u_id = u.id')
                 ->join('delivery_boy d', 'o.del_boy = d.id', 'left');
		            	
		return $this->db->get()->num_rows();
	}
}