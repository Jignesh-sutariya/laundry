<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Item extends Admin_Controller {

	protected $redirect = 'item';
    protected $title = 'Item';
	protected $table = 'item';
    protected $name = 'item';

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
        $this->load->model('item_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->item_name;
            $sub_array[] = "$row->price per $row->price_type";
            $sub_array[] = $row->sub_cat_name;
            $sub_array[] = $row->cat_name;
            
            $action = '<div style="display: inline-flex;" class="icon-btn">';

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
            $data['cats'] = $this->main->getall('category', 'id, cat_name', ['is_deleted' => 0]);

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
                        'item_name'  => $this->input->post('item_name'),
					    'price' 	 => $this->input->post('price'),
                        'price_type' => $this->input->post('price_type'),
					    'sub_cat_id' => d_id($this->input->post('sub_cat_id')),
					    'cat_id'     => d_id($this->input->post('cat_id'))
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

    public function update($id)
    {
        check_ajax();
        if ($this->input->server('REQUEST_METHOD') === 'GET') {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['operation'] = 'update';
            $data['url'] = $this->redirect;
            $data['id'] = $id;
            $data['data'] = $this->main->get($this->table, 'item_name, price, price_type, sub_cat_id, cat_id', ['id' => d_id($id)]);
            $data['cats'] = $this->main->getall('category', 'id, cat_name', ['is_deleted' => 0]);

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
                        'item_name'  => $this->input->post('item_name'),
					    'price' 	 => $this->input->post('price'),
					    'price_type' => $this->input->post('price_type'),
					    'sub_cat_id' => d_id($this->input->post('sub_cat_id')),
					    'cat_id'     => d_id($this->input->post('cat_id'))
                ];
                
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

    protected $validate = [
        [
            'field' => 'cat_id',
            'label' => 'Category',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => "%s is Required",
                'is_natural_no_zero' => "Invalid %s"
            ]
        ],
        [
            'field' => 'sub_cat_id',
            'label' => 'Sub Category',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => "%s is Required",
                'is_natural_no_zero' => "Invalid %s"
            ]
        ],
        [
            'field' => 'item_name',
            'label' => 'Item name',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'price',
            'label' => 'Item price',
            'rules' => 'required|is_natural_no_zero',
            'errors' => [
                'required' => "%s is Required",
                'is_natural_no_zero' => "Invalid %s"
            ]
        ],
        [
            'field' => 'price_type',
            'label' => 'Item price type',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ]
    ];
}