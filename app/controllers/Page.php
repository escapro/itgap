<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('post_model');

		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['suggested_posts_banner'] = $this->post_model->get_suggest_posts(5);
	}

	public function contacts()
	{
		$this->data['page'] = 'contacts';
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;
		$this->data['page_title'] = "Контакты";
		$this->load->view('page', $this->data);
	}

	public function rights()
	{
		$this->data['page'] = 'rights';
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;
		$this->data['page_title'] = "Пользовательское соглашение";
		$this->load->view('page', $this->data);
	}
}
