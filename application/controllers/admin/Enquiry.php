<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Enquiry extends BaseController 
{     
	public function __construct()     
	{         
		parent::__construct();
        $this->isLoggedIn();  
		date_default_timezone_set('Asia/Kolkata');   
		$this->load->model('companies_model','companies');  
	}
 
    public function index()
    {
		//error_reporting(0);
		$data = array();
		$data['pageTitle'] = 'Admin : HOME PAGE SLIDER';
		$this->load->view("backend/header", $data);
        $this->load->view("backend/enquiry_form1");
		$this->load->view("backend/footer");
    }
 
    public function ajax_list()
    {
        $this->load->helper('url');
        $list = $this->companies->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $companies) {
            $no++;
            $row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$companies->id.'">';
            $row[] = '<a href="'.base_url().'admin/enq_projects/'.$companies->id.''.'">'.$companies->title.'</a>';
			$row[] = $companies->lead_name;
			
             if($companies->photo)
                $row[] = '<a href="'.base_url('company/'.$companies->photo).'" target="_blank">
				<img width="100" height="100" src="'.base_url('company/'.$companies->photo).'" class="img-responsive" /></a>';
            else
                $row[] = '(No photo)';
				
				
			$row[] = $companies->updated_on;
			($companies->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			$row[] = '
			<div class="btn-group btn-toggle">
            <button class="btn btn-sm btn-'.$on.'"  onclick="status_on('.$companies->id.')">ON</button></a>
            <button class="btn btn-sm btn-'.$off.'" onclick="status_off('.$companies->id.')">OFF</button></a>
            </div>';

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_block('."'".$companies->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_block('."'".$companies->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
         
            $data[] = $row;
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->companies->count_all(),
                        "recordsFiltered" => $this->companies->count_filtered(),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data['form_data'] = $this->companies->get_by_id($id);
		
		$this->db->from('companies');
		$query1   = $this->db->get();
		$sub_cats =  $query1->result_array();
		$data['title_en'] = $sub_cats;
		
		$data['status'] = TRUE;
		//echo '<pre>'; print_r($data); echo '</pre>'; 
        echo json_encode($data);
    }
	
	
	public function ajax_addform()
    {
		$this->db->from('companies');
		$query1 = $this->db->get();
		$sub_cats =  $query1->result_array();
		$data['title_en'] = $sub_cats;
		
		
        $data['status'] = TRUE;
		echo json_encode($data);
        exit();
    }
	
	public function ajax_status_on($id)
    {
       $data = array(
				'status' => 1
            );
 
        $this->companies->update(array('id' =>$id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
	
	public function ajax_status_off($id)
    {
        $data = array(
				'status' => 0
            );
 
        $this->companies->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
 
    public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
                'title_en' => $this->input->post('title_en'),
				'title_hi' => $this->input->post('title_hi'),
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
            );
 
        $insert = $this->companies->save($data);
 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'title_en' => $this->input->post('title_en'),
				'title_hi' => $this->input->post('title_hi')
            );
 
        $this->companies->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        //delete file        
        $this->companies->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_multi_delete()
	{
		 $ids = $_POST['ids'];
		 $idArr = explode(',', $ids);
		 
		 
		 $this->db->from('companies');
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
		
		//alias ^(?!\s*$)[-a-zA-Z0-9_:,.\s]{1,100}$
		
		/*if(!preg_match("/^(?!\s*$)[a-zA-Z0-9!\s]{1,200}$/",$this->input->post('title_en'))) 
		{
			$data['inputerror'][] = 'title_en';
            $data['error_string'][] = 'Please Type Valid Title';
            $data['status'] = FALSE;
		}
		else
		{
			if($this->input->post('id'))
			{
				$this->db->where(array('id !='=> $this->input->post('id')));
			}
			$this->db->where('title_en',$this->input->post('title_en'));
			$query = $this->db->get('companies');
			//echo $this->db->last_query();
			
			if($query->num_rows() > 0)
			{
				$data['inputerror'][]   = 'title_en';
				$data['error_string'][] = 'This Title Already Exists';
				$data['status'] = FALSE;	
			}
		}*/
		
		
        if($data['status'] === FALSE)
        {
            echo json_encode($data);
            exit();
        }
    }
}