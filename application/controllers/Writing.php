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
		'<script type="text/javascript" src="/media/post/service.js"></script>';

		$this->data['postId'] = $post_id;
		$this->data['tags'] = $this->post_model->get_tags();
		$this->data['user'] = $this->ion_auth->user()->row();
		
		$postData = $this->post_model->get_user_post($this->data['user']->id, $post_id);

		if($postData) {
			$this->data['editorPostData'] = json_encode($postData['data_json']);
			$this->data['postData'] = $postData;
			$this->data['previewImage'] =  $postData['preview_image_url'];
			$this->load->view('editor', $this->data);
		}else {
			exit("error 404");
		}
	}

	public function delete($post_id){
		$this->data['user'] = $this->ion_auth->user()->row();
		$this->post_model->post_delete($this->data['user']->id, $post_id, 'draft_posts');
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
					$html .= '<'.$tag.' src="'.$url.'">';
				}

			}else if($type == 'code') {

				$html .= '<pre class="codeStyle-dark"><code>';
				$html .= $this->security->xss_clean(htmlspecialchars($value['data']['code']));
				$html .= '</code></pre>';

			}else if($type == 'delimiter') {

				$html .= '<div class="delimiter">***</div>';

			}else if($type == 'quote') {

				$html .= '<blockquote class="quote"><div class="quote__content">';
				$html .= $value['data']['text'];
				$html .= '</div><footer class="quote__cite"><cite>';
				$html .= $value['data']['caption'];
				$html .= '</cite></footer></blockquote>';
				
			}
		}

		return $html;
	}
}
