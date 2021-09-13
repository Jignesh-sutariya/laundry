<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Delivery_boy_api_modal extends Public_model
{
	private $table = 'delivery_boy';

	public function login()
	{
		$where = [
				'mobile'   => $this->input->post('mobile'),
				'password' => my_crypt($this->input->post('password'))
			];
		
		$user = $this->db->select('id, name, mobile, address')
						->from($this->table)
						->where($where)
						->get()
						->row_array();
		if ($user)
			$this->db->where(['id' => $user['id']])->update($this->table, ['access_token' => $this->input->post('token')]);
		return $user;
	}

	public function order_list($api)
	{
		$where = [
				'orders_status' => $this->input->get('status'),
				'del_boy'   	=> $api
			];
		
		return $this->db->select('o.id, o.total_bill, o.pickup_date, o.pickup_time, o.delivery_date, o.admin_note notes, o.delivery_charge, a.address, u.name, u.mobile')
						->from('orders o')
						->where($where)
						->join('users u', 'u.id = o.u_id')
						->join('user_address a', 'a.id = o.add_id')
						->get()
						->result_array();
	}

	public function order_details()
	{
		$where = [ 'o_id' => $this->input->get('order_id') ];
		
		return $this->db->select('so.price, so.quantity, i.item_name, i.price_type')
						->from('sub_orders so')
						->where($where)
						->join('item i', 'i.id = so.item_id')
						->get()
						->result_array();
	}
}