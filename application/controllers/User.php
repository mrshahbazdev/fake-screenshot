<?php
class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        $this->load->library('session');
        $this->load->library('form_validation');
    }

    public function register() {
        $this->load->view('register');
    }

    public function do_register() {
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $email = $this->input->post('email');

        // Register user and get the user ID
        $user_id = $this->user_model->register_user($username, $password, $email);

        if ($user_id) {
            // Set user ID in session
            $this->session->set_userdata('user_id', $user_id);
            // Redirect to subscription or login
            $this->session->set_flashdata('success', 'Registration successful! Now activate your subscription.');
            redirect('user/subscribe');
        } else {
            $this->session->set_flashdata('error', 'Registration failed.');
            redirect('user/register');
        }
    }

    public function subscribe() {
        if($this->session->userdata('user_id')){
        $this->load->view('subscribe');
        }else{
            redirect('user/register');
        }
    }

    public function do_subscribe() {
    $user_id = $this->session->userdata('user_id'); // Make sure this is correctly set
    $days = $this->input->post('days');
    echo $user_id;
    // Check if user_id is set and valid
    if ($user_id) {
        $this->user_model->activate_subscription($user_id, $days);
        $this->session->set_flashdata('success', 'Subscription activated!');
        redirect('user/login');
    } else {
        $this->session->set_flashdata('error', 'User ID not found.');
        redirect('user/subscribe');
    }
}

    public function login() {
        $this->load->view('login');
    }

    public function do_login() {
    $username = $this->input->post('username');
    $password = $this->input->post('password');
    
    $user = $this->user_model->get_user_by_username($username);
    
    if ($user && password_verify($password, $user['password'])) {
        if ($user['subscription_status'] == 'active' && strtotime($user['subscription_end']) > time()) {
            $this->session->set_userdata('user_id', $user['id']); // Ensure this is set
            redirect('home/firstPage');
        } else {
            $this->session->set_flashdata('error', 'Your subscription has expired.');
            redirect('user/login');
        }
    } else {
        $this->session->set_flashdata('error', 'Invalid username or password.');
        redirect('user/login');
    }
}

    public function logout() {
        $this->session->sess_destroy();
        redirect('user/login');
    }
}
