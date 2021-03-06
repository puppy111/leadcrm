<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Projects extends BaseController 
{     
	public function __construct()     
	{         
		parent::__construct();
        $this->isLoggedIn();  
		date_default_timezone_set('Asia/Kolkata');     
		$this->load->model('projects_model','projects');
	}
 
    public function index()
    {
		//error_reporting(0);
		$data = array();
		$data['pageTitle'] = 'Admin : HOME PAGE projects';
		$this->load->view("backend/header", $data);
        $this->load->view("backend/projects_view");
		$this->load->view("backend/footer");
    }
 
    public function ajax_list()
    {
        $this->load->helper('url');
        $list = $this->projects->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $projects) {
            $no++;
            $row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$projects->id.'">';
			$row[] = $projects->company_name;
            $row[] = $projects->title;
			$row[] = $projects->lead_name;
			
            if($projects->photo)
                $row[] = '<a href="'.base_url('projects/'.$projects->photo).'" target="_blank">
				<img width="100" height="100" src="'.base_url('projects/'.$projects->photo).'" class="img-responsive" /></a>';
            else
                $row[] = '(No photo)';
				
			//$row[] = $projects->added_on;
			$row[] = $projects->updated_on;
			
			($projects->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			
			
			$row[] = '
			<div class="btn-group btn-toggle">
            <button class="btn btn-sm btn-'.$on.'"  onclick="status_on('.$projects->id.')">ON</button></a>
            <button class="btn btn-sm btn-'.$off.'" onclick="status_off('.$projects->id.')">OFF</button></a>
            </div>';

 
            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_block('."'".$projects->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_block('."'".$projects->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
				  
			
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->projects->count_all(),
                        "recordsFiltered" => $this->projects->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
     public function ajax_edit($id)
    {
		$data['form_data'] = $this->projects->get_by_id($id);
		$this->db->from('companies');
		$query1  =  $this->db->get();
		$vehicles =  $query1->result_array();
		$data['company_arry'] = $vehicles;
        echo json_encode($data);
    }
	
	public function ajax_addform()
    {
		$this->db->from('companies');
		$query1 = $this->db->get();
		$courses =  $query1->result_array();
		$data['company_arry'] = $courses;
		$data['status'] = TRUE;
		echo json_encode($data);
        exit();
    }
 
	
	public function ajax_status_on($id)
    {
       $data = array(
				'status' => 1
            );
 
        $this->projects->update(array('id' =>$id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
	
	public function ajax_status_off($id)
    {
        $data = array(
				'status' => 0
            );
 
        $this->projects->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
 
    public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
		        'company_id' => $this->input->post('company_type'),
                'title' => $this->input->post('title'),
				'lead_name' => $this->input->post('lead_name'),
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
            );
 
        if(!empty($_FILES['photo']['name']))
        {
            $upload = $this->_do_upload();
            $data['photo'] = $upload;
        }
 
        $insert = $this->projects->save($data);
 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
		        'company_id' => $this->input->post('company_type'),
                'title' => $this->input->post('title'),
				'lead_name' => $this->input->post('lead_name')
            );
 
        if($this->input->post('remove_photo')) // if remove photo checked
        {
            if(file_exists('projects/'.$this->input->post('remove_photo')) && $this->input->post('remove_photo'))
                unlink('projects/'.$this->input->post('remove_photo'));
            $data['photo'] = '';
        }
 
        if(!empty($_FILES['photo']['name']))
        {
            $upload = $this->_do_upload();
             
            //delete file
            $projects = $this->projects->get_by_id($this->input->post('id'));
            if(file_exists('projects/'.$projects->photo) && $projects->photo)
                unlink('projects/'.$projects->photo);
 
            $data['photo'] = $upload;
        }
 
        $this->projects->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        //delete file
        $projects = $this->projects->get_by_id($id);
        if(file_exists('projects/'.$projects->photo) && $projects->photo)
            unlink('projects/'.$projects->photo);
         
        $this->projects->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_multi_delete()
	{
		 $ids = $_POST['ids'];
		 $idArr = explode(',', $ids);
		 
		 
		 $this->db->from('projects');
		 $this->db->where_in('id',$idArr);
		 $query = $this->db->get();
		 $row   = $query->result();
       	 //echo '<pre>'; print_r($row); echo '</pre>';
			
		 foreach($row as $k=>$v)
		 {
		    if(file_exists('projects/'.$v->photo) && $v->photo)
			{
            	unlink('projects/'.$v->photo);
			}
			$this->projects->delete_by_id($v->id);
			
		 }
		 echo json_encode(array("status" => TRUE));
	}
 
    private function _do_upload()
    {
        $config['upload_path']          = 'projects/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg|JPG';
        $config['max_size']             = 1024; //set max size allowed in Kilobyte
        //$config['max_width']          = 1024; // set max width image allowed
        //$config['max_height']         = 1024; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
 
        $this->load->library('upload', $config);
 
        if(!$this->upload->do_upload('photo')) //upload and validate
        {
            $data['inputerror'][] = 'photo';
            $data['error_string'][] = 'Upload error: '.$this->upload->display_errors('',''); //show ajax error
            $data['status'] = FALSE;
            echo json_encode($data);
            exit();
        }
        return $this->upload->data('file_name');
    }
 
    private function _validate()
    {
       
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = NULL;
		
		//alias ^(?!\s*$)[-a-zA-Z0-9_:,.\s]{1,100}$
		
		/*if(!preg_match("/^(?!\s*$)[a-zA-Z0-9!\s]{1,200}$/",$this->input->post('title'))) 
		{
			$data['inputerror'][] = 'title';
            $data['error_string'][] = 'Please Type Valid Title';
            $data['status'] = FALSE;
		}
		else
		{
			if($this->input->post('id'))
			{
				$this->db->where(array('id !='=> $this->input->post('id')));
			}
			$this->db->where('title',$this->input->post('title'));
			$query = $this->db->get('projects');
			//echo $this->db->last_query();
			
			if($query->num_rows() > 0)
			{
				$data['inputerror'][]   = 'title';
				$data['error_string'][] = 'This Title Already Exists';
				$data['status'] = FALSE;	
			}
		}*/
		
		
		
		/*if(empty($_FILES['photo']['name']))
		{
			if($this->input->post('id'))
			{
				$this->db->select('id, photo');
				$this->db->from('projects');
				$this->db->where('id', $this->input->post('id')); 
				$query = $this->db->get();
				$row   = $query->result_array();
				//echo '<pre>'; print_r($row);echo '</pre>';

				if($row['0']['photo'] == '')
				{
					$data['inputerror'][]   = 'photo';
					$data['error_string'][] = 'Image is required';
					$data['status'] = FALSE;	
				}
			}
			else
			{
				$data['inputerror'][] = 'photo';
            	$data['error_string'][] = 'Image is required';
            	$data['status'] = FALSE;
			}
		}
		*/
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}