<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Orders_model extends Admin_model
{
	public $table = "orders o";
	public $select_column = ['o.id', 'u.name', 'u.mobile', 'a.address', 'd.name del_boy', 'o.orders_status'];
	public $search_column = ['o.id', 'u.name', 'u.mobile', 'a.address', 'd.name'];
    public $order_column = [null, 'o.id', 'u.name', 'u.mobile', 'a.address', 'd.name', null];
	public $order = ['o.id' => 'DESC'];

	public function make_query()
	{  
        $status = $this->input->post('status') ? $this->input->post('status') : 'New order';
		$this->db->select($this->select_column)
            	 ->from($this->table)
            	 ->where(['o.orders_status' => $status])
                 ->join('users u', 'o.u_id = u.id')
                 ->join('user_address a', 'o.add_id = a.id')
                 ->join('delivery_boy d', 'o.del_boy = d.id', 'left');

        $this->datatable();
	}

	public function count()
	{
        $status = $this->input->post('status') ? $this->input->post('status') : 'New order';
		$this->db->select('o.id')
		         ->from($this->table)
		         ->where(['o.orders_status' => $status]);
		            	
		return $this->db->get()->num_rows();
	}

	public function viewOrder($id)
	{
        $this->db->select(['o.id', 'u.name', 'u.mobile', 'o.orders_status', 'o.created_at', 'o.delivery_charge', 'o.total_bill', 'a.address'])
            	 ->from($this->table)
            	 ->where(['o.id' => $id])
                 ->join('users u', 'o.u_id = u.id')
                 ->join('user_address a', 'o.add_id = a.id');
		            	
		return $this->db->get()->row_array();
	}

	public function viewOrderDetails($id)
	{
        $this->db->select('s.id, s.price, s.quantity, i.item_name, sc.sub_cat_name, c.cat_name')
            	 ->from('sub_orders s')
            	 ->where(['s.o_id' => $id])
            	 ->join('item i', 's.item_id = i.id')
            	 ->join('sub_category sc', 's.sub_cat_id = sc.id')
            	 ->join('category c', 's.cat_id = c.id');
		            	
		return $this->db->get()->result_array();
	}

	public function updateOrder($id)
	{
		$this->db->trans_start();
		$total = 0;
        foreach ($this->input->post('sub_order') as $k => $v){
        	$total += $v['price'] * $v['quantity'];
        	$sub = ['price' => $v['price'], 'quantity' => $v['quantity']];
        	$this->db->where('id', $k)->update('sub_orders', $sub);
        }
        $order = ['total_bill' => $total, 'orders_status' => 'In delivery', 'del_boy' => 0];
        $this->db->where('id', $id)->update('orders', $order);
        $this->db->trans_complete();

		return $this->db->trans_status();
	}
}