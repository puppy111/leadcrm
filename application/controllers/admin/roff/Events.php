<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Events extends BaseController 
{     
	public function __construct()     
	{         
		parent::__construct();
        $this->isLoggedIn();  
		date_default_timezone_set('Asia/Kolkata');     
		$this->load->model('events_model','events');
	}
 
    public function index()
    {
		//error_reporting(0);
		$data = array();
		$data['pageTitle'] = 'Admin : Rented Vehicle';
		$this->load->view("backend/header", $data);
        $this->load->view("backend/events_view");
		$this->load->view("backend/footer");
    }
 
    public function ajax_list()
    {
        $this->load->helper('url');
        $list = $this->events->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $events) {
            $no++;
            $row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$events->id.'">';
            $row[] = $events->title;
			$row[] = $events->date_of_event;			
			($events->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			
			
			$row[] = '
			<div class="btn-group btn-toggle">
            <button class="btn btn-sm btn-'.$on.'"  onclick="status_on('.$events->id.')">ON</button></a>
            <button class="btn btn-sm btn-'.$off.'" onclick="status_off('.$events->id.')">OFF</button></a>
            </div>';

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_block('."'".$events->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_block('."'".$events->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
         
            
			$data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->events->count_all(),
                        "recordsFiltered" => $this->events->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
	
	public function ajax_status_on($id)
    {
       $data = array(
				'status' => 1
            );
 
        $this->events->update(array('id' =>$id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
	
	public function ajax_status_off($id)
    {
        $data = array(
				'status' => 0
            );
 
        $this->events->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
 
    public function ajax_edit($id)
    {
		$data['form_data'] = $this->events->get_by_id($id);
		$this->db->from('events');
		$query1  =  $this->db->get();
		$eventss =  $query1->result_array();
		$data['events'] = $eventss;
        echo json_encode($data);
    }
 
    public function ajax_add()
    {		
		$this->_validate();
         
        $data = array(
                'title' => $this->input->post('title'),
				'date_of_event' => $this->input->post('date_of_event'),
				'description' => $this->input->post('description'),
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
            );
		
		foreach($_FILES as $k => $v)
		{
			 if(!empty($v['name']))
			 {
				 $upload = $this->_do_upload($k);
				 $data[$k] = $upload;
			 }
		}
		//echo '<pre>';print_r($_FILES);echo '</pre>';
		//echo '<pre>';print_r($data);echo '</pre>'; 
		
        $insert = $this->events->save($data);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_addform()
    {
		$this->db->from('events');
		$query1 = $this->db->get();
		$courses =  $query1->result_array();
		$data['events'] = $courses;
		$data['status'] = TRUE;
		echo json_encode($data);
        exit();
    }
 
	public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'title' => $this->input->post('title'),
				'date_of_event' => $this->input->post('date_of_event'),
				'description' => $this->input->post('description')
            );
		
		// REMOVE IMAGE ON CHECKBOX TICKMARK
		if(isset($_POST['removepics']))
		{
			//echo '<pre>';print_r($_POST['removepics']);echo '</pre>';
			foreach($_POST['removepics'] as $k=>$v)
			{
				if(file_exists('evnts/'.$v))
				{
					unlink('evnts/'.$v);
					$data[$k] = '';
				}
			}
		}
		
		foreach($_FILES as $k => $v)
		{
			 if(!empty($v['name']))
			 {
				 $upload = $this->_do_upload($k);
				 $gallery = $this->events->get_by_id($this->input->post('id'));
				 if(file_exists('evnts/'.$v['name']) && $v['name'])
				 unlink('evnts/'.$v['name']);
				 $data[$k] = $upload;
			 }
		}
		$this->events->update(array('id' => $this->input->post('id')), $data);
		//echo $this->db->last_query();
		echo json_encode(array("status" => TRUE));
    }
	
	 public function ajax_delete($id)
    {
        $events = $this->events->get_by_id($id);
		//echo '<pre>'; print_r($events); echo '</pre>';
		foreach($events as $key => $value)
		{
			if(preg_match('/^img/', $key))
			{				
				if(file_exists('evnts/'.$value) && $value)
                unlink('evnts/'.$value);
			}
		}
      
        $this->events->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_multi_delete()
	{
		 $ids = $_POST['ids'];
		 $idArr = explode(',', $ids);
		 //echo '<pre>'; print_r($idArr); echo '</pre>';
         $this->db->where_in('id',$idArr);
       	 $this->db->delete('events');
		 echo json_encode(array("status" => TRUE));
	}
	
	
	private function _do_upload($field_title)
    {
        $config['upload_path']          = 'evnts/';
        $config['allowed_types']        = 'gif|jpg|png';
        $config['max_size']             = 1024; //set max size allowed in Kilobyte
        $config['max_width']            = 1024; // set max width image allowed
        $config['max_height']           = 1024; // set max height allowed
        $config['file_name']            = round(microtime(true) * 1000); //just milisecond timestamp fot unique name
        $this->load->library('upload', $config);
				
		if(!$this->upload->do_upload($field_title)) 
		{
			$data['inputerror'][] = $field_title;
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
        $data['status'] = TRUE;
		
		if($this->input->post('title')=='')
		{
			$data['inputerror'][]   = 'title';
			$data['error_string'][] = 'Please Select a Vehicle Type';
			$data['status'] = FALSE;	
		}
		
		
		if(empty($_FILES['img1']['name']))
		{
			if($this->input->post('id'))
			{
				$this->db->select('id, img1');
				$this->db->from('events');
				$this->db->where('id', $this->input->post('id')); 
				$query = $this->db->get();
				$row   = $query->result_array();

				if($row['0']['img1'] == '')
				{
					$data['inputerror'][]   = 'img1';
					$data['error_string'][] = 'Atleast one Image is required';
					$data['status'] = FALSE;	
				}
			}
			else
			{
				$data['inputerror'][] = 'img1';
            	$data['error_string'][] = 'Atleast one Image is required';
            	$data['status'] = FALSE;
			}
		}
		
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
 
}