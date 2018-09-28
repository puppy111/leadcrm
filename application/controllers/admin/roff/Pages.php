<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Pages extends BaseController 
{     
	public function __construct()     
	{         
		parent::__construct();
        $this->isLoggedIn();  
		date_default_timezone_set('Asia/Kolkata');     
		$this->load->model('pages_model','pages');
	}
 
    public function index()
    {
		//error_reporting(0);
		$data = array();
		$data['pageTitle'] = 'IMS : PAGES';
		$this->load->view("backend/header", $data);
        $this->load->view("backend/pages_view");
		$this->load->view("backend/footer");
    }
 
    public function ajax_list()
    {
        $this->load->helper('url');
        $list = $this->pages->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $pages) {
            $no++;
            $row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$pages->id.'">';
            $row[] = $pages->title;
			$row[] = substr($pages->description, 0, 150);
			$row[] = $pages->added_on;
			$row[] = $pages->updated_on;
			//$row[] = $pages->status;
			
			($pages->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			
			
			$row[] = '
			<div class="btn-group btn-toggle id=toggle">
            <button class="btn btn-sm btn-'.$on.'"  onclick="status_on('.$pages->id.')">ON</button></a>
            <button class="btn btn-sm btn-'.$off.'" onclick="status_off('.$pages->id.')">OFF</button></a>
            </div>';

            
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_block('."'".$pages->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_block('."'".$pages->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->pages->count_all(),
                        "recordsFiltered" => $this->pages->count_filtered(),
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
 
        $this->pages->update(array('id' =>$id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
	
	public function ajax_status_off($id)
    {
        $data = array(
				'status' => 0
            );
 
        $this->pages->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
 
    public function ajax_edit($id)
    {
        $data['form_data'] = $this->pages->get_by_id($id);
        echo json_encode($data);
    }
	
    public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
                'title' => $this->input->post('title'),
				'description' => $this->input->post('description'),
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
            );
        $insert = $this->pages->save($data);
 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'title' => $this->input->post('title'),
				'description' => $this->input->post('description')
	            );
 
        $this->pages->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->pages->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_multi_delete()
	{
		 $ids = $_POST['ids'];
		 $idArr = explode(',', $ids);
		 //echo '<pre>'; print_r($idArr); echo '</pre>';
         $this->db->where_in('id',$idArr);
       	 $this->db->delete('pages');
		 echo json_encode(array("status" => TRUE));
	}
  
    private function _validate()
    {
        $data = array();
        $data['error_string'] = array();
        $data['inputerror'] = array();
		$data['txtarea_inputerror'][]= array();
		$data['txtarea_error_string'][]= array();
        $data['status'] = NULL;
		
		//alias ^(?!\s*$)[-a-zA-Z0-9_:,.\s]{1,100}$
		
		if(!preg_match("/^(?!\s*$)[a-zA-Z0-9\s]{1,100}$/",$this->input->post('title'))) 
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
			$query = $this->db->get('pages');
			//echo $this->db->last_query();
			
			if($query->num_rows() > 0)
			{
				$data['inputerror'][]   = 'title';
				$data['error_string'][] = 'This Page Already Exists';
				$data['status'] = FALSE;	
			}
		}
		
		
		if($this->input->post('description') == '')
        {
            $data['txtarea_inputerror'][] = 'description';
            $data['txtarea_error_string'][] = 'Description is required';
			
			$data['inputerror'][] = 'description';
            $data['error_string'][] = 'description is required';
			
            $data['status'] = FALSE;
        }
		
		
		
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}