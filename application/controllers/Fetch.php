<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fetch extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('user_model');
		$this->load->model('post_model');
		$this->load->model('search_model');
		$this->load->model('category_model');

		if ($this->ion_auth->logged_in()){
			$this->data['user_id'] = $this->ion_auth->user()->row()->id;
		}
	}

	public function index()
	{
		if(!$this->input->post()) {
			show_404();
		}

		$data = $this->input->post();

		if(!isset($data['page'])) {
			show_404();
		}

		$posts = '';
		$page = '';

		if(isset($data['all'])) {
			$page = 'home';
			if($data['all'] == 'all') {
				$posts = $this->post_model->get_posts($data['page']);
			}
		}else if(isset($data['tag'])) {
			$page = 'tag';
			$posts = $this->post_model->get_posts_by_tag($data['tag'], $data['page']);
		}else if(isset($data['query'])) {
			$page = 'search';
			$posts = $this->search_model->search($data['query'], $data['page']);
		}

		// print_r($posts);
		// exit();

		if(empty($posts)) {
			show_404();
		}

		$response = array();
		$response['html'] = '';
		$response['isLastPage'] = $posts['isLastPage'];

		if($page !== 'search') {
			foreach ($posts['posts'] as $key => $value) {
				$response['html'] .= '<article class="article-preview block">
					<div class="article-preview__content">
						<a href=/post/'.$value['post_name'].'">
							<h2 class="article-preview__title">'.$value['title'].'</h2>
							<div class="article-preview-description">'.$value['preview_text'].'</div></a>
						<div class="article-tags">';
				
				if($page !== 'tag') {
					foreach ($value['tags'] as $key_tag => $value_tag) {
						$response['html'] .= '<a href="/tag/'.$value_tag['tag'].'">'.$value_tag['title'].'</a>';
					}
				}else {
					$response['html'] .= '<a href="/tag/'.$value['tag_url'].'">'.$value['tag'].'</a>';
				}
	
				$response['html'] .= '</div></div><div class="article-preview__image">
						<a href="/post/'.$value['post_name'].'">
							<img src="https://itgap.ru/static/uploads/posts/'.$value['image_url'].'" alt="image">
						</a>
					</div>
					</article>';
			}	
		}else {
			foreach ($posts['posts'] as $key => $value) {
				$response['html'] .= '<article class="article-inline">
					<div class="article-preview__content">
						<a href="'.$value['post_name'].'">
							<h2 class="article-preview__title">Топ-5 асинхронных веб-фреймворков на Python</h2>
						</a>
					</div>
					<div class="article-preview__image">
						<a href="/post/top-5-asinkhronnykh-veb-frejmvorkov-na-python">
							<img src="https://itgap.ru/static/uploads/posts/2019/10/09/8d9022e343c06ec523763bca19e0752e.jpg" alt="image">
						</a>
					</div>
				</article>';
			}
		}

		echo json_encode($response);
	}
}
