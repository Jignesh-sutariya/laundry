<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Public_controller  {

	public function index()
	{
		echo "testing ssh login for github";
		return redirect(admin());
	}

	public function error_404()
	{
		return $this->load->view('error_404');
	}
}