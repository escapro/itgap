<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('category_model');
		$this->load->model('post_model');
	}

	public function index()
	{
		$this->load->library('ion_auth');
		$this->data['page_title'] = "itGap — Все о мире IT и много другое";
		$this->data['page_description'] = $this->site_model->get_description('main');

		$this->data['content_type'] = "block";
		$this->data['is_main_page'] = true;

		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['posts'] = $this->post_model->get_posts();
		$this->data['popular_posts'] = $this->post_model->get_popular_posts();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->load->view('home', $this->data);
	}
}
