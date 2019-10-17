<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Page extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('post_model');

		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['popular_posts'] = $this->post_model->get_popular_posts();
	}

	public function contacts()
	{
		$this->data['page'] = 'contacts';
		$this->data['page_title'] = "Contacts";
		$this->load->view('page', $this->data);
	}

	public function rights()
	{
		$this->data['page'] = 'rights';
		$this->data['page_title'] = "RIGHTS";
		$this->load->view('page', $this->data);
	}
}
