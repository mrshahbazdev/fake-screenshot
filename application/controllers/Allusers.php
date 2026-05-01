<?php
class Allusers extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        $this->load->library('pagination');
    }

    public function index() {
        $config = array();
        $config['base_url'] = base_url('allusers/index');
        $config['total_rows'] = $this->User_model->get_user_count();
        $config['per_page'] = 10; // Number of items per page
        $config['uri_segment'] = 3;
        $config['num_links'] = 5;

        // Bootstrap styling for pagination
        $config['full_tag_open'] = '<nav><ul class="pagination">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li class="page-item">';
        $config['last_tag_close'] = '</li>';
        $config['active_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['active_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';
        $config['link_attributes'] = array('class' => 'page-link');

        $this->pagination->initialize($config);

        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data['users'] = $this->User_model->get_users($config['per_page'], $page);
        $data['pagination'] = $this->pagination->create_links();

        $this->load->view('users_view', $data);
    }
}
