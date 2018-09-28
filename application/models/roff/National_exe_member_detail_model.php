<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class National_exe_member_detail_model extends CI_Model 
{     
var $table = 'national_exe_members_details';     
var $column_order = array('name_en',null); 
//set column field database for datatable orderable     
var $column_search = array('name_en'); 
//set column field database for datatable searchable just name_en , lastname , address are searchable     
var $order = array('sort_order' => 'asc'); // default order 
 
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
 
    private function _get_datatables_query($param)
    {
         
        $this->db->from($this->table);
		$this->db->where('category_id', $param);
 
        $i = 0;
     
        foreach ($this->column_search as $item) // loop column 
        {
            if($_POST['search']['value']) // if datatable send POST for search
            {
                 
                if($i===0) // first loop
                {
                    $this->db->group_start(); 
                    //$this->db->like($item, $_POST['search']['value']);
					$this->db->like($item, $_POST['search']['value'], 'after');
                }
                else
                {
                    //$this->db->or_like($item, $_POST['search']['value']);
					$this->db->or_like($item, $_POST['search']['value'], 'after'); 
                }
 
                if(count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }
         
        if(isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } 
        else if(isset($this->order))
        {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }
	
	
	function get_datatables($param)
	{
		$this->_get_datatables_query($param);
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered($param)
	{
		$this->_get_datatables_query($param);
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all($param)
	{
		$this->db->from($this->table);
		$this->db->where('category_id', $param);
		return $this->db->count_all_results();
	}

    public function get_by_id($id)
    {
        $this->db->from($this->table);
        $this->db->where('id',$id);
        $query = $this->db->get();
        return $query->row();
    }
 
    public function save($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }
 
    public function update($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }
 
    public function delete_by_id($id)
    {
        $this->db->where('id', $id);
        $this->db->delete($this->table);
    }

}