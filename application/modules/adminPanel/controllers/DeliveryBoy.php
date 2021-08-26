<?php defined('BASEPATH') OR exit('No direct script access allowed');

class DeliveryBoy extends Admin_Controller {

	protected $redirect = 'deliveryBoy';
    protected $title = 'Delivery Boy';
	protected $table = 'delivery_boy';
    protected $name = 'deliveryBoy';

	public function index()
	{
		$data['name'] = $this->name;
		$data['title'] = $this->title;
		$data['url'] = $this->redirect;
        $data['dataTable'] = TRUE;

		return $this->template->load('template', "$this->redirect/home", $data);
	}

    public function get()
    {
        check_ajax();
        $this->load->model('delivery_boy_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = ucwords($row->name);
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->email;
            $sub_array[] = "<span style='white-space: normal;'>$row->address</span>";
            $action = '<div style="display: inline-flex;" class="icon-btn">';
            
            $action .= form_button(['content' => '<i class="fa fa-eye" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/view/'.e_id($row->id)),
                        'data-title' => "View $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-success btn-outline-success btn-icon mr-2']);
            $action .= form_button(['content' => '<i class="fa fa-pencil" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/update/'.e_id($row->id)),
                        'data-title' => "Update $this->title", 'onclick' => "getModalData(this)", 'class' => 'btn btn-primary btn-outline-primary btn-icon mr-2']);

            $action .= form_open($this->redirect.'/delete', 'id="'.e_id($row->id).'"', ['id' => e_id($row->id)]).
            form_button([ 'content' => '<i class="fa fa-trash"></i>',
                'type'  => 'button',
                'class' => 'btn btn-danger btn-outline-danger btn-icon', 
                'onclick' => "script.delete(".e_id($row->id)."); return false;"]).
            form_close();

            $action .= '</div>';
            $sub_array[] = $action;

            $data[] = $sub_array;  
            $sr++;
        }

        $output = [
            "draw"              => intval($_POST["draw"]),  
            "recordsTotal"      => $this->data->count(),
            "recordsFiltered"   => $this->data->get_filtered_data(),
            "data"              => $data
        ];
        
        echo json_encode($output);
    }

    public function add()
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'add';
            $data['url'] = $this->redirect;
            
            return $this->load->view("$this->redirect/add", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'name'      => $this->input->post('name'),
                    'mobile'    => $this->input->post('mobile'),
                    'email'     => $this->input->post('email'),
                    'address'   => $this->input->post('address'),
                    'licenceno' => $this->input->post('licenceno'),
                    'password'  => my_crypt($this->input->post('password'))
                ];

                if ($this->main->add($post, $this->table))
                    $response = [
                        'message' => "$this->title added.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "$this->title not added. Try again.",
                        'status' => false
                    ];
            }
            echo json_encode($response);
        }
    }

    public function view($id)
    {
        check_ajax();
        $data['name'] = $this->name;
        $data['title'] = $this->title;
        $data['operation'] = 'view';
        $data['url'] = $this->redirect;
        $data['id'] = $id;
        $data['data'] = $this->main->get($this->table, 'name, mobile, email, address, licenceno', ['id' => d_id($id)]);

        return $this->load->view("$this->redirect/view", $data);
    }

    public function update($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'update';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['data'] = $this->main->get($this->table, 'name, mobile, email, address, licenceno', ['id' => d_id($id)]);

            return $this->load->view("$this->redirect/update", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
            $response = [
                    'message' => str_replace("*", "", strip_tags(validation_errors('','<br>'))),
                    'status' => false
                ];
            else{
                $post = [
                    'name'      => $this->input->post('name'),
                    'mobile'    => $this->input->post('mobile'),
                    'email'     => $this->input->post('email'),
                    'address'   => $this->input->post('address'),
                    'licenceno' => $this->input->post('licenceno')
                ];

                if ($this->input->post('password'))
                    $post['password'] = my_crypt($this->input->post('password'));
                
                if ($this->main->update(['id' => d_id($id)], $post, $this->table))
                    $response = [
                        'message' => "$this->title updated.",
                        'status' => true
                    ];
                else
                    $response = [
                        'message' => "$this->title not updated. Try again.",
                        'status' => false
                    ];
            }
            echo json_encode($response);
        }
    }

    public function delete()
    {
        check_ajax();
        $this->form_validation->set_rules('id', 'id', 'required|numeric');
        if ($this->form_validation->run() == FALSE)
            $response = [
                        'message' => "Some required fields are missing.",
                        'message' => validation_errors(),
                        'status' => false
                    ];
        else
            if ($this->main->update(['id' => d_id($this->input->post('id'))], ['is_deleted' => 1], $this->table))
                $response = [
                    'message' => "$this->title deleted.",
                    'status' => true
                ];
            else
                $response = [
                    'message' => "$this->title not deleted. Try again.",
                    'status' => false
                ];
        echo json_encode($response);
    }

    public function mobile_check($str)
    {   
        $seg = $this->uri->segment(4) ? d_id($this->uri->segment(4)) : 0;
        $id = $this->main->check($this->table, ['mobile' => $str], 'id');

        if ((!$seg && $id) || ($seg && $id && $id != $seg))
        {
            $this->form_validation->set_message('mobile_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function email_check($str)
    {   
        $seg = $this->uri->segment(4) ? d_id($this->uri->segment(4)) : 0;
        $id = $this->main->check($this->table, ['email' => $str], 'id');

        if ((!$seg && $id) || ($seg && $id && $id != $seg))
        {
            $this->form_validation->set_message('email_check', 'The %s is already in use');
            return FALSE;
        } else
            return TRUE;
    }

    public function password_check($str)
    {   
        $seg = $this->uri->segment(4);
        
        if (!$seg && !$str)
        {
            $this->form_validation->set_message('password_check', '%s is required');
            return FALSE;
        } else
            return TRUE;
    }

    protected $validate = [
        [
            'field' => 'name',
            'label' => 'Name',
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
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'callback_password_check'
        ],
        [
            'field' => 'address',
            'label' => 'Address',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'licenceno',
            'label' => 'Licence no',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ]
    ];
}