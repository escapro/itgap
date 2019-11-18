<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Books extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		$this->load->model('post_model');
		$this->load->model('category_model');

		if (!$this->ion_auth->is_admin()){
			exit('Error 404');
		}

		$this->load->helper('date_helper');

		$this->data['user'] = $this->ion_auth->user()->row();
		$d = product_date_format($this->data['user']->created_on, 'number');
		$this->data['user']->created_on = $d['day'].'.'.$d['month'].'.'.$d['year'];
		$this->data['user_image'] = $this->user_model->get_user_avatar($this->ion_auth->user()->row()->id);
	}

	public function new() {
		$this->data['page_title'] = "Добавить книгу - itgap.ru";
		$this->data['userPageBlock'] = "new_book";
		$this->data['page'] = 'new_book';

		$this->data['categories'] = $this->category_model->get_categories();

		$this->load->view('user', $this->data);
	}
}
