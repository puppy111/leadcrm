<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class General_model extends CI_Model 

{     

	var $table1 = 'banner'; 

	var $table2 = 'gallery'; 

	var $table3 = 'vehicle'; 

	var $table4 = 'places'; 

	var $table5 = 'tours'; 

	var $table6 = 'pages'; 

	var $table7 = 'vehicle_details'; 

	     

    public function get_banner()

	{

		 $this->db->from($this->table1);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	} 

	

	public function get_gallery()

	{

		 $this->db->from($this->table2);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	}

	

	public function get_tours()

	{

		 $this->db->from($this->table5);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	}

	

	public function get_places()

	{

		 $this->db->from($this->table4);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	}

	

	public function get_place_details($id)

	{

		 $this->db->from($this->table4);

		 $this->db->where_in('id',$id);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	}

	

	public function get_vehicle()

	{

		 $this->db->from($this->table3);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	} 

	

	public function get_vehicle_details($id)

	{   

		$this->db->select('

		vd.id as vehicle_listing_id,

		vd.vehicle_type as vehicle_type_id,

		vd.seater,

		vd.extra,

		vd.oil,

		vd.hours,

        vd.km,

		vd.img1,

		vd.img2,

		vd.img3,

		vd.img4,

		vd.img5,

		vd.hours,

		vd.added_on,

		vd.updated_on,

		vd.status,

		v.*');

		$this->db->from($this->table7." as vd");

		$this->db->join('vehicle as v', 'v.id = vd.vehicle_type', 'left');

		$this->db->where('v.id',$id);

	    $this->db->where('v.status', 1 );

		$query = $this->db->get();

		//echo $this->db->last_query(); 

		return $query->result_array();

	} 

	

	

	public function get_vehicle_details($id)

	{   

		$this->db->select('

		r.id as vehicle_listing_id,

		r.vehicle_type as vehicle_type_id,

		r.seater,

		r.extra,

		r.oil,

		r.hours,

        r.km,

		r.img1,

		r.img2,

		r.img3,

		r.img4,

		r.img5,

		r.hours,

		r.added_on,

		r.updated_on,

		r.status,

		v.*');

		$this->db->from($this->table7." as r");

		$this->db->join('vehicle v', 'v.id = r.vehicle_type', 'left');

		$this->db->where('r.id',$id);

	    $this->db->where('v.status', 1 );

		$query = $this->db->get();

		//echo $this->db->last_query(); 

		return $query->result_array();

	} 

	

	public function get_pages($param)

	{

		 $this->db->from($this->table6);

		 $this->db->where('status', 1 );

		 if($param !=NULL)

		 {

		 	$this->db->like('title', $param);

		 }

		 $query = $this->db->get();

		 return $query->result_array();

	} 

	

	public function get_all_count()

    {

        $sql = "SELECT COUNT(*) as tol_records FROM gallery";       

        $result = $this->db->query($sql)->row();

        return $result;

    }

    public function get_all_content($start,$content_per_page)

    {

        $sql = "SELECT * FROM  gallery LIMIT $start,$content_per_page";       

        $result = $this->db->query($sql)->result();

        return $result;

    }

	

	public function get_tours_list()

	{

		 $this->db->select('id, type, title, status');

		 $this->db->from($this->table5);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	} 

	

	public function get_tour_details($id)

	{

		 $this->db->from($this->table5);

		 $this->db->where_in('id',$id);

		 $this->db->where_in('status', 1 );

		 $query = $this->db->get();

		 return $query->result_array();

	} 

	  

	

}