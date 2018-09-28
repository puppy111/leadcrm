<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Auth extends CI_Controller
{     
	public function __construct()     
	{         
		parent::__construct();  
		date_default_timezone_set('Asia/Kolkata');     
	}
 
    public function index()
    {
		$this->load->view("frontend/index");
    }
	
	public function login()
    {
		$this->load->view("frontend/login");
    }
	
	public function register()
    {
		$reg_email = $this->input->post('email');
		
		$hash = password_hash($reg_hash, PASSWORD_BCRYPT);


		
		if ($this->form_validation->run() == FALSE)
		{
			$this->load->view("frontend/register");
		}
		else
		{
			$this->load->view("frontend/register");
		}
		
		
    }
	
	
}