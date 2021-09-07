<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {

	protected $redirect = '';
	protected $table = 'admin';

	public function index()
	{
		$data['name'] = 'dashboard';
		$data['title'] = 'dashboard';
		$data['dataTable'] = TRUE;
        $data['refresh'] = TRUE;
        $data['url'] = $this->redirect.'orders';
        /* $cats = $this->main->getall('category', 'id', ['is_deleted' => 0]);
        $this->load->helper('string');
        foreach ($cats as $cat) {
            foreach (['MEN', 'WOMEN', 'KIDS', 'House Hold'] as $sub) {
                $subcat = [
                    'sub_cat_name' => $sub,
                    'sub_cat_image' => 'NA',
                    'cat_id' => $cat['id']
                ];
                $id = $this->main->add($subcat, 'sub_category');
                for ($i=0; $i < 3; $i++) { 
                    $item = [
                                'item_name' => random_string('alpha', 10),
                                'price' => random_string('numeric', 2),
                                'sub_cat_id' => $id,
                                'cat_id' => $cat['id']
                    ];
                    $this->main->add($item, 'item');
                }
            }
        } */
		return $this->template->load('template', 'dashboard', $data);
	}

    public function orders()
    {
        check_ajax();
        $this->load->model('orders_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $row->id;
            $sub_array[] = ucwords($row->name);
            $sub_array[] = $row->mobile;
            $sub_array[] = "<span style='white-space: normal;'>$row->address</span>";
            switch ($row->orders_status) {
                case 'New order':
                    $sub_array[] = $row->del_boy ? ucfirst($row->del_boy) : form_button([
                    'content' => 'Assign',
                    'type'  => 'button',
                    'data-url' => base_url($this->redirect.'assign/'.e_id($row->id)),
                    'data-title' => "Assign order",
                    'onclick' => "getModalData(this)",
                    'class' => 'btn btn-primary btn-outline-primary waves-effect btn-round btn-block'
                    ]);
                    break;
                
                case 'In delivery':
                    $sub_array[] = $row->del_boy ? ucfirst($row->del_boy) : form_button([
                    'content' => 'Assign',
                    'type'  => 'button',
                    'data-url' => base_url($this->redirect.'assign/'.e_id($row->id)),
                    'data-title' => "Assign order",
                    'onclick' => "getModalData(this)",
                    'class' => 'btn btn-primary btn-outline-primary waves-effect btn-round btn-block'
                    ]);
                    break;
                
                default:
                    $sub_array[] = $row->del_boy ? ucfirst($row->del_boy) : 'NA';
                    break;
            }

            $action = '<div style="display: inline-flex;" class="icon-btn">';
            
            if ($row->orders_status == 'In wash')
                $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'updateOrder/'.e_id($row->id)), 'data-title' => "Update order", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);
            
            $action .= form_button(['content' => '<i class="fa fa-eye" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'viewOrder/'.e_id($row->id)),
                        'data-title' => "View order", 'onclick' => "getModalData(this)", 'class' => 'btn btn-success btn-outline-success btn-icon mr-2']);
            
            if ($row->orders_status == 'Completed')
                $action .= anchor($this->redirect.'invoice/'.e_id($row->id), '<i class="fa fa-print" ></i>', 'class="btn btn-primary btn-outline-primary btn-icon" target="_blank"');

            $action .= '</div>';
            $sub_array[] = $action;

            $data[] = $sub_array;
        }

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];
        
        echo json_encode($output);
    }

    public function updateOrder($id)
    {
        check_ajax();
        $this->load->model('orders_model');
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = 'order';
            $data['title'] = 'order';
            $data['operation'] = 'update';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['data'] = $this->orders_model->viewOrder(d_id($id));
            if ($data['data'])
                $data['data']['details'] = $this->orders_model->viewOrderDetails(d_id($id));
            
            return $this->load->view("$this->redirect/updateOrder", $data);
        }else{
            if ($this->orders_model->updateOrder(d_id($id)))
                $response = [
                    'message' => "Order updated.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "Order not updated. Try again.",
                    'status' => false
                ];
            
            echo json_encode($response);
        }
    }

	public function profile()
	{
        if (!$this->input->is_ajax_request()) {
            $data['name'] = 'profile';
            $data['title'] = 'profile';
            $data['url'] = $this->redirect;

            return $this->template->load('template', 'profile', $data);
        }else{
    		$this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
            	$post = [
                    'name'        => $this->input->post('name'),
                    'mobile'      => $this->input->post('mobile'),
                    'email'       => $this->input->post('email')
                ];

                if ($this->input->post('password'))
                    $post['password'] = my_crypt($this->input->post('password'));
            	
            	if ($this->main->update(['id' => $this->auth], $post, $this->table))
                	$response = [
                        'message' => "Profile updated successfully.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "Profile not updated. Try again.",
                        'status' => false
                    ];
            }
            echo json_encode($response);
        }
	}

    public function logout()
    {
        $this->session->sess_destroy();
        return redirect(admin('login'));
    }

	public function database()
	{
		// Load the DB utility class
        $this->load->dbutil();
        
        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        force_download(APP_NAME.'.zip', $backup);

        return redirect(admin());
	}

    public function mobile_check($str)
    {   
        if ($this->main->check($this->table, ['mobile' => $str, 'id != ' => $this->auth], 'id'))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        if ($this->main->check($this->table, ['email' => $str, 'id != ' => $this->auth], 'id'))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'User Name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'email',
            'label' => 'Email',
            'rules' => 'required|callback_email_check',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'mobile',
            'label' => 'Mobile No.',
            'rules' => 'required|exact_length[10]|callback_mobile_check|numeric',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'exact_length' => "%s is Invalid",
            ]
        ]
    ];
}