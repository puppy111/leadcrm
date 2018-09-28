<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH . '/libraries/BaseController.php';

class Enq_leads extends BaseController 
{     
	public function __construct()     
	{         
		parent::__construct();
        $this->isLoggedIn();  
		date_default_timezone_set('Asia/Kolkata');     
		$this->load->model('Enq_leads_model','company_leads');
	}
    
    public function index($param = '')
    {
		//error_reporting(0);
		$data = array();
		$data['pageTitle'] = 'Admin : HOME PAGE SLIDER';
		$data['category_id'] = $param;
		$this->load->view("backend/header", $data);
        $this->load->view("backend/enq_leads");
		$this->load->view("backend/footer");
    }
 
    public function ajax_list($param)
    {
        $this->load->helper('url');
        $list = $this->company_leads->get_datatables($param);
        $data = array();
        $no = $_POST['start'];
		
        foreach ($list as $company_leads) {
            $no++;
            $row = array();
			$row[] = '<input name="checkbox[]" class="checkbox1" type="checkbox" id="checkbox[]" value="'.$company_leads->id.'">';
            //$row[] = $no;
			$row[] = $company_leads->name;
			$row[] = $company_leads->phone;
			$row[] = $company_leads->subject;
			$row[] = $company_leads->added_on;
			
			($company_leads->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			
			
			($company_leads->status == 1) ? ($on  = 'success' AND $off  = 'default') : ($on  = 'default' AND $off  = 'danger');
			$row[] = '
			<div class="btn-group btn-toggle">
            <button class="btn btn-sm btn-'.$on.'"  onclick="status_on('.$company_leads->id.')">ON</button></a>
            <button class="btn btn-sm btn-'.$off.'" onclick="status_off('.$company_leads->id.')">OFF</button></a>
            </div>';

            //add html for action
            $row[] = '<a class="btn btn-sm btn-primary" href="javascript:void(0)" title="Edit" onclick="edit_block('."'".$company_leads->id."'".')"><i class="glyphicon glyphicon-pencil"></i></a>
                  <a class="btn btn-sm btn-danger" href="javascript:void(0)" title="Hapus" onclick="delete_block('."'".$company_leads->id."'".')"><i class="glyphicon glyphicon-trash"></i></a>';
         
            $data[] = $row;
			
        }
 
        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->company_leads->count_all($param),
                        "recordsFiltered" => $this->company_leads->count_filtered($param),
                        "data" => $data,
                );
        //output to json format
        echo json_encode($output);
    }
 
    public function ajax_edit($id)
    {
        $data['form_data'] = $this->company_leads->get_by_id($id);
		
		$this->db->select('DISTINCT(state_id),state_name');
		$this->db->from('cities');
		$this->db->order_by("state_name", "asc"); 
		$query1 = $this->db->get();
		$cities =  $query1->result_array();
		$data['state'] = $cities;
		
		$data['status'] = TRUE;
		//echo '<pre>'; print_r($data); echo '</pre>'; 
        echo json_encode($data);
    }
	
	
	public function ajax_addform()
    {
		$this->db->select('DISTINCT(state_id),state_name');
		$this->db->from('cities');
		$this->db->order_by("state_name", "asc"); 

		$query1 = $this->db->get();
		$cities =  $query1->result_array();
		$data['state'] = $cities;
		
		
        $data['status'] = TRUE;
		echo json_encode($data);
        exit();
    }
	
	public function ajax_status_on($id)
    {
       $data = array(
				'status' => 1
            );
 
        $this->company_leads->update(array('id' =>$id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
	
	public function ajax_status_off($id)
    {
        $data = array(
				'status' => 0
            );
 
        $this->company_leads->update(array('id' => $id), $data);
		echo json_encode(array("status" => TRUE));
        
    }
 
    public function ajax_add()
    {
        $this->_validate();
         
        $data = array(
				'project_id' => $this->input->post('project_id'),
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'state' => $this->input->post('state'),
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message'),
				'source' => $this->input->post('source'),
				'added_on' => date('Y-m-d H:i:s'),
				'status' => 1
            );
			
        $insert = $this->company_leads->save($data);
 
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_update()
    {
        $this->_validate();
        $data = array(
                'project_id' => $this->input->post('project_id'),
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'state' => $this->input->post('state'),
				'subject' => $this->input->post('subject'),
				'message' => $this->input->post('message'),
				'source' => $this->input->post('source'),
            );
 
        $this->company_leads->update(array('id' => $this->input->post('id')), $data);
        echo json_encode(array("status" => TRUE));
    }
 
    public function ajax_delete($id)
    {
        $this->company_leads->delete_by_id($id);
        echo json_encode(array("status" => TRUE));
    }
	
	public function ajax_multi_delete()
	{
		 
		 $ids = $_POST['ids'];
		 $idArr = explode(',', $ids);
		 
		 
		 $this->db->from('company_leads');
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
		
		/*if(!preg_match("/^(?!\s*$)[a-zA-Z0-9!\s]{1,200}$/",$this->input->post('name_en'))) 
		{
			$data['inputerror'][] = 'name_en';
            $data['error_string'][] = 'Please Type Valid Title';
            $data['status'] = FALSE;
		}
		else
		{
			if($this->input->post('id'))
			{
				$this->db->where(array('id !='=> $this->input->post('id')));
			}
			$this->db->where('name_en',$this->input->post('name_en'));
			$query = $this->db->get('company_leads');
			//echo $this->db->last_query();
			
			if($query->num_rows() > 0)
			{
				$data['inputerror'][]   = 'name_en';
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