<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require '../vendor/autoload.php';

use \EditorJS\EditorJS;

class Search extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('post_model');
		$this->load->model('category_model');
		$this->load->model('search_model');
	}

	public function index()
	{
		$this->data['query'] = $this->input->get()['q'];

		$this->data['query'] = $this->security->xss_clean($this->data['query']);
		$this->data['query'] = html_escape($this->data['query']);
		$this->data['query'] = stripslashes($this->data['query']);

		$this->data['page_title'] = "SEARCH";

		$this->data['content_type'] = "inline";

		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();

		if($this->data['query'] == ''){
			$this->data['posts'] = [];
		}else {
			$this->data['posts'] = $this->search_model->search($this->data['query']);
			
			// foreach ($this->data['posts'] as $key => $value) {

			// 	$this->data['posts'][$key]['title'] = str_replace($this->data['query'], "<mark>".$query."</mark>", $phrase);
			// }
		}
		
		$this->data['popular_posts'] = $this->post_model->get_popular_posts();

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->load->view('home', $this->data);
	}
}
