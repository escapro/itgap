<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post extends CI_Controller {

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

	public function show($post_name)
	{
		try {
			$this->post_model->add_view($post_name);
			$this->data['post'] = $this->post_model->get_post($post_name)[0];
		} catch (\Throwable $th) {
			exit("Error 404");
		}

		$this->data['page_title'] = $this->data['post']['title']." — itGap";
		$this->data['page_description'] = $this->data['post']['preview_text'];
		$this->data['page_image'] = $this->data['post']['image_url'];

		$this->data['head_more'] = 
		'<link rel="stylesheet" type="text/css" href="/media/highlight/styles/atom-one-dark.css">'.
		'<script type="text/javascript" src="/media/highlight/highlight.pack.js"></script>';

		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['popular_posts'] = $this->post_model->get_popular_posts();

		$this->load->helper('date_helper');
		$this->data['post']['last_change'] = product_date_format($this->data['post']['last_change'], 'long');

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;
		
		$this->load->view('post', $this->data);
	}

	public function new()
	{
		$this->data['head_more'] = 
		'<link rel="stylesheet" type="text/css" href="/media/post/new_post.css">'.
		'<script type="text/javascript" src="/media/post/new_post.js"></script>'.
		'<script type="text/javascript" src="/media/post/service.js"></script>'.
		'<link rel="stylesheet" type="text/css" href="/media/select2/select2.min.css">'.
		'<script type="text/javascript" src="/media/select2/select2.min.js"></script>';

		$this->data['page_title'] = 'Новый пост — itGap';

		$this->data['postId'] = $this->post_model->generate_post_id();
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['post_tags_jquery'] = '';
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;
		

		$d = "";
		$d .= "postData = {};";
		$d .= 'postData.postId = "'.$this->data['postId'].'";';
		$d .= 'postData.previewImage = "";';
		$d .= 'postData.editorData = "";';

		$this->data['editorData'] = $d;
		
		$this->load->view('editor', $this->data);
	}

	public function preview($post_id){

		$this->data['page_title'] = 'Предпросмотр — itGap';

		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['popular_posts'] = $this->post_model->get_popular_posts();
		$this->data['post'] = $this->post_model->get_preview_post($this->data['user_id'], $post_id);
		
		$this->data['head_more'] = 
		'<link rel="stylesheet" type="text/css" href="/media/highlight/styles/atom-one-dark.css">'.
		'<script type="text/javascript" src="/media/highlight/highlight.pack.js"></script>';

		
		$this->load->helper('date_helper');
		$this->data['post']['last_change'] = product_date_format($this->data['post']['last_change'], 'long');

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		$this->load->view('post', $this->data);
	}

	public function edit($post_id){

		if (!$this->ion_auth->is_admin()){
			exit('Error 404');
		}
		$this->data['userPageBlock'] = "drafts";

		$this->data['head_more'] = 
		'<link rel="stylesheet" type="text/css" href="/media/post/new_post.css">'.
		'<script type="text/javascript" src="/media/post/new_post.js"></script>'.
		'<script type="text/javascript" src="/media/post/service.js"></script>'.
		'<link rel="stylesheet" type="text/css" href="/media/select2/select2.min.css">'.
		'<script type="text/javascript" src="/media/select2/select2.min.js"></script>';

		$this->data['postId'] = $post_id;
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['user'] = $this->ion_auth->user()->row();

		$this->data['page_title'] = 'Редактирование — itGap';

		if(!$this->post_model->set_draft($this->data['user']->id, $post_id)) {
			exit("Error 404");
		}
		
		$postData = $this->post_model->get_user_post($this->data['user']->id, $post_id);

		if($postData) {
			$this->data['postData'] = $postData;
			$post_tags = $this->post_model->get_post_selected_tags($post_id);
			$this->data['post_tags_jquery'] = '';

			if(!empty($post_tags)) {
				$this->data['post_tags_jquery'] .= "$('.editor-tag__selector').val([";
				foreach ($post_tags as $key => $value) {
					$this->data['post_tags_jquery'] .= $value['tag_id'].",";
				}
				$this->data['post_tags_jquery'] .= "]);";
			}

			$d = "";

			$d .= "postData = {};\n";
			$d .= 'postData.postId = "'.$post_id.'";'."\n";
			$d .= 'postData.previewImage = "'.$postData["preview_image_url"].'";'."\n";
			$d .= "postData.editorData = ".$postData['data_json'].";";

			$this->data['editorData'] = $d;

			$this->load->view('editor', $this->data);
		}else {
			exit("error 404");
		}
	}

	public function fetch()
	{
		if(!$this->input->post()) {
			exit('Error 404');
		}

		$data = $this->input->post();
		
		$response = array();
		$response['html'] = '';
		$posts = $this->data['posts'] = $this->post_model->get_posts($data['page']);

		if(empty($posts)) {
			exit('Error 404');
		}

		foreach ($posts as $key => $value) {
			$response['html'] .= '<article class="article-preview block">
					<div class="article-preview__content">
						<a href=/'.$value['tag_url'].'/'.$value['post_name'].'">
							<h2 class="article-preview__title">'.$value['title'].'</h2>
							<div class="article-preview-description">'.$value['preview_text'].'</div></a>
						<div class="article-tags">
							<a href="/tag/'.$value['tag_url'].'">'.$value['tag'].'</a>
						</div>
					</div>
					<div class="article-preview__image">
						<a href="/'.$value['tag_url'].'/'.$value['post_name'].'">
							<img src="/static/uploads/posts/'.$value['image_url'].'" alt="image">
						</a>
					</div>
				</article>'	;
		}

		echo json_encode($response);
	}
}
