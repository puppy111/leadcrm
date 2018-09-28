<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';


class Dashboard extends BaseController
{
    /**
     * This is default constructor of the class
     */
    public function __construct()
    {
        parent::__construct(); 
		date_default_timezone_set('Asia/Kolkata');
        $this->isLoggedIn();		
    }
    
    
    public function index()
    {
        if($this->isAdmin() == TRUE)
        {
            $this->loadThis();
        }
        else
        {    
			$data['pageTitle'] = 'BJP SC MORCHA : Dashboard';
			
			//echo '<pre>'; print_r($data); echo '</pre>'; 
			
			$this->load->view("backend/header", $data);
			$this->load->view("backend/dashboard");
			$this->load->view("backend/footer");
		}
    }
	
	
	public function db_backup()
	{
		$DBUSER=$this->db->username;
		$DBPASSWD=$this->db->password;
		$DATABASE=$this->db->database;
		
		$filename = $DATABASE . "-" . date("Y-m-d_H-i-s") . ".sql.gz";
		$mime = "application/x-gzip";
		
		header( "Content-Type: " . $mime );
		header( 'Content-Disposition: attachment; filename="' . $filename . '"' );
		
		// $cmd = "mysqldump -u $DBUSER --password=$DBPASSWD $DATABASE | gzip --best";   
		$cmd = "mysqldump -u $DBUSER --password=$DBPASSWD --no-create-info --complete-insert $DATABASE | gzip --best";
		
		passthru( $cmd );
		
		exit(0);
	}
	
	
    /**
     * This function is used to load the change password screen
     */
    function loadChangePass()
    {
        $this->global['pageTitle'] = 'IMS : Change Password';
        
        $this->loadViews("backend/changePassword", $this->global, NULL, NULL);
    }
    
    
    /**
     * This function is used to change the password of the user
     */
    function changePassword()
    {
        $this->load->library('form_validation');
		$this->load->model('user_model');
        
        $this->form_validation->set_rules('oldPassword','Old password','required|max_length[20]');
        $this->form_validation->set_rules('newPassword','New password','required|max_length[20]');
        $this->form_validation->set_rules('cNewPassword','Confirm new password','required|matches[newPassword]|max_length[20]');
        
        if($this->form_validation->run() == FALSE)
        {
            $this->loadChangePass();
        }
        else
        {
            $oldPassword = $this->input->post('oldPassword');
            $newPassword = $this->input->post('newPassword');
            
            $resultPas = $this->user_model->matchOldPassword($this->vendorId, $oldPassword);
            
            if(empty($resultPas))
            {
                $this->session->set_flashdata('nomatch', 'Your old password not correct');
                redirect('admin/loadChangePass');
            }
            else
            {
                $usersData = array('password'=>getHashedPassword($newPassword), 'updatedBy'=>$this->vendorId,
                                'updatedDtm'=>date('Y-m-d H:i:s'));
                
                $result = $this->user_model->changePassword($this->vendorId, $usersData);
                
                if($result > 0) { $this->session->set_flashdata('success', 'Password updation successful'); }
                else { $this->session->set_flashdata('error', 'Password updation failed'); }
                
                redirect('admin/loadChangePass');
            }
        }
    }
    function pageNotFound()
    {
        $this->global['pageTitle'] = 'IMS : 404 - Page Not Found';
        
        $this->loadViews("backend/404", $this->global, NULL, NULL);
    }
}