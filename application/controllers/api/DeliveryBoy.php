<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryBoy extends Public_controller  {

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('api');
		$this->load->model('delivery_boy_api_modal', 'api');
	}

	private $table = 'delivery_boy';

	public function login()
	{
		post();
		verifyRequiredParams(['mobile', 'password', 'token']);
		if ($row = $this->api->login()) {
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
			$response["row"] = $this->main->check($this->table, ['mobile' => $post['mobile']], 'id');
			$response["error"] = TRUE;
            $response['message'] = "OTP check successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Invalid OTP. Try again.";
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

	public function profile_edit()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['name', 'address']);
		$post = [
			'name'	  => $this->input->post('name'),
			'address' => $this->input->post('address')
		];
		if ($row = $this->main->update(['id' => $api], $post, $this->table)) {
			$response["error"] = TRUE;
            $response['message'] = "Profile edit successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Profile edit not successfull. Try again.";
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

	public function order_status()
	{
		post();
		$api = authenticate($this->table);
		verifyRequiredParams(['status', 'o_id']);
		
		$post = ['orders_status' => $this->input->post('status')];
		
		if ($row = $this->main->update(['id' => $this->input->post('o_id')], $post, 'orders')) {
			$response["error"] = TRUE;
            $response['message'] = "Order status change successfull.";
            echoResponse(200, $response);
		}else{
			$response["error"] = TRUE;
            $response['message'] = "Order status change not successfull. Try again.";
            echoResponse(400, $response);
		}
	}
}