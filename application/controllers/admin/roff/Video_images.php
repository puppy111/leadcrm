<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Video_images extends BaseController 
{     
	public function __construct()     
	{         
		parent::__construct();
        $this->isLoggedIn();  
		date_default_timezone_set('Asia/Kolkata');     
		$this->load->model('video_image_model','video_images');
	}
    
    public function index($param = '')
    {
		//error_reporting(0);
		$data = array();
		$data['pageTitle'] = 'Admin : HOME PAGE SLIDER';
		$data['title_id'] = $param;
		$this->load->view("backend/header", $data);
        $this->load->view("backend/video_images");
		$this->load->view("backend/footer");
    }
 
    public function ajax_list($param)
    {
        $this->load->helper('url');
        $list = $this->video_images->get_datatables($param);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $video_images) {
            $no++;
            $row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$video_images->id.'">';
			$end_url = explode("?v=",$video_images->video_url);
			$row[] = '<img src="https://i.ytimg.com/vi/'.end($end_url).'/mqdefault.jpg" width="100px" height="50px">';	
			
			$row[] = $video_images->updated_on;
			
			($video_images->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			
			
			($video_images->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			$row[] = '
			<div class="btn-group btn-toggle">
            <button class="btn btn-sm btn-'.$on.'"  onclick="status_on('.$video_images->id.')">ON</button></a>
            <button class="btn btn-sm btn-'.$off.'" onclick="status_off('.$video_images->id.')">OFF</button></a>
            </div>';

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_block('."'".$video_images->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_block('."'".$video_images->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->video_images->count_all($param),
                        "recordsFiltered" => $this->video_images->count_filtered($param),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data['form_data'] = $this->video_images->get_by_id($id);
		$data['status'] = TRUE;
        echo json_encode($data);
    }
	
	
	public function ajax_addform()
    {
        $data['status'] = TRUE;
		echo json_encode($data);
        exit();
    }
	
	public function ajax_status_on($id)
    {
       $data = array(
				'status' => 1
            );
 
        $this->video_images->update(array('id' =>$id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
	
	public function ajax_status_off($id)
    {
        $data = array(
				'status' => 0
            );
 
        $this->video_images->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
 
    public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
				'title_id' => $this->input->post('title_id'),
				'video_url' => $this->input->post('video_url'),
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
            );
       
        $insert = $this->video_images->save($data);
 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
 
		$data = array(
		'title_id' => $this->input->post('title_id'),
		'video_url' => $this->input->post('video_url'),
		);
			
        $this->video_images->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        //delete file
        $video_images = $this->video_images->get_by_id($id);
        $this->video_images->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_multi_delete()
	{
		 $ids = $_POST['ids'];
		 $idArr = explode(',', $ids);
		 
		 
		 $this->db->from('video_images');
		 $this->db->where_in('id',$idArr);
		 $query = $this->db->get();
		 $row   = $query->result();
       	 //echo '<pre>'; print_r($row); echo '</pre>';
		 echo json_encode(array("status" => TRUE));
	}
 
 
    private function _validate()
    {
       
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
        $data['status'] = NULL;
		
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}