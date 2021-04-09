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

		$this->data['is_admin'] = $this->ion_auth->is_admin();
	}

	public function show($category, $post_name)
	{
		try {

			$this->data['post'] = $this->post_model->get_post($post_name, $category);
			
			if(sizeof($this->data['post']) > 0) $this->data['post'] = $this->data['post'][0];
			
			if(empty($this->data['post'])) {
				show_404();
			}
			
			if($this->ion_auth->is_admin() === false) {
				$this->post_model->add_view($this->data['post']['post_ID']);
			}
		} catch (\Throwable $th) {
			if(APP_ENV === 'production') {
				show_404();
			}else {
				echo $th;
			}
			exit();
		}

		if(empty($this->data['post'])) {
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

		$tags_for_similar_posts = array_map(function($tag) {
			return $tag['tag'];
		}, $this->data['post']['tags']);

		$this->data['suggested_posts'] = $this->post_model->get_posts_by_tags($tags_for_similar_posts, 4);

		if(sizeof($this->data['suggested_posts']) == 0) {
			$this->data['suggested_posts'] = $this->post_model->get_suggest_posts(4);
		}

		$this->load->helper('date_helper');

		$this->data['post']['last_change'] = product_date_format($this->data['post']['last_change'], 'long');

		foreach ($this->data['suggested_posts'] as $key => $value) {
			$this->data['suggested_posts'][$key]['last_change'] = product_date_format($value['last_change'], 'long', true);
		}

		$this->data['is_post_show_page'] = true;

		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;

		// Insert advertisments
		if ($category == 'post') {
			$this->insert_adv(1, '
			<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
			<ins class="adsbygoogle"
				style="display:block; text-align:center;"
				data-ad-layout="in-article"
				data-ad-format="fluid"
				data-ad-client="ca-pub-5882767307365612"
				data-ad-slot="7715324364"></ins>
			<script>
			(adsbygoogle = window.adsbygoogle || []).push({});
			</script>');
		}
		
		$this->load->view('post', $this->data);
	}

	public function new()
	{
		$this->data['head_more'] =
		'<meta name="robots" content="noindex">'.
		'<link rel="stylesheet" type="text/css" href="/media/post/new_post.css">'.
		'<script type="text/javascript" src="/media/post/new_post.js"></script>'.
		'<script type="text/javascript" src="/media/post/service.js"></script>'.
		'<link rel="stylesheet" type="text/css" href="/media/select2/select2.min.css">'.
		'<script type="text/javascript" src="/media/select2/select2.min.js"></script>'.
		'<script type="text/javascript" src="/media/post/book.js"></script>'.
		'<link rel="stylesheet" type="text/css" href="/media/post/book.css">';

		$this->data['page_title'] = 'Новый пост — itGap';

		$this->data['postId'] = $this->post_model->generate_post_id();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['post_tags_jquery'] = '';

		$this->data['postWritingPage'] = true;
		
		$csrf = array(
			'name' => $this->security->get_csrf_token_name(),
			'hash' => $this->security->get_csrf_hash()
		);
		$this->data['csrf'] = $csrf;
		

		$d = "";
		$d .= 'cPage = "postWritingPage";'."\n";
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
		$this->data['suggested_posts_banner'] = $this->post_model->get_suggest_posts(5);
		$this->data['post'] = $this->post_model->get_preview_post($this->data['user_id'], $post_id);

		$tags_for_similar_posts = [];
		$this->data['suggested_posts'] = [];

		if(isset($this->data['post']['tags'])) {
			if(sizeof($this->data['post']['tags']) > 0) {
				$tags_for_similar_posts = array_map(function($tag) {
					return $tag['tag'];
				}, $this->data['post']['tags']);
		
				$this->data['suggested_posts'] = $this->post_model->get_posts_by_tags($tags_for_similar_posts, 4);
			}
		}

		if(sizeof($this->data['suggested_posts']) == 0) {
			$this->data['suggested_posts'] = $this->post_model->get_suggest_posts(4);
		}

		$this->load->helper('date_helper');

		foreach ($this->data['suggested_posts'] as $key => $value) {
			$this->data['suggested_posts'][$key]['last_change'] = product_date_format($value['last_change'], 'long', true);
		}
		
		$this->data['head_more'] = 
		'<meta name="robots" content="noindex">'.
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

	public function toDraft($post_id){
		$this->data['user'] = $this->ion_auth->user()->row();
		if(!$this->post_model->set_draft($this->data['user']->id, $post_id)) {
			show_404();
		}
	}

	public function edit($post_id){

		if (!$this->ion_auth->is_admin()){
			show_404();
		}
		$this->data['userPageBlock'] = "drafts";

		$this->data['head_more'] =
		'<meta name="robots" content="noindex">'.
		'<link rel="stylesheet" type="text/css" href="/media/post/new_post.css">'.
		'<script type="text/javascript" src="/media/post/new_post.js"></script>'.
		'<script type="text/javascript" src="/media/post/service.js"></script>'.
		'<link rel="stylesheet" type="text/css" href="/media/select2/select2.min.css">'.
		'<script type="text/javascript" src="/media/select2/select2.min.js"></script>'.
		'<script type="text/javascript" src="/media/post/book.js"></script>'.
		'<link rel="stylesheet" type="text/css" href="/media/post/book.css">';

		$this->data['postId'] = $post_id;
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['categories'] = $this->category_model->get_categories();
		$this->data['user'] = $this->ion_auth->user()->row();

		$this->data['postEditPage'] = true;

		$this->data['page_title'] = 'Редактирование — itGap';
		
		$postData = $this->post_model->get_user_active_post_data($this->data['user']->id, $post_id);

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
			$d .= 'cPage = "postEditPage";'."\n";
			$d .= 'postData.postId = "'.$post_id.'";'."\n";
			$d .= 'postData.previewImage = "'.$postData["preview_image_url"].'";'."\n";
			$d .= "postData.editorData = ".$postData['data_json'].";";

			$this->data['editorData'] = $d;

			$this->load->view('editor', $this->data);
		}else {
			show_404();
		}
	}

	public function fetch()
	{
		if(!$this->input->post()) {
			show_404();
		}

		$data = $this->input->post();

		if(isset($data['type']) && isset($data['page'])) {
			if($data['type'] == 'all') {
				$posts = $this->post_model->get_posts($data['page']);
			}else if($data['type'] == 'top') {
				$posts = $this->post_model->get_popular_posts($data['page']);
			}
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
					<a href="/'.$value['category_url'].'/'.$value['post_name'].'">
						<h2 class="article-preview__title">'.$value['title'].'</h2>
						<div class="article-preview-description">'.$value['preview_text'].'</div></a>
					<div class="article-tags">';
					
			foreach ($value['tags'] as $key_tag => $value_tag) {
				$response['html'] .= '<a href="/tag/'.$value_tag['tag'].'">'.$value_tag['title'].'</a>';
			}

			$response['html'] .= '</div></div><div class="article-preview__image">
					<a href="/'.$value['category_url'].'/'.$value['post_name'].'">
						<img src="https://itgap.ru/static/uploads/posts/'.$value['image_url'].'" alt="'.$value['title'].'">
					</a>
				</div>
				</article>';
		}

		echo json_encode($response);
	}

	private function insert_adv($after_par, $script) {

		$after = $after_par;

		$dom = new DOMDocument;
		libxml_use_internal_errors(true);
		$dom->loadHTML(mb_convert_encoding($this->data['post']['data_html'], 'HTML-ENTITIES', 'UTF-8'));
			
		$par_length = $dom->getElementsByTagName('p')->length;
		if ($par_length <= 3) {
			return;
		}
		if ($after == 'mid') {
			$after = ceil($par_length / 2);
		}

		$after--;

		$adv_block = $dom->createElement('div');

		$adv_script = new DOMDocument();

		if (APP_ENV !== 'production') {
			$script = '<div class="advertisment bxS mb-2" style="display: block; width: 100%; height: 200px; background-color: #333"></div>';
		}

		$adv_script->loadHTML($script);

		$adv_block->appendChild($dom->importNode($adv_script->documentElement, true));

		$adv_block->setAttribute('class', 'mb-2');

		$dom->getElementsByTagName('p')->item($after)->appendChild($adv_block);
		
		$this->data['post']['data_html'] = $dom->saveHTML();

	}
}
