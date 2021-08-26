<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * 
 */
class Admin_Controller extends MY_Controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->auth = $this->session->auth;
		if (!$this->auth) 
			return redirect(admin('login'));

		$this->load->model('main_model', 'main');
		$this->redirect = admin($this->redirect);
		$this->user = $this->main->get('admin', '*', ['id' => $this->auth]);
	}

    protected function uploadImage($upload)
    {
        $this->load->library('upload');
        $config = [
                'upload_path'      => $this->path,
                'allowed_types'    => 'jpg|jpeg|png',
                'file_name'        => time(),
                'file_ext_tolower' => TRUE
            ];

        $this->upload->initialize($config);
        if ($this->upload->do_upload($upload)){
            $img = $this->upload->data("file_name");
            $name = $this->upload->data("raw_name");
            
            if (in_array($this->upload->data('file_ext'), ['.jpg', '.jpeg']))
                $image = imagecreatefromjpeg($this->path.$img);
            if ($this->upload->data('file_ext') == '.png')
                $image = imagecreatefrompng($this->path.$img);

            if ($image){
                convert_webp($this->path, $image, $name);
                unlink($this->path.$img);
                $img = "$name.webp";
            }

            return ['error' => false, 'message' => $img];
        }else
            return ['error' => true, 'message' => $this->upload->display_errors()];
    }

    public function getSubCats($id)
    {
        check_ajax();
        $sub_cats = $this->main->getall('sub_category', 'id, sub_cat_name', ['cat_id' => d_id($id), 'is_deleted' => 0]);
        $return = '<option selected="" value="" disabled="" >Select Sub Category</option>';
        foreach ($sub_cats as $sc)
            $return .= '<option value="'. e_id($sc['id']) .'">'. $sc['sub_cat_name'] .'</option>';
        die($return);
    }

    public function viewOrder($id)
    {
        check_ajax();
        $this->load->model('orders_model');
        $data['name'] = "order";
        $data['title'] = "Order";
        $data['operation'] = 'view';
        $data['data'] = $this->orders_model->viewOrder(d_id($id));
        if ($data['data'])
            $data['data']['details'] = $this->orders_model->viewOrderDetails(d_id($id));
        
        return $this->load->view(admin("order/view"), $data);
    }

    public function invoice($id)
    {
        $this->load->model('orders_model');
        $data['name'] = 'order';
        $data['title'] = 'invoice';
        $data['data'] = $this->orders_model->viewOrder(d_id($id));
        if ($data['data']){
            $data['data']['details'] = $this->orders_model->viewOrderDetails(d_id($id));
            return $this->load->view(admin("order/invoice"), $data);
        }else
            return $this->error_404();
    }

    public function assign($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = "assign";
            $data['title'] = "Assign Delivery Boy";
            $data['operation'] = 'assign';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['boys'] = $this->main->getall('delivery_boy', 'id, name', ['is_deleted' => 0]);
            
            return $this->load->view(admin("order/assign"), $data);
        }else{
            $this->form_validation->set_rules('del_boy', 'Delivery Boy', 'required', ['required' => '%s is required']);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'del_boy'    => d_id($this->input->post('del_boy')),
                    'admin_note' => $this->input->post('admin_note')
                ];

                if ($this->main->update(['id' => d_id($id)], $post, 'orders'))
                    $response = [
                        'message' => "Delivery boy assigned.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "Delivery boy not assigned. Try again.",
                        'status' => false
                    ];
            }
            echo json_encode($response);
        }
    }

    public function error_404()
    {
        $data['name'] = 'error 404';
        $data['title'] = 'error 404';
        $data['url'] = $this->redirect;
        return $this->template->load('template', 'error_404', $data);
    }
}