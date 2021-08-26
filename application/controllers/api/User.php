<?php defined('BASEPATH') OR exit('No direct script access allowed');

class User extends Public_controller  {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('api');
		$this->load->model('user_api_modal', 'api');
	}

	private $table = 'users';

	public function send_otp()
	{
		post();
		verifyRequiredParams(['mobile']);
		$post = [
			'mobile' => $this->input->post('mobile'),
			'otp'	 => rand(1000, 9999),
			'otp'	 => 1234,
			'expiry' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
		];

		if ($this->main->check('otp_check', ['mobile' => $post['mobile']], 'mobile'))
		 	$id = $this->main->update(['mobile' => $post['mobile']], $post, 'otp_check');
		else
		 	$id = $this->main->add($post, 'otp_check');
		
		if ($id) {
			/*$sms = 'Your OTP is : '.$post['otp'];
			send_otp($post['mobile'], $sms);*/
			$response["error"] = TRUE;
            $response['message'] = "OTP send successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "OTP send not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function otp_check()
	{
		post();
		verifyRequiredParams(['mobile', 'otp']);
		$post = [
			'mobile' => $this->input->post('mobile'),
			'otp' => $this->input->post('otp'),
			'expiry >=' => date('Y-m-d H:i:s')
		];
		
		if ($this->main->check('otp_check', $post, 'mobile')) {
			$this->main->delete('otp_check', $post);
			$u_id = $this->main->check($this->table, ['mobile' => $post['mobile']], 'id');
			$response["row"] = $u_id ? $u_id : '0';
			$response["error"] = TRUE;
            $response['message'] = "OTP check successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Invalid OTP. Try again.";
            echoResponse(400, $response);
		}
	}

	public function user_signup()
	{
		post();
		verifyRequiredParams(['name', 'address', 'mobile', 'password', 'latitude', 'longitude']);

		if ($this->main->check($this->table, ['mobile' => $this->input->post('mobile')], 'id')) {
			$response["error"] = TRUE;
            $response['message'] = "Mobile already in use!";
            echoResponse(400, $response);
		}else{
			if ($user = $this->api->user_signup()) {
				$response["row"] = $user;
				$response["error"] = TRUE;
	            $response['message'] = "Signup successfull.";
	            echoResponse(200, $response);
			}else{
				$response["error"] = TRUE;
	            $response['message'] = "Signup not successfull. Try again.";
	            echoResponse(400, $response);
			}
		}
	}

	public function user_login()
	{
		post();
		verifyRequiredParams(['mobile', 'password', 'token']);
		if ($row = $this->api->user_login()) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Login successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Login not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function banner_list()
	{
		get();
		if ($row = $this->api->banner_list()) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Banner list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Banner list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function category_list()
	{
		get();
		if ($row = $this->api->category_list()) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Category list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Category list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function subcategory_list()
	{
		get();
		verifyRequiredParams(['cat_id']);

		if ($row = $this->api->subcategory_list()) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Sub category list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Sub category list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function item_list()
	{
		get();
		verifyRequiredParams(['sub_cat_id']);

		if ($row = $this->api->item_list()) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Item list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Item list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function address_list()
	{
		get();
		$api = authenticate($this->table);

		if ($row = $this->main->getall('user_address', 'id, address, latitude, longitude', ['u_id' => $api, 'is_deleted' => 0])) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Address list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Address list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function add_address()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['address', 'latitude', 'longitude']);
		$post = [
				'address'   => $this->input->post('address'),
				'latitude'  => $this->input->post('latitude'),
				'longitude' => $this->input->post('longitude'),
				'u_id'      => $api
			];
		
		if ($row = $this->main->add($post, 'user_address')) {
			$response["error"] = TRUE;
            $response['message'] = "Add address successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Add address not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function delete_address()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['add_id']);
		
		if ($row = $this->main->update(['id' => $this->input->post('add_id')], ['is_deleted' => 1], 'user_address')) {
			$response["error"] = TRUE;
            $response['message'] = "Delete address successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Delete address not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function forgot_password()
	{
		post();
		verifyRequiredParams(['mobile']);

		$post = [
			'mobile' => $this->input->post('mobile'),
			'otp'	 => rand(1000, 9999),
			'otp'	 => 1234,
			'expiry' => date('Y-m-d H:i:s', strtotime('+5 minutes'))
		];

		if (!$this->main->check($this->table, ['mobile' => $post['mobile']], 'id')) {
			$response["error"] = TRUE;
            $response['message'] = "Mobile not registered with us.";
            echoResponse(400, $response);
		}

		if ($this->main->check('otp_check', ['mobile' => $post['mobile']], 'mobile'))
		 	$id = $this->main->update(['mobile' => $post['mobile']], $post, 'otp_check');
		else
		 	$id = $this->main->add($post, 'otp_check');
		
		if ($id) {
			/*$sms = 'Your OTP is : '.$post['otp'];
			send_otp($post['mobile'], $sms);*/
			$response["error"] = TRUE;
            $response['message'] = "OTP send successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "OTP send not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function reset_password()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['password']);
		
		if ($row = $this->main->update(['id' => $api], ['password' => my_crypt($this->input->post('password'))], $this->table)) {
			$response["error"] = TRUE;
            $response['message'] = "Password change successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Password change not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function user_edit()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['name']);
		
		if ($row = $this->main->update(['id' => $api], ['name' => $this->input->post('name')], $this->table)) {
			$response["error"] = TRUE;
            $response['message'] = "User edit successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "User edit not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function contact_us()
	{
		get();
		
		if ($row = $this->main->get('contact_us', 'address, lat, lng, mobile, email, about', [])) 
		{
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Contact us successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Contact us not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function add_cart()
	{
		post();
		$api = authenticate($this->table);
		if (!is_array($this->input->post('cart_items'))) {
			$response["error"] = TRUE;
            $response['message'] = "Required field(s) cart_items is missing or empty";
            echoResponse(400, $response);
		}else{
			if ($row = $this->api->add_cart($api))
			{
				$response["error"] = TRUE;
	            $response['message'] = "Add cart successfull.";
	            echoResponse(200, $response);
			}else{
				$response["error"] = TRUE;
	            $response['message'] = "Add cart not successfull. Try again.";
	            echoResponse(400, $response);
			}
		}
	}

	public function cart_list()
	{
		get();
		$api = authenticate($this->table);
		
		if ($row = $this->api->cart_list($api))
		{
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Cart list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Cart list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function cart_count()
	{
		get();
		$api = authenticate($this->table);
		
		if ($row = $this->api->cart_count($api))
		{
			$response["row"] = "$row";
			$response["error"] = TRUE;
            $response['message'] = "Cart count successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Cart count not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function add_order()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['add_id', 'pickup_date', 'pickup_time', 'delivery_date', 'total_bill', 'delivery_charge']);
		
		if ($row = $this->api->add_order($api))
		{
			$response["error"] = TRUE;
            $response['message'] = "Add order successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Add order not successfull. Try again.";
            echoResponse(400, $response);
		}
	}

	public function order_list()
	{
		get();
		$api = authenticate($this->table);
		verifyRequiredParams(['status']);
		
		if ($row = $this->api->order_list($api)) {
			$response["row"] = $row;
			$response["error"] = TRUE;
            $response['message'] = "Order list successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Order list not successfull. Try again.";
            echoResponse(400, $response);
		}
	}
}