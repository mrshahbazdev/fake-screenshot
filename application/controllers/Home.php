<?php 
/**
 * 
 */
class Home extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model('user_model');
        $this->load->library('session');
		
	}
	public function index($page=null)
	{
		 if ($page === null) {
			 redirect('home/firstPage');
		 }else{
		if($this->session->userdata('user_id')){
        	$query = $this->db->where('name',$page)->get('pages');
		if ($query->num_rows() > 0) {
			$data['data'] = $query->row();
			$this->load->view('home', $data);	
		}
        }else{
            redirect('user/login');
        }
	}
		
	}
}