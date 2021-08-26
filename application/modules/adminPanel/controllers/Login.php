<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $auth = $this->session->auth;
        if ($auth) 
            return redirect(admin());

        $this->load->model('main_model', 'main');
    }

	protected $table = 'admin';
	
    protected $login = [
        [
            'field' => 'mobile',
            'label' => 'Mobile No.',
            'rules' => 'required|numeric|exact_length[10]',
            'errors' => [
                'required' => "%s is Required",
                'numeric' => "%s is Invalid",
                'exact_length' => "%s is Invalid",
            ],
        ],
        [
            'field' => 'password',
            'label' => 'Password',
            'rules' => 'required',
            'errors' => [
                'required' => "%s is Required"
            ],
        ]
    ];

	public function index()
    {
        if (!$this->input->is_ajax_request()) {
    	    $data['title'] = 'login';
    		return $this->template->load('auth/template', 'auth/login', $data);
        }else{
    	    $this->form_validation->set_rules($this->login);
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
                $post = [
                    'mobile'   => $this->input->post('mobile'),
                    'password' => my_crypt($this->input->post('password'))
                ];
                
                $user = $this->main->get($this->table, 'id auth', $post);
                
                if ($user) {
                    $this->session->set_userdata($user);
                    $response = [
                        'message' => "Login Successfull.",
                        'status' => true,
                        'redirect' => base_url(admin())
                    ];
                }else{
                    $response = [
                        'message' => "Invalid credentials.",
                        'status' => false
                    ];
                }
            }
            echo json_encode($response);
        }
    }

    public function forgot_password()
    {
        if (!$this->input->is_ajax_request()) {
            $data['title'] = 'forgot password';
            return $this->template->load('auth/template', 'auth/forgot_password', $data);
        }else{
            $forgot = [
                    [
                        'field' => 'mobile',
                        'label' => 'Email OR Mobile No.',
                        'rules' => 'required',
                        'errors' => [
                            'required' => "%s"
                        ],
                    ]
                ];

            $this->form_validation->set_rules($forgot);
            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
                $mobile = $this->input->post('mobile');
                $user = $this->main->get($this->table, 'mobile', "role != 'User' AND (email = '$mobile' OR mobile = '$mobile')");

                if ($user) {
                    $this->session->set_userdata($user);

                    $otp =  rand(1000, 9999);
                    if ($this->main->update($user, ['otp' => $otp, 'last_update' => date('Y-m-d H:i:s')], $this->table)){
                        /*$message = "Yor OTP for password reset - $otp";
                        send_sms($user['mobile'], $message);*/
                        $response = [
                            'message' => 'OTP Sent Successfull.',
                            'status' => true,
                            'redirect' => base_url(admin('checkOtp'))
                        ];
                    }else
                        $response = [
                            'message' => 'OTP not sent. Please try again.',
                            'status' => true,
                            'redirect' => false
                        ];
                }else{
                    $response = [
                        'message' => 'Mobile OR Email not registered.',
                        'status' => false
                    ];
                }
            }
            echo json_encode($response);
        }
    }

    public function checkOtp()
    {
        if (!$this->input->is_ajax_request()) {
            if (!$this->session->mobile): return redirect(admin('forgot-password')); endif;
            $data['title'] = 'OTP Verify';
            return $this->template->load('auth/template', 'auth/check_otp', $data);
        }else{
            $this->form_validation->set_rules('otp', 'OTP', 'required', ['required' => "%s is Required"]);

            if ($this->form_validation->run() == FALSE)
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            else{
                $post = [
                    'mobile'          => $this->session->mobile,
                    'otp'             => $this->input->post('otp'),
                    'last_update >= ' => date('Y-m-d H:i:s', strtotime('-5 minutes'))
                ];

                $user = $this->main->check($this->table, $post, 'id');
                
                if ($user) {
                    $this->session->set_userdata('adminId', $user);
                    $response = [
                            'message' => 'OTP match. Change your password.',
                            'status' => true,
                            'redirect' => base_url(admin('changePassword'))
                        ];
                }else{
                    $response = [
                        'message' => 'OTP not match. Please try again.',
                        'status' => false
                    ];
                }
            }
            echo json_encode($response);
        }
    }

    public function changePassword()
    {
        if (!$this->input->is_ajax_request()) {
            if (empty($this->session->adminId)): return redirect(admin('login')); endif;

            $data['title'] = 'Change Password';
            return $this->template->load('auth/template', 'auth/change_password', $data);
        }else{
            $this->form_validation->set_rules('password', 'Password', 'required', ['required' => "%s is Required"]);
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|matches[password]', ['required' => "%s is Required", 'matches' => "%s is Differ than Password"]);

            if ($this->form_validation->run() == FALSE) {
                $response = [
                    'message' => "Some required fields are missing.",
                    'status' => false
                ];
            }else{
                $post = ['password' => my_crypt($this->input->post('password'))];
                
                if ($this->main->update(['id' => $this->session->adminId], $post, $this->table)) {
                    $response = [
                        'message' => 'Password changed. Login with new password.',
                        'status' => true,
                        'redirect' => base_url(admin('login'))
                    ];
                    session_destroy();
                }else{
                    $response = [
                        'message' => 'Password not changed. Please try again.',
                        'status' => false
                    ];
                }
            }
            echo json_encode($response);
        }
    }
}
