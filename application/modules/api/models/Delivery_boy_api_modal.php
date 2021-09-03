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
		
		$user = $this->db->select('id, name, mobile')
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
		
		return $this->db->select('o.id, o.total_bill, o.pickup_date, o.pickup_time, o.delivery_date, o.admin_note notes, o.delivery_charge')
						->from('orders o')
						->where($where)
						->get()
						->result_array();
	}
}