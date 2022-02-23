<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		$this->load->model('post_model');
		$this->load->model('category_model');

		if ($this->ion_auth->logged_in())
		{
			$this->data['user_image'] = $this->user_model->get_user_avatar($this->ion_auth->user()->row()->id);
		} 
		
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['is_admin'] = $this->ion_auth->is_admin();

		$this->data['head_more'] = 
		'<meta name="robots" content="noindex, nofollow">';
	}

	public function index()
	{
		if (!$this->ion_auth->is_admin()){
			show_404();
		}

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->load->helper('date_helper');

		$this->data['userPageBlock'] = "profile";

		$this->data['user'] = $this->ion_auth->user()->row();
		$this->data['page_title'] = "Настройки профиля - ".$this->data['user']->username.' - itGap';

		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];

		$this->load->view('user', $this->data);

	}

	public function posts()
	{
		if (!$this->ion_auth->is_admin()){
			show_404();
		}

		$this->load->model('post_model');
		$this->load->helper('date_helper');

		$this->data['page_title'] = "POSTS";
		$this->data['userPageBlock'] = "active_posts";

		$this->data['user'] = $this->ion_auth->user()->row();
		$this->data['page_title'] = 'Мои публикации - '.$this->data['user']->username.' - itGap';

		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];

		$this->data['active_posts'] = $this->post_model->get_user_active_posts($this->data['user']->id);
		
		foreach ($this->data['active_posts'] as $key => $value) {
			$this->data['active_posts'][$key]['last_change'] = product_date_format($value['last_change'], 'long');
		}
	
		$this->load->view('user', $this->data);

	}

	public function in_moderations(){

		$this->data['userPageBlock'] = "moderations";

		$this->load->helper('date_helper');

		$this->data['user'] = $this->ion_auth->user()->row();
		$this->data['page_title'] = 'На модерации - '.$this->data['user']->username.' - itGap';

		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];
		
		$this->data['moderations_posts'] = $this->post_model->get_moderations($this->data['user']->id);
		
		foreach ($this->data['moderations_posts'] as $key => $value) {
			$this->data['moderations_posts'][$key]['last_change'] = product_date_format($value['last_change'], 'long');
		}
		
		$this->data['editorPostData'] = '';

		$this->load->view('user', $this->data);

	}

	public function drafts(){

		$this->data['userPageBlock'] = "drafts";

		$this->load->helper('date_helper');

		$this->data['user'] = $this->ion_auth->user()->row();

		$this->data['page_title'] = 'Черновик - '.$this->data['user']->username.' - itGap';

		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];
		
		$this->data['draft_posts'] = $this->post_model->get_drafts($this->data['user']->id);
		
		foreach ($this->data['draft_posts'] as $key => $value) {
			$this->data['draft_posts'][$key]['last_change'] = product_date_format($value['last_change'], 'long');
		}
		
		$this->data['editorPostData'] = '';

		$this->load->view('user', $this->data);

	}

	public function admin(){

		$this->data['userPageBlock'] = "admin";

		$this->load->helper('date_helper');

		$this->data['user'] = $this->ion_auth->user()->row();

		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];

		$this->data['page_title'] = 'Админ панель - itGap';

		$this->load->view('user', $this->data);

	}

	// public function tempRegister(){

	// 	$username = 'admin';
	// 	$password = 'itgap.master33355';
	// 	$email = 'ruslan-4742@mail.ru';
	// 	$additional_data = array(
	// 				'first_name' => 'Admin',
	// 				'last_name' => '',
	// 				);
	// 	$group = array('1'); // Sets user to admin.
	
	// 	$this->ion_auth->register($username, $password, $email, $additional_data, $group)
	// }

	public function login(){

		$data = $this->input->post();
		$data = $this->security->xss_clean($data);
		$data = html_escape($data);

		$identity = $data['email'];
		$password = $data['password'];
		$remember = TRUE;

		$msg = array();

		if (!$this->ion_auth->login($identity, $password, $remember))
		{
			$msg['error'] = 'Произошла ошибка';
			$msg['success'] = 0;
		}else {
			$msg['success'] = 1;
		}

		echo json_encode($msg);
	}

	public function logout(){
		$this->ion_auth->logout();
		$url = $this->config->item('base_url');
		redirect($url);
	}

	public function change_profile(){

		// $data = array(
		// 	'first_name' => 'Ben',
		// 	'last_name' => 'Edmunds',
		// 	'password' => '123456789',
		// 	);

		$msg = [];

		$data = $this->input->post();
		$data = $this->security->xss_clean($data);
		$data = html_escape($data);

		if ($data['old_password'] != '' && $data['old_password'] != '') {
			$identity = $this->session->userdata('identity');
			$change = $this->ion_auth->change_password($identity, $data['old_password'], $data['new_password']);
		}

		$new_data = array(
			'first_name' => $data['first_name'],
			'username' => $data['username'],
			'email' => $data['email'],
			);

		if ($this->ion_auth->update($this->ion_auth->user()->row()->id, $new_data)) {
			$this->session->set_flashdata('succes_mesage', $this->ion_auth->messages());
			$msg['success'] = 1;
		}else {
			$this->session->set_flashdata('error_mesage', $this->ion_auth->errors());
			$msg['error'] = 'Произошла ошибка';
			$msg['success'] = 0;
		}

		echo json_encode($msg);
	}
}
