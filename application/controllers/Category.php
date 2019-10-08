<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		$this->load->model('post_model');
		$this->load->model('category_model');

		if ($this->ion_auth->logged_in()){
			$this->data['user_id'] = $this->ion_auth->user()->row()->id;
		}
	}

	public function tag($tag)
	{
		$this->data['content_type'] = "block";

		$this->data['tags'] = $this->post_model->get_tags($tag);

		$this->data['page_title'] = $this->data['tags']['current_tag'].' — itGap';

		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['posts'] = $this->post_model->get_posts_by_tag($tag);
		$this->data['popular_posts'] = $this->post_model->get_popular_posts();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->data['content_title'] = $this->data['tags']['current_tag'];
		$this->data['current_tag_description'] = $this->data['tags']['current_tag_description'];

		$this->load->view('home', $this->data);
	}
}