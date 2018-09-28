<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
header("Access-Control-Allow-Origin: *");


class Welcome extends CI_Controller
{     
	public function __construct()     
	{         
		parent::__construct();  
		error_reporting(0);
		date_default_timezone_set('Asia/Kolkata');  
		$this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
		$this->load->model('Enq_leads_model','company_leads');
	}
 
    public function index()
    {
	    $title['page_title']       = 'Leads';
		$result = array();
		
		if($_POST['action'] == 'send_email')
		{
		    
			$this->_validate();
			$data = array(
					'project_id' => $this->input->post('project_id'),
					'name' => $this->input->post('name'),
					'email' => $this->input->post('email'),
					'phone' => $this->input->post('phone'),
					'subject' => $this->input->post('subject'),
					'message' => $this->input->post('message'),
					'source' => $this->input->post('source'),
					/*'state' => $this->input->post('state'),*/
					'added_on' => date('Y-m-d H:i:s')
				);
			
			
			
			$insert = $this->db->insert('leads', $data); //print_r($insert);
			if($insert == 1)
			{
				$msg = array('status' => 1, 'msg' =>'Success');   
				echo json_encode($msg);	
				//print_r('====');
				exit;
			}
			else
			{
				$msg = array('status' => 0, 'msg' =>'Failed');   
				echo json_encode($msg);	
				//print_r('=eee=');
				exit;
			}
		}
		else
		{
			    $msg = array('status' => 0, 'msg' =>'Failed');   
				echo json_encode($msg);	
				exit;
		}
    }

		
	private function _validate()
    {
       
        $data = array();
        $data['error_string'] = array();
        $data['status'] = NULL;
		
		if($this->input->post('name') == '')
        {
            $data['error_string']['name'] = 'Please Enter Name';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('email') == '')
        {
            $data['error_string']['email'] = 'Please Enter ID';
            $data['status'] = FALSE;
        }
		
        if($this->input->post('phone') == '')
        {
            $data['error_string']['phone'] = 'Phone No. is required';
            $data['status'] = FALSE;
        }
		
		/*if($this->input->post('subject') == '')
        {
            $data['error_string']['subject'] = 'Subject is required';
            $data['status'] = FALSE;
        }*/
		
		if($this->input->post('message') == '')
        {
            $data['error_string']['message'] = 'Message is required';
            $data['status'] = FALSE;
        }
		
		if($this->input->post('project_id') == '')
        {
            $data['error_string']['project_id'] = 'Please Select a Service';
            $data['status'] = FALSE;
        }
		
		/*if($this->input->post('state') == '')
        {
            $data['error_string']['state'] = 'State is required';
            $data['status'] = FALSE;
        }
		*/
		
		
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}