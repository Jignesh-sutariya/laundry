<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends Admin_Controller {

	protected $redirect = 'contact';
    protected $title = 'Contact Us';
	protected $table = 'contact_us';
    protected $name = 'contact';

	public function index()
	{
        if (!$this->input->is_ajax_request()) {
            $data['name'] = $this->name;
            $data['title'] = $this->title;
            $data['url'] = $this->redirect;
            $about = $this->main->get($this->table, 'address, lat, lng, mobile, email, about', []);
            if (!$about) {
                $post = [
                    'address' => 'REGISTERED OFFICE, KUMAR ANUPAM,E2/502, ARYA VILLA, NEW RANIP, AHMEDABAD, GUJARAT, INDIA- 382470',
                    'lat'     => 10.10,
                    'lng'     => 20.20,
                    'mobile'  => '84573774676',
                    'about'   => 'HAVE YOU EVER WANTED TO LEARN HOW TO CLOSE 100% OF YOUR CONSULTATIONS & HELP YOUR COMPANY WIN IN OUR NEW COVID-19 ECONOMY? SEE THE OFFICIAL TRAILER:@ The Author site https://www.tonydeoleo.com Download your E-book Copy Now @ The Author o',
                    'email'   => 'info@deoleodigitalpublishing.com'
                ];
                $this->main->add($post, $this->table);
                $about = $this->main->get($this->table, 'address, lat, lng, mobile, email, about', []);
            }
            $data['data'] = $about;
            
            return $this->template->load('template', "$this->redirect/home", $data);
        }else{
            $this->form_validation->set_rules($this->validate);
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
                $post = [
                    'address' => $this->input->post('address'),
                    'lat'     => $this->input->post('lat'),
                    'lng'     => $this->input->post('lng'),
                    'mobile'  => $this->input->post('mobile'),
                    'about'   => $this->input->post('about'),
                    'email'   => $this->input->post('email')
                ];
                
                if ($this->main->update([], $post, $this->table))
                    $response = [
                        'message' => "$this->title updated successfully.",
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

    protected $validate = [
        [
            'field' => 'address',
            'label' => 'address',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ]
        ],
        [
            'field' => 'lat',
            'label' => 'lat',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'lng',
            'label' => 'lng',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'mobile',
            'label' => 'mobile',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'email',
            'label' => 'email',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ],
        [
            'field' => 'about',
            'label' => 'about',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ]
    ];
}