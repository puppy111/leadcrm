<?php if(!defined('BASEPATH')) exit('No direct script access allowed');


class Hi extends CI_Controller
{     
	public function __construct()     
	{         
		parent::__construct();  
		error_reporting(0);
		date_default_timezone_set('Asia/Kolkata');  
		$this->load->model('general_model');
	}
 
    public function index()
    {
        $title['page_title']       = 'BJP SC Morcha';
		//$title['page_array']       = $this->general_model->get_pages();
		$data['banner_array']      = $this->general_model->get_banner();
		
		
		$data['amit_video_array']  = $this->general_model->get_amit_video();
		$data['pm_video_array']    = $this->general_model->get_pm_video();
		$data['sc_video_array']    = $this->general_model->get_sc_video();
		
		
		$data['amit_gallery_array']  = $this->general_model->get_amit_gallery();
		$data['pm_gallery_array']    = $this->general_model->get_pm_gallery();
		$data['sc_gallery_array']    = $this->general_model->get_sc_gallery();
		
		
		$data['events_array']        = $this->general_model->get_events();
		$data['news_array']          = $this->general_model->get_news();
		
		
		/*foreach($data['video_array'] as $k => $v)
		{
			$data['video_array']['vdo'][$v['category']][]  = $data['video_array'][$v['category']];
		}*/
		
		//echo '<pre>';print_r($data['events_array']);
		$this->load->view("frontend/home-hindi",$data);
    }

		
	public function gallery()
    {
		$title['page_title'] = 'Omkar Travels Gallery';
		$title['gallery_array'] = $this->general_model->get_gallery();
		$total_data = $this->general_model->get_all_count();
        $content_per_page = 5; 
        $this->data['total_data'] = ceil($total_data->tol_records/$content_per_page);
		$this->load->view("frontend/header",$title);
        $this->load->view('frontend/gallery', $this->data, FALSE);
		$this->load->view("frontend/footer");
    }
		
	
	
	public function about()
	{
		$title['page_title'] = 'BJP SC MORCHA ABOUT US';
		$title['page_array'] = $this->general_model->get_pages('about');
		$this->load->view("frontend/about-sc-morcha");
	}
	
	public function vision_mission()
	{
		$this->load->view("frontend/vision-mission");
	}
	
	public function president_message()
	{
		$this->load->view("frontend/president-message");
	}
	
	public function sc_morcha_history()
	{
		$this->load->view("frontend/sc-morcha-history");
	}
	
	public function former_presidents()
	{
		$this->load->view("frontend/former-presidents");
	}
	
	public function organization_structure()
	{
		$this->load->view("frontend/organization-structure");
	}
	
	public function president_profile()
	{
		$this->load->view("frontend/president-profile");
	}
	
	
	public function national_body()
	{
		$this->load->view("frontend/national-body");
	}
	
	public function state_body()
	{
		$this->load->view("frontend/state-body");
	}
	
	public function events()
	{
		$this->load->view("frontend/events");
	}
	
	public function news()
	{
		$this->load->view("frontend/news_view");
	}
	
	public function registration()
	{
		$this->load->view("frontend/registration");
	}
	
	public function download()
	{
		$this->load->view("frontend/download");
	}
	
	public function pacha_teertha()
	{
		$this->load->view("frontend/pacha-teertha");
	}
	
	public function gov_schemes()
	{
		$this->load->view("frontend/gov-schemes");
	}
	
	public function photo_gallery()
	{
		$this->load->view("frontend/photo-gallery");
	}
	
	public function video_gallery()
	{
		$this->load->view("frontend/video-gallery");
	}
	
	public function sc_morcha_media()
	{
		$this->load->view("frontend/sc-morcha-media");
	}
	
	public function press_release()
	{
		$this->load->view("frontend/press-release");
	}
	
	public function public_representative()
	{
		$this->load->view("frontend/public-representative");
	}
	
	public function amit_sha_profile()
	{
		$this->load->view("frontend/amit_sha");
	}

	
	public function modi_profile()
	{
		$this->load->view("frontend/modi_profile");
	}
	
	
	
	/*
	public function pages($param = NULL)
	{
		$title['page_title'] = $param;
		$title['page_array'] = $this->general_model->get_pages($param = NULL);
		//echo '<pre>'; print_r($title); echo '</pre>'; 
		$this->load->view("frontend/header",$title);
		$this->load->view("frontend/pages",$title);
		$this->load->view("frontend/footer");
	}
	*/
	
	
	public function contact()
    {
		
		$title['page_title'] = 'Vivekananda Institute of English and Human Sciences Contact ';
		$title['page_array'] = $this->general_model->get_pages();
		$this->load->helper('captcha');
		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'name', 'trim|xss_clean|strip_tags|required|min_length[4]|max_length[20]');
		$this->form_validation->set_rules('email', 'email', 'trim|xss_clean|strip_tags|required|valid_email');
		$this->form_validation->set_rules('phone', 'phone', 'trim|xss_clean|strip_tags|required|regex_match[/^[0-9]{10}$/]');
		$this->form_validation->set_rules('subject', 'subject', 'trim|xss_clean|strip_tags|required|min_length[2]|max_length[20]');
		$this->form_validation->set_rules('message', 'message', 'trim|xss_clean|strip_tags|required|min_length[2]|max_length[500]');
	
		$this->form_validation->set_rules('userCaptcha', 'Captcha', 'required|callback_check_captcha');
		$userCaptcha = $this->input->post('userCaptcha');
		
		if ($this->form_validation->run() == FALSE)
		{
			// numeric random number for captcha
			$random_number = substr(number_format(time() * rand(),0,'',''),0,6);
			// setting up captcha config
			$vals = array(
			'word' => $random_number,
			'img_path' => './assets/captcha/',
			'img_url' => base_url().'assets/captcha/',
			'img_width' => 140,
			'img_height' => 32,
			'expiration' => 7200
			);
			$data['captcha'] = create_captcha($vals);
			$this->session->set_userdata('captchaWord',$data['captcha']['word']);
			
			$this->load->view("frontend/header",$title);
			$this->load->view("frontend/contact",$data);
			$this->load->view("frontend/footer");
			
			//$this->load->view('counseling');
		}
		else
		{
            $config = array();
            $config['useragent']           = 'CodeIgniter';
            //$config['mailpath']          = "/usr/bin/sendmail"; // or "/usr/sbin/sendmail"
            $config['protocol']            = 'smtp';
            $config['smtp_host']           = 'localhost';
            $config['smtp_port']           = 587;
            $config['smtp_user']           = 'support@aamits.com';
            $config['smtp_pass']           = 'support!@#';
            $config['mailtype'] = 'html';
            $config['charset']  = 'utf-8';
            $config['newline']  = '\r\n';
            $config['wordwrap'] = TRUE;

            $this->email->initialize($config);
            $this->email->from('support@aamits.com', 'support');
            $this->email->to('naren2naresh@gmail.com');
            $this->email->subject('Contact Form - vivekanandaenglish.com');

            $message = '<html><body>';
            $message .= '<img src="http://vivekanandaenglish.com/assets/frontend/images/logo.png" alt="logo" />';
            $message .= '<table rules="all" style="border-color: #666;" cellpadding="10">';
            $message .= "<tr style='background: #eee;'><td><strong>Name:</strong> </td><td>".$_POST['name']. "</td></tr>";
            $message .= "<tr><td><strong>Email:</strong> </td><td>" .$_POST['email']. "</td></tr>";
            $message .= "<tr><td><strong>Phone:</strong> </td><td>" .$_POST['phone']. "</td></tr>";
            $message .= "<tr><td><strong>Subject:</strong> </td><td>".$_POST['subject']. "</td></tr>";
			$message .= "<tr><td><strong>Message:</strong> </td><td>".$_POST['message']. "</td></tr>";
            $message .= "</table>";
            $message .= "</body></html>";
            $this->email->message($message);
            //$this->email->send();

            if (!$this->email->send())
            {
                echo $this->email->print_debugger();
            }
            else
            {
                $this->session->set_flashdata('item','Thank you for Contacting us ,We will get in touch with you shortly');
                $this->load->view("frontend/header",$title);
				$this->load->view("frontend/thankyou");
				$this->load->view("frontend/footer");
            }				
        }
		
    }
	
	public function check_captcha($str)
	{
		$word = $this->session->userdata('captchaWord');
		if(strcmp(strtoupper($str),strtoupper($word)) == 0)
		{
			return true;
		}
		else
		{
			$this->form_validation->set_message('check_captcha', 'Please enter correct words!');
			return false;
		}
    }
}