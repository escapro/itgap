<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require '../vendor/autoload.php';
// use \EditorJS\EditorJS;

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
		if(!isset($_GET['q'])){
			$this->data['query'] = '';
		}else {
			$this->data['query'] = $this->input->get()['q'];
		}

		$this->data['query'] = $this->security->xss_clean($this->data['query']);
		$this->data['query'] = html_escape($this->data['query']);
		$this->data['query'] = stripslashes($this->data['query']);
		$this->data['page_title'] = 'Поиск по запросу "'.$this->data['query'].'"';
		$this->data['content_type'] = "inline";
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['load_attributes'] = 'page="search" query="'.$this->data['query'].'"';

		if($this->data['query'] == ''){
			$this->data['posts'] = [];
		}else {
			$this->data['posts'] = $this->search_model->search($this->data['query']);
		}
		
		$this->data['suggested_posts_banner'] = $this->post_model->get_suggest_posts(5);

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->load->view('home', $this->data);
	}

	public function fetch()
	{

		if(!$this->input->post()) {
			show_404();
		}

		$data = $this->input->post();
		
		if(isset($data['query']) && isset($data['page'])) {
			$posts = $this->search_model->search($data['query'], $data['page']);
		}else {
			show_404();
		}

		if(empty($posts)) {
			show_404();
		}

		$response = array();
		$response['html'] = '';
		$response['isLastPage'] = $posts['isLastPage'];

		$query = $data['query'];

		foreach ($posts['posts'] as $key => $value) {
			$response['html'] .= 
			'<article class="article-inline">
				<div class="article-preview__content">
					<a href="/'.$value['category_url'].'/'.$value['post_name'].'">
						<h2 class="article-preview__title">'.preg_replace("/\w*?$query\w*/i", "<b>$0</b>", $value['title']).'</h2>
						<div class="article-preview-description">
							<p>'.preg_replace("/\w*?$query\w*/i", "<b>$0</b>", $value['preview_text']).'</p>
						</div>
					</a>
				</div>
				<div class="article-preview__image">
					<a href="/'.$value['category_url'].'/'.$value['post_name'].'">
						<img src="https://itgap.ru/static/uploads/posts/'.$value['image_url'].'" alt="image">
					</a>
				</div>
				<div class="article-inline_borderBottom"></div>
			</article>';
		}

		// foreach ($posts['posts'] as $key => $value) {
		// 	$response['html'] .= '<article class="article-preview block">
		// 		<div class="article-preview__content">
		// 			<a href=/post/'.$value['post_name'].'">
		// 				<h2 class="article-preview__title">'.$value['title'].'</h2>
		// 				<div class="article-preview-description">'.$value['preview_text'].'</div></a>
		// 			<div class="article-tags">';
					
		// 	// foreach ($value['tags'] as $key_tag => $value_tag) {
		// 	// 	$response['html'] .= '<a href="/tag/'.$value_tag['tag'].'">'.$value_tag['title'].'</a>';
		// 	// }

		// 	$response['html'] .= '</div></div><div class="article-preview__image">
		// 			<a href="/post/'.$value['post_name'].'">
		// 				<img src="https://itgap.ru/static/uploads/posts/'.$value['image_url'].'" alt="image">
		// 			</a>
		// 		</div>
		// 		</article>';
		// }

		echo json_encode($response);
	}
}
