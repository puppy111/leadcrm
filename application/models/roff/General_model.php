<?php defined('BASEPATH') OR exit('No direct script access allowed'); 

class General_model extends CI_Model 
{     
	var $table1 = 'slider'; 
	//var $table2 = 'gallery'; 
	var $table2 = 'gallery_titles'; 
	var $table3 = 'events'; 
	var $table4 = 'news'; 
	var $table6 = 'pages'; 
	var $table7 = 'video_titles'; 
	var $table8 = 'national_main_members_category';
	var $table9 = 'national_exe_members_category';

	public function get_main_members_category()
	{
		$this->db->from($this->table8);
		 $this->db->where_in('status', 1 );
		 $query = $this->db->get();
		 return $query->result_array();
	} 
	
	public function get_main_members_details()
	{
		$this->db->from('national_main_members_details');
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("sort_order","asc");
		 $query = $this->db->get();
		 return $query->result_array();
	} 
	
	public function get_exe_members_category()
	{
		$this->db->from($this->table9);
		 $this->db->where_in('status', 1 );
		 $query = $this->db->get();
		 return $query->result_array();
	} 
	
	public function get_exe_members_details()
	{
		 $this->db->from('national_exe_members_details');
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("sort_order","asc");
		 $query = $this->db->get();
		 return $query->result_array();
	} 
	
	
	/*public function get_main_members()
	{
		$this->db->select('
		mmc.id as mm_id,
		mmc.title_en,
		mmc.title_hi,
		mmd.*
		');
		 $this->db->from($this->table8." as mmc");
		 $this->db->join('national_main_members_details mmd', 'mmd.category_id = mmc.id', 'left');
		 $this->db->where_in('mmd.status', 1 );
		 $query = $this->db->get();
		 return $query->result_array();
	} */
	
	public function get_exe_members()
	{
		 $this->db->from($this->table9);
		 $this->db->where_in('status', 1 );
		 $query = $this->db->get();
		 return $query->result_array();
	} 
	     
    public function get_banner()
	{
		 $this->db->from($this->table1);
		 $this->db->where_in('status', 1 );
		 $query = $this->db->get();
		 return $query->result_array();
	} 

	public function get_amit_video()
	{
		 $this->db->from($this->table7);
		 $this->db->where_in('category_id', 1 );
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6);  
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	public function get_pm_video()
	{
		 $this->db->from($this->table7);
		 $this->db->where_in('category_id', 2 );
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6);  
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	public function get_sc_video()
	{
		 $this->db->from($this->table7);
		 $this->db->where_in('category_id', 3 );
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6);  
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	
	public function get_amit_gallery()
	{
		 $this->db->from($this->table2);
		 $this->db->where_in('category_id', 2 );
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6);  
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	public function get_pm_gallery()
	{
		 $this->db->from($this->table2);
		 $this->db->where_in('category_id', 1 );
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6);  
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	
	public function get_sc_gallery()
	{
		 $this->db->from($this->table2);
		 $this->db->where_in('category_id', 3 );
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6);  
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
		
	public function get_events()
	{
		 $this->db->from($this->table3);
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 //$this->db->limit(1); 
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	public function get_news()
	{
		 $this->db->from($this->table4);
		 $this->db->where_in('status', 1 );
		 $this->db->order_by("id", "desc");
		 $this->db->limit(6); 
		 $query = $this->db->get();
		 return $query->result_array();
	}
	
	
	/*	
	public function get_gallery()
	{
		 $this->db->from($this->table2);
		 $this->db->where_in('status', 1 );
		 $query = $this->db->get();
		 return $query->result_array();
	}*/
	
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
	
	
	
	/******************NEWS***********************************/
	
	public function news_count() 
	{
		$this->db->select('*');
		$this->db->from('news');
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->num_rows();
    }
	
	public function news_details() 
	{
		//echo $start; exit;
		$this->db->limit($limit, $start);
		//$this->db->where('user_id',$param3);
		$this->db->order_by('id','desc');
		$query = $this->db->get("news");
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;	
    }
	
	
	/******************NEWS ENDS***********************************/
	
	/******************VIDEO ENDS***********************************/	
	public function video_count() 
	{
        //return $this->db->count_all("listing");
		$this->db->select('*');
		$this->db->from('video_titles');
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->num_rows();
    }
	
	public function video_gallery($limit,$start) 
	{
		//echo $start; exit;
		$this->db->limit($limit, $start);
		//$this->db->where('user_id',$param3);
		$this->db->order_by('id','desc');
		$query = $this->db->get("video_titles");
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;		
	}
	
	
	public function video_title_count($photo_category) 
	{
        //return $this->db->count_all("listing");
		$this->db->select('*');
		$this->db->from('video_titles');
		$this->db->where('category_id',$photo_category);
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->num_rows();
    }
	
	public function video_titles($limit,$start,$photo_category) 
	{
		//echo $start; exit;
		$this->db->limit($limit, $start);
		$this->db->where('category_id',$photo_category);
		$this->db->order_by('id','desc');
		$query = $this->db->get("video_titles");
		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;		
	}
	
	/******************VIDEO ENDS***********************************/
	
    public function photo_count() 
	{
        //return $this->db->count_all("listing");
		$this->db->select('*');
		$this->db->from('gallery_titles');
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->num_rows();
    }
	
	public function photo_gallery($limit,$start) 
	{
		//echo $start; exit;
		$this->db->limit($limit, $start);
		//$this->db->where('user_id',$param3);
		$this->db->order_by('id','desc');
		$query = $this->db->get("gallery_titles");
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;		
	}
	
	/******************PHOTO INNER PAGES **********************************/
	
	
	public function photo_titles($limit,$start,$category_id) 
	{
		$this->db->limit($limit, $start);
		$this->db->order_by('id','desc');
		$this->db->where('category_id',$category_id);
		$this->db->where('status',1);
		$query = $this->db->get("gallery_titles");
		
		if ($query->num_rows() > 0) 
		{
			foreach ($query->result_array() as $row) 
			{
				$data[] = $row;
			}
			return $data;
		}
		return false;		
	}
	
	
	public function photo_title_count($category_id) 
	{
		$this->db->select('*');
		$this->db->from('gallery_titles');
		$this->db->where('category_id',$category_id);
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->num_rows();
    }
	
	
	
}