<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Order extends Admin_Controller {

	protected $redirect = 'order';
    protected $title = 'Order';
	protected $table = 'orders';
    protected $name = 'order';

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
        $this->load->model('order_model', 'data');
        $fetch_data = $this->data->make_datatables();
        $sr = $_POST['start'] + 1;
        $data = [];
        foreach($fetch_data as $row)
        {  
            $sub_array = [];
            $sub_array[] = $sr;
            $sub_array[] = $row->id;
            $sub_array[] = ucwords($row->name);
            $sub_array[] = $row->mobile;
            $sub_array[] = $row->delivery_date;
            $sub_array[] = $row->del_boy ? ucfirst($row->del_boy) : 'NA';
            $action = '<div style="display: inline-flex;" class="icon-btn">';

            $action .= form_button(['content' => '<i class="fa fa-eye" ></i>', 'type'  => 'button', 'data-url' => base_url($this->redirect.'/viewOrder/'.e_id($row->id)),
                        'data-title' => "View order", 'onclick' => "getModalData(this)", 'class' => 'btn btn-success btn-outline-success btn-icon mr-2']);
            $action .= anchor($this->redirect.'/invoice/'.e_id($row->id), '<i class="fa fa-print" ></i>', 'class="btn btn-primary btn-outline-primary btn-icon" target="_blank"');

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
}