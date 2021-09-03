<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class User_api_modal extends Public_model
{
	private $table = 'users';
	private $banner = 'assets/images/banner/';
	private $cat_image = 'assets/images/category/';
	private $sub_cat_image = 'assets/images/sub_category/';

	public function user_signup()
	{
		$post = [
				'name'     => $this->input->post('name'),
				'mobile'   => $this->input->post('mobile'),
				'password' => my_crypt($this->input->post('password'))
			];

		$this->db->trans_start();
		$this->db->insert($this->table, $post);
		$add = [
				'address'   => $this->input->post('address'),
				'latitude'  => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
				'u_id'      => (string) $this->db->insert_id()
			];
		$this->db->insert('user_address', $add);

		$this->db->trans_complete();

		if ($this->db->trans_status() === TRUE)
		{
			return array_merge($post, $add);
		}else{
			return false;
		}
	}

	public function user_login()
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

	public function banner_list()
	{
		return $this->db->select("CONCAT('".base_url($this->banner)."', banner) banner")
						->from('banner')
						->get()
						->result_array();
	}

	public function category_list()
	{
		return $this->db->select("id, CONCAT('".base_url($this->cat_image)."', cat_image) cat_image, cat_name")
						->from('category')
						->where(['is_deleted' => 0])
						->get()
						->result_array();
	}

	public function subcategory_list()
	{
		return $this->db->select("id, CONCAT('".base_url($this->sub_cat_image)."', sub_cat_image) sub_cat_image, sub_cat_name")
						->from('sub_category')
						->where(['is_deleted' => 0, 'cat_id' => $this->input->get('cat_id')])
						->get()
						->result_array();
	}

	public function item_list()
	{
		return $this->db->select("i.id, i.item_name, i.price, c.quantity")
						->from('item i')
						->where(['is_deleted' => 0, 'sub_cat_id' => $this->input->get('sub_cat_id')])
						->join('add_cart c', 'i.id = c.item_id', 'left')
						->get()
						->result_array();
	}

	public function cart_list($api)
	{
		return $this->db->select("c.item_id, c.quantity, i.item_name, i.price, i.sub_cat_id, i.cat_id, (c.quantity * i.price) total")
						->from('add_cart c')
						->where(['c.u_id' => $api, 'i.is_deleted' => 0])
						->join('item i', 'c.item_id = i.id')
						->get()
						->result_array();
	}

	public function cart_count($api)
	{
		return $this->db->select("c.item_id")
						->from('add_cart c')
						->where(['c.u_id' => $api, 'i.is_deleted' => 0])
						->join('item i', 'c.item_id = i.id')
						->get()
						->num_rows();
	}

	public function add_cart($api)
	{
		foreach ($this->input->post('cart_items') as $k => $v)
			$cart[$k] = [
				'item_id'  => $v['item_id'],
				'quantity' => $v['quantity'],
				'u_id' 	   => $api
			];
		$this->db->trans_start();
		$this->db->delete('add_cart', ['u_id' => $api]);
		$this->db->insert_batch('add_cart', $cart);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	public function add_order($api)
	{
		if ($this->cart_count($api) < 1) return false;

		$order = [
			'u_id'            => $api,
			'add_id' 		  => $this->input->post('add_id'),
			'pickup_date'     => $this->input->post('pickup_date'),
			'pickup_time' 	  => $this->input->post('pickup_time'),
			'delivery_date'   => $this->input->post('delivery_date'),
			'total_bill' 	  => $this->input->post('total_bill'),
			'delivery_charge' => $this->input->post('delivery_charge'),
			'created_at'	  => date('Y-m-d H:i:s')
		];
		
		$this->db->trans_start();
		$this->db->insert('orders', $order);
		$o_id = $this->db->insert_id();
		foreach ($this->cart_list($api) as $v)
			$sub[] = [
				'price' => $v['price'],
				'quantity' => $v['quantity'],
				'o_id' => $o_id,
				'item_id' => $v['item_id'],
				'sub_cat_id' => $v['sub_cat_id'],
				'cat_id' => $v['cat_id']
			];
		$this->db->insert_batch('sub_orders', $sub);
		$this->db->delete('add_cart', ['u_id' => $api]);
		$this->db->trans_complete();

		return $this->db->trans_status();
	}

	public function order_list($api)
	{
		$where = [
				'orders_status' => $this->input->get('status'),
				'u_id'   	    => $api
			];
		
		return array_map(function($arr){
			return [
				'id' => $arr['id'],
				'total_bill' => $arr['total_bill'],
				'pickup_date' => $arr['pickup_date'],
				'pickup_time' => $arr['pickup_time'],
				'delivery_date' => $arr['delivery_date'],
				'delivery_charge' => $arr['delivery_charge'],
				'items' => $this->db->select('i.item_name')
									->from('sub_orders so')
									->where(['so.o_id' => $arr['id']])
									->join('item i', 'so.item_id = i.id')
									->get()
									->result_array()
			];
		}, $this->db->select('o.id, o.total_bill, o.pickup_date, o.pickup_time, o.delivery_date, o.delivery_charge')
						->from('orders o')
						->where($where)
						->get()
						->result_array());
	}
}