<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('post_model');;

		if (!$this->ion_auth->is_admin()){
			exit('Error 404');
		}

		$this->load->helper('date_helper');

		$this->data['user'] = $this->ion_auth->user()->row();
		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];
	}

	public function index() {
		$this->data['page_title'] = "ADMIN";
		$this->data['page'] = 'console';
		$this->load->view('admin/main', $this->data);
	}

	public function in_moderation() {
		$this->data['page'] = 'in_moderation';
		$this->load->view('admin/main', $this->data);
	}

	public function approve_post($post_id) {
		if (!$this->ion_auth->is_admin()){
			exit('Error 404');
		}

		$this->load->helper('url');

		$this->post_model->admin_approve_post($post_id);
		header('Location: /user/in_moderations'); 
	}

	public function reject_post($post_id) {
		if (!$this->ion_auth->is_admin()){
			exit('Error 404');
		}else {
			$this->post_model->admin_reject_post($post_id);
			header('Location: /user/in_moderations');
		}
	}

}
