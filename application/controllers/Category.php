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

	//show post by category
	public function index($post_name) {

		try {
			$this->post_model->add_view($post_name);
			$this->data['post'] = $this->post_model->get_post($post_name)[0];
		} catch (\Throwable $th) {
			show_404();
		}

		$this->data['page_title'] = $this->data['post']['title']." — itGap";
		$this->data['page_description'] = $this->data['post']['preview_text'];
		$this->data['page_image'] = $this->data['post']['image_url'];

		$this->data['head_more'] = 
		'<link rel="stylesheet" type="text/css" href="/media/highlight/styles/atom-one-dark.css">'.
		'<script type="text/javascript" src="/media/highlight/highlight.pack.js"></script>';

		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['suggested_posts_banner'] = $this->post_model->get_suggest_posts(5);
		$this->data['suggested_posts'] = $this->post_model->get_suggest_posts(4);

		$this->load->helper('date_helper');
		$this->data['post']['last_change'] = product_date_format($this->data['post']['last_change'], 'long');

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;
		
		$this->load->view('post', $this->data);
	}

	public function tag($tag)
	{
		$this->data['content_type'] = "block";

		try {
			$this->data['tags'] = $this->post_model->get_tags($tag);
			$this->data['posts'] = $this->post_model->get_posts_by_tag($tag);
		} catch (\Throwable $th) {
			show_404();
		}

		$this->data['page_title'] = $this->data['tags']['current_tag'].' — itGap';
		$this->data['page_description'] = $this->site_model->get_description('main');
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['suggested_posts_banner'] = $this->post_model->get_suggest_posts(5);
		$this->data['load_attributes'] = 'page="tag" tag="'.$tag.'"';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->data['content_title'] = $this->data['tags']['current_tag'];
		$this->data['current_tag_description'] = $this->data['tags']['current_tag_description'];

		$this->load->view('home', $this->data);
	}

	public function category($category)
	{
		
		$this->data['content_type'] = "block";

		try {
			$this->data['category'] = $this->category_model->get_category($category);
			$this->data['tags'] = $this->post_model->get_tags();
			$this->data['posts'] = $this->post_model->get_posts_by_category($category);
		} catch (\Throwable $th) {
			show_404();
		}

		// print_r($this->data['posts']);
		// exit();

		$this->data['page_title'] = $this->data['category']['title'].' — itGap';
		$this->data['page_description'] = $this->site_model->get_description('main');
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['suggested_posts_banner'] = $this->post_model->get_suggest_posts(5);
		$this->data['load_attributes'] = 'page="category" category="'.$category.'"';

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		// $this->data['content_title'] = $this->data['tags']['current_tag'];
		// $this->data['current_tag_description'] = $this->data['tags']['current_tag_description'];

		$this->load->view('home', $this->data);
	}

	public function tag_fetch()
	{
		if(!$this->input->post()) {
			show_404();
		}

		$data = $this->input->post();

		if(isset($data['tag']) && isset($data['page'])) {
			$posts = $this->post_model->get_posts_by_tag($data['tag'], $data['page']);
		}else {
			show_404();
		}

		if(empty($posts)) {
			show_404();
		}

		$response = array();
		$response['html'] = '';
		$response['isLastPage'] = $posts['isLastPage'];

		foreach ($posts['posts'] as $key => $value) {
			$response['html'] .= '<article class="article-preview block">
				<div class="article-preview__content">
					<a href=/post/'.$value['post_name'].'">
						<h2 class="article-preview__title">'.$value['title'].'</h2>
						<div class="article-preview-description">'.$value['preview_text'].'</div></a>
					<div class="article-tags">';
			
			$response['html'] .= '<a href="/tag/'.$value['tag_url'].'">'.$value['tag'].'</a>';				

			$response['html'] .= '</div></div><div class="article-preview__image">
					<a href="/post/'.$value['post_name'].'">
						<img src="https://itgap.ru/static/uploads/posts/'.$value['image_url'].'" alt="image">
					</a>
				</div>
				</article>';
		}

		echo json_encode($response);
	}

	public function category_fetch()
	{
		if(!$this->input->post()) {
			show_404();
		}

		$data = $this->input->post();

		if(isset($data['category']) && isset($data['page'])) {
			$posts = $this->post_model->get_posts_by_category($data['category'], $data['page']);
		}else {
			show_404();
		}

		if(empty($posts)) {
			show_404();
		}

		$response = array();
		$response['html'] = '';
		$response['isLastPage'] = $posts['isLastPage'];

		foreach ($posts['posts'] as $key => $value) {
			$response['html'] .= '<article class="article-preview block">
				<div class="article-preview__content">
					<a href=/'.$data['category'].'/'.$value['post_name'].'">
						<h2 class="article-preview__title">'.$value['title'].'</h2>
						<div class="article-preview-description">'.$value['preview_text'].'</div></a>
					<div class="article-tags">';
					
			foreach ($value['tags'] as $key_tag => $value_tag) {
				$response['html'] .= '<a href="/tag/'.$value_tag['tag'].'">'.$value_tag['title'].'</a>';
			}

			$response['html'] .= '</div></div><div class="article-preview__image">
					<a href="/'.$data['category'].'/'.$value['post_name'].'">
						<img src="https://itgap.ru/static/uploads/posts/'.$value['image_url'].'" alt="image">
					</a>
				</div>
				</article>';
		}

		echo json_encode($response);
	}
}