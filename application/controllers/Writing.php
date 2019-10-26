<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// require '../vendor/autoload.php';

// use \EditorJS\EditorJS;

class Writing extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('post_model');;
	}

	public function save()
	{
		$data = '';
		
		if ($this->input->post()) {
			$data = $this->normilize_data($this->input->post());
		}else {
			exit('Error 404');
		}

		try {

			$user_data = $this->ion_auth->user()->row();
			$this->post_model->save_draft($data['data'], $data['html'], $user_data->id);
			$response['success'] = 1;
			
			echo json_encode($response);

		} catch (\Throwable $th) {

			$response['success'] = 0;
			$response['error'] = "Произошла ошибка";

			echo json_encode($response);
		}	
	}

	public function publish(){

		$data = '';
		$response = array();
		
		if ($this->input->post()) {
			$data = $this->normilize_data($this->input->post());
		}else {
			exit('Error 404');
		}

		$this->load->helper(array('form', 'url'));
		$this->load->library('form_validation');

		// Проерка формы
		if (empty($data['data']['id']) && empty($data['data']['tag']) && empty($data['data']['editorData'])) {
			$response['error'][] = "Произошла ошибка";
		}
		if (empty($data['data']['title'])) {
			$response['error'][] = "Нет названия";
		}
		if(strlen($data['data']['title']) < 20 && strlen($data['data']['title']) > 1) {
			$response['error'][] = "Минимальная длина названия: 20";
		}
		if(empty($data['data']['image'])) {
			$response['error'][] = "Нет изображения";
		}
		if(empty($data['data']['preview'])) {
			$response['error'][] = "Нет краткого содержания";
		}
		if(empty($data['data']['tags'])) {
			$response['error'][] = "Выберите хотя бы один тег";
		}

		if (empty($response['error'])) {

			try {

				$user_data = $this->ion_auth->user()->row();
				$this->post_model->save_considered_post($data['data'], $data['html'], $user_data->id);
				$response['redirect'] = 1;
				
				echo json_encode($response);
	
			} catch (\Throwable $th) {
	
				$response['success'] = 0;
				$response['error'] = "Произошла ошибка:";
	
				echo json_encode($response);
			}	
		}else {
			echo json_encode($response);
		}
	}

	public function edit($post_id){

		$this->data['page_title'] = "Редактирование — itGap";
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
		
		$postData = $this->post_model->get_user_post($this->data['user']->id, $post_id);

		if($postData) {
			$this->data['postData'] = $postData;
			$post_tags = $this->post_model->get_post_selected_tags($post_id);
			$this->data['post_tags_jquery'] = '';

			if(!empty($post_tags)) {
				$this->data['post_tags_jquery'] = "$('.editor-tag__selector').val([";
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

	public function delete($post_id){
		try {
			$this->data['user'] = $this->ion_auth->user()->row();
			$this->post_model->post_delete($this->data['user']->id, $post_id, 'draft_posts');
			
			$response['success'] = 1;
			echo json_encode($response);
		
		} catch (\Throwable $th) {
			$response['success'] = 0;
			$response['error'] = "Произошла ошибка:";
	
			echo json_encode($response);
		}
	}

	private function normilize_data($data) {

		if (!$this->ion_auth->is_admin()){
			exit('Error 404');
		}
		
		foreach ($data as $key => $value) {
			if($key !== 'editorData') {
				$data[$key] = $this->security->xss_clean($data[$key]);
			}
		}

		$html = $this->parse_html(json_decode($data['editorData'], true)['blocks']);

		return ['data'=>$data, 'html'=>$html];
	}

	private function parse_html($arr) {

		$html = '';

		$conf = [
			'paragraph' => 'p',
			'header' => [
				1 => 'h1',
				2 => 'h2',
				3 => 'h3',
				4 => 'h4',
				5 => 'h5',
				6 => 'h6'
			],
			'list' => [
				'ordered' => 'ol',
				'unordered' => 'ul'
			],
			'image' => 'img'
		];

		foreach ($arr as $key => $value) {

			$type = $value['type'];

			if($type == 'header') {

				$text = $value['data']['text'];
				$level = $value['data']['level'];
				$tag = $conf[$type][$level];
				$html .= '<'.$tag.'>'.$text.'</'.$tag.'>';

			}else if($type == 'paragraph') {

				$text = $value['data']['text'];
				// print $text."\n";
				$tag = $conf[$type];
				$html .= '<'.$tag.'>'.$text.'</'.$tag.'>';
				
			}else if($type == 'list') {
				
				$style = $value['data']['style'];
				$tag = $conf[$type][$style];

				$items = $value['data']['items'];

				$html .= '<'.$tag.'>';

				foreach ($items as $key_2 => $text) {
					$html .= '<li>'.$text.'</li>';
				}

				$html .= '</'.$tag.'>';
				
			}else if($type == 'image') {

				if(isset($value['data']['file']['url'])) {
					$url = $value['data']['file']['url'];
					$tag = $conf[$type];
					$caption = str_replace("&nbsp;","", $value['data']['caption']);

					$html .= '<figure class="post-full">';
					$html .= '<'.$tag.' src="'.$url.'"';
					if($caption !== '') {
						$html .= ' alt="'.$caption.'"';
					}
					$html .= '>';
					$html .= '</figure>';
				}

			}else if($type == 'code') {

				$html .= '<pre class="codeStyle-dark"><code>';
				$html .= htmlspecialchars($value['data']['code']);
				$html .= '</code></pre>';

			}else if($type == 'delimiter') {

				$html .= '<div class="delimiter">***</div>';

			}else if($type == 'quote') {

				$html .= '<blockquote class="quote"><div class="quote__content">';
				$html .= $value['data']['text'];
				$html .= '</div>';
				if($value['data']['caption'] !== "") {
					$html .= '<footer class="quote__cite"><cite>';
					$html .= $value['data']['caption'];
					$html .= '</cite></footer>';
				}
				$html .= '</blockquote>';
				
			}else if($type == 'embed') {

				$html .= '<div class="frame-wrapper">';
				$html .= '<iframe height="320" width="580" scrolling="no" frameborder="no" allowtransparency="true" allowfullscreen="true" style="max-width: 100%;" src=';
				$html .= '"'.$value['data']['embed'].'"';
				$html .= '></iframe>';
				$html .= '</div>';
			}
		}

		return $html;
	}
}
