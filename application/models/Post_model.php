<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Post_model extends CI_Model {

	private $offsetCount = 15;

	function __construct()
	{
		parent::__construct();
	}

	// SITEMAP USE
	public function get_posts($page=1) {	
		$this->db->select("p.id as post_ID, p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, p.post_name");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->order_by("p.last_change", "desc");
		if($page !== 0) {
			$offset = ($page * $this->offsetCount) - $this->offsetCount;	
			$this->db->limit($this->offsetCount, $offset);
		}
		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['tags'] = $this->get_post_tags($value['post_ID']);		
		}

		return $data;
	}

	public function get_post($post_name) {
		$this->db->select("p.id as post_ID, p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, p.post_name, p.data_html, pv.count as views");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->join('post_views pv', 'pv.post_id=p.id');
		$this->db->where("p.post_name", $post_name);
		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['tags'] = $this->get_post_tags($value['post_ID']);		
		}

		return $data;
	}

	private function add_post ($data, $html, $user_id) {

		$insert_data = array(
			'post_id' => $data['id'],
			'title' => $data['title'],
			'preview_text' => $data['preview'],
			'link' => $data['link'],
			'preview_image_url' => $data['image'],
			'data_json' => $data['editorData'],
			'data_html' => $html,
			'last_change' => time(),
			'user_id' => $user_id
		);

		$this->db->insert('posts', $insert_data);
		$last_insert_post_id = $this->db->insert_id();

		if (is_array($data['tags'])) {
			if(!empty($data['tags'])) {
				foreach ($data['tags'] as $key => $value) {
					if($this->get_tags($value, true)['current_tag'] !== '') {
						$this->db->insert('post_tags', ['tag_id'=> $value, 'post_id'=>$last_insert_post_id]);
					}
				}
			}
		}
		
		$this->db->insert('post_views', ['post_id'=>$last_insert_post_id, 'count'=>0]);
		return $last_insert_post_id;
	}

	private function update_post ($data, $html) {

		$post_name = '';

		if ($data['title'] !== '' && $data['title'] !== ' ') {

			$table = array(
				"А"=>"a", "Б"=>"b", "В"=>"v", "Г"=>"g", "Д"=>"d",
				"Е"=>"e", "Ё"=>"yo", "Ж"=>"zh", "З"=>"z", "И"=>"i", 
				"Й"=>"j", "К"=>"k", "Л"=>"l", "М"=>"m", "Н"=>"n", 
				"О"=>"o", "П"=>"p", "Р"=>"r", "С"=>"s", "Т"=>"t", 
				"У"=>"u", "Ф"=>"f", "Х"=>"kh", "Ц"=>"ts", "Ч"=>"ch", 
				"Ш"=>"sh", "Щ"=>"sch", "Ъ"=>"", "Ы"=>"y", "Ь"=>"", 
				"Э"=>"e", "Ю"=>"yu", "Я"=>"ya", "а"=>"a", "б"=>"b", 
				"в"=>"v", "г"=>"g", "д"=>"d", "е"=>"e", "ё"=>"yo", 
				"ж"=>"zh", "з"=>"z", "и"=>"i", "й"=>"j", "к"=>"k", 
				"л"=>"l", "м"=>"m", "н"=>"n", "о"=>"o", "п"=>"p", 
				"р"=>"r", "с"=>"s", "т"=>"t", "у"=>"u", "ф"=>"f", 
				"х"=>"kh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"sch", 
				"ъ"=>"", "ы"=>"y", "ь"=>"", "э"=>"e", "ю"=>"yu", 
				"я"=>"ya", " "=>"-", "."=>"", ","=>"", "/"=>"-",  
				":"=>"", ";"=>"","—"=>"-", "–"=>"-", "?"=>"", 
				"!"=>"", "#"=>"", "("=>"", ")"=>"");
	
			$post_name = trim($data['title']);
		   	$post_name = strtr($post_name, $table);
		   	$post_name = preg_replace("/[^\x9\xA\xD\x20-\x7F]/u", "", $post_name);
		   	$post_name = strtolower($post_name);
		}

		$update_data = array(
			'title' => $data['title'],
			'preview_text' => $data['preview'],
			'link' => $data['link'],
			'preview_image_url' => $data['image'],
			'post_name' => $post_name,
			'data_json' => $data['editorData'],
			'data_html' => $html,
			'last_change' => time()
		);

		$this->db->where('post_id', $data['id']);
		$this->db->update('posts', $update_data);
	}

	public function save_draft ($data, $html, $user_id) {

		if(!$this->check_post_user($data['id'], $user_id)) {

			$post_id = $this->add_post($data, $html, $user_id);

			$insert_data = array(
				'post_id' => $post_id
			);

			$this->db->insert('draft_posts', $insert_data);


		}else {
			$this->update_post($data, $html);

			$post_id = $this->get_post_id($data['id']);

			$deleting_post = false;

			if (is_array($data['tags'])) {
				if(!empty($data['tags'])) {
					foreach ($data['tags'] as $key => $value) {
						if($this->get_tags($value, true)['current_tag'] !== '') {

							if(!$deleting_post){
								$this->db->where('post_id', $post_id);
								$this->db->delete('post_tags');
							}

							$deleting_post = true;

							$this->db->insert('post_tags', ['tag_id'=> $value, 'post_id'=>$post_id]);
						}
					}
				}
			}else if($data['tags'] == '') {
				$this->db->where('post_id', $post_id);
				$this->db->delete('post_tags');
			}
		}
	}

	// Отправка поста на модерацию(Сохранить id поста в таблицу onsidered_posts)
	public function save_considered_post ($data, $html, $user_id) {

		if($this->check_post_user($data['id'], $user_id)) {

			$this->update_post($data, $html);

			$this->db->select("id");
			$this->db->from("posts");
			$this->db->where("post_id", $data['id']);
			$query = $this->db->get();
			$post_id = $query->result_array()[0]['id'];

			$insert_data = array(
				'post_id' => $post_id,
				'is_watched' => 1
			);

			$this->db->delete('draft_posts', array('post_id' => $post_id));
			$this->db->insert('considered_posts', $insert_data);

		}

	}

	// Проверка на существенность поста
	private function check_post_user($post_id, $user_id) {

		$this->db->select("post_id");
		$this->db->from("posts");
		$this->db->where("post_id", $post_id);
		$this->db->where("user_id", $user_id);
		$query = $this->db->get();
		$data = $query->result_array();

		if(!empty($data)) {
			return $data;
		}
		return false;
	}

	public function generate_post_id () {

		$length = 11;
		
		$characters = '0123456789abcdefghijklmnopqrstuvwxyz';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}

	public function get_drafts ($user_id) {
		$this->db->select("p.id as post_ID, p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url");
		$this->db->from("posts p");
		$this->db->join('draft_posts d', 'p.id=d.post_id');
		$this->db->where("p.user_id", $user_id);
		$this->db->order_by("p.last_change", "desc");
		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['tags'] = $this->get_post_tags($value['post_ID']);		
		}
		
		return $data;
	}

	public function get_moderations ($user_id) {
		$this->db->select("p.id as post_ID, p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url");
		$this->db->from("posts p");
		$this->db->join('considered_posts d', 'p.id=d.post_id');
		$this->db->order_by("p.last_change", "desc");
		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['tags'] = $this->get_post_tags($value['post_ID']);		
		}

		return $data;
	}

	// SITEMAP USE
	public function get_tags ($tag=NULL, $check_id=false) {

		$this->db->select("*");
		$this->db->from("tags");
		$query = $this->db->get();
		$data['tags'] = $query->result_array();

		if ($tag !== NULL) {
			$this->db->select("*");
			$this->db->from("tags");
			if (!$check_id) {
				$this->db->where("tag", $tag);
			}else {
				$this->db->where("id", $tag);
			}
			$query_2 = $this->db->get();
			$data_2 = $query_2->result_array();

			$data['current_tag'] = $data_2[0]['title'];
			$data['current_tag_description'] = $data_2[0]['description'];
		}

		return $data;
	}

	public function get_post_selected_tags($post_id) {
		
		$id = $this->get_post_id($post_id);

		$this->db->select("*");
		$this->db->from("post_tags");
		$this->db->where("post_id", $id);
		$query= $this->db->get();
		$data = $query->result_array();
		return $data;
	}

	public function get_user_post ($user_id, $post_id) {
		$this->db->select("*");
		$this->db->from("posts p");
		$this->db->join('draft_posts d', 'p.id=d.post_id');
		$this->db->where("p.user_id", $user_id);
		$this->db->where("p.post_id", $post_id);
		$query = $this->db->get();
		$data = $query->result_array();

		if(!empty($data)) return $data[0];

		return false;
	}

	public function get_preview_post ($user_id, $post_id) {
		$this->db->select("p.id as post_ID, p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, pv.count as views, p.data_html");
		$this->db->from("posts p");
		$this->db->join('post_views pv', 'pv.post_id=p.id');
		$this->db->where("p.user_id", $user_id);
		$this->db->where("p.post_id", $post_id);
		$query = $this->db->get();
		$data = $query->result_array();
		
		foreach ($data as $key => $value) {
			$data[$key]['tags'] = $this->get_post_tags($value['post_ID']);		
		}

		if(!empty($data)) return $data[0];

		return false;
	}

	public function admin_approve_post($post_id) {
		// Обновить время поста
		$update_data = array(
			'last_change' => time()
		);

		$this->db->where('post_id', $post_id);
		$this->db->update('posts', $update_data);

		// Получить ID поста
		$this->db->select("id");
		$this->db->from("posts");
		$this->db->where("post_id", $post_id);
		$query = $this->db->get();
		$id = $query->result_array()[0]['id'];

		$insert_data = array(
			'post_id' => $id,
			'status' => 1
		);

		$this->db->delete('considered_posts', array('post_id' => $id));
		$this->db->insert('active_posts', $insert_data);
	}

	public function admin_reject_post($post_id) {
		// Обновить время поста
		$update_data = array(
			'last_change' => time()
		);

		$this->db->where('post_id', $post_id);
		$this->db->update('posts', $update_data);

		// Получить ID поста
		$this->db->select("id");
		$this->db->from("posts");
		$this->db->where("post_id", $post_id);
		$query = $this->db->get();
		$id = $query->result_array()[0]['id'];

		$insert_data = array(
			'post_id' => $id
		);

		$this->db->delete('considered_posts', array('post_id' => $id));
		$this->db->insert('draft_posts', $insert_data);
	}

	public function get_user_active_posts($user_id) {
		$this->db->select("p.id as post_ID, p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->where("p.user_id", $user_id);
		$this->db->order_by("p.last_change", "desc");
		$query = $this->db->get();
		$data = $query->result_array();

		foreach ($data as $key => $value) {
			$data[$key]['tags'] = $this->get_post_tags($value['post_ID']);		
		}

		return $data;
	}

	public function get_post_tags($post_id)
	{
		$this->db->select("t.id, t.title, t.tag, t.description");
		$this->db->from("post_tags");
		$this->db->join('tags t', 'tag_id=t.id');
		$this->db->where("post_id", $post_id);
		$query = $this->db->get();
		return $query->result_array();
	}

	public function add_view($post_name) {
		$this->db->select("pv.count, p.id");
		$this->db->from("post_views pv");
		$this->db->join('posts p', 'p.id=pv.post_id');
		$this->db->where("p.post_name", $post_name);
		$query = $this->db->get();
		$post = $query->result_array()[0];
		$update_data = array(
			'count' => intval($post['count']) + 1,
		);

		$this->db->where('post_id', $post['id']);
		$this->db->update('post_views', $update_data);
	}

	private function get_post_id($id) {
		$this->db->select("id");
		$this->db->from("posts");
		$this->db->where("post_id", $id);
		$query = $this->db->get();
		return $query->result_array()[0]['id'];
	}

	public function post_delete($user_id, $post_id, $post_type) {
		
		$id = $this->get_post_id($post_id);

		$this->db->delete($post_type, array('post_id' => $id));
		$this->db->delete('post_views', array('post_id' => $id));
		$this->db->delete('post_tags', array('post_id' => $id));
		$this->db->delete('posts', array('id' => $id, 'user_id' => $user_id));
		
	}

	public function get_popular_posts() {
		$this->db->select("p.title, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, pv.count as views, p.post_name");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->join('post_views pv', 'pv.post_id=p.id');
		$this->db->order_by("views", "desc");
		$this->db->limit(5);
		$query = $this->db->get();
		$data = $query->result_array();
		return $data;
	}

	public function get_posts_by_tag($tag) {
		$this->db->select("p.id as post_ID, p.title, t.title as tag, t.tag as tag_url, p.preview_text, p.post_id as post_id, p.last_change, p.preview_image_url as image_url, p.post_name, t.tag as tag_url");
		$this->db->from("posts p");
		$this->db->join('active_posts a', 'p.id=a.post_id');
		$this->db->join('post_tags pt', 'pt.post_id=p.id');
		$this->db->join('tags t', 't.id=pt.tag_id');
		$this->db->where("t.tag", $tag);
		$this->db->order_by("p.last_change", "desc");
		$query = $this->db->get();
		$data = $query->result_array();

		// foreach ($data as $key => $value) {
		// 	$data[$key]['tags']['url'] = $value['tag'];
		// 	$data[$key]['tags']['title'] = $value['tag'];	
		// }


		return $data;
	}
	
	public function set_draft($user_id, $post_id) {

		if(!$this->check_post_user($post_id, $user_id)) {
			return false;
		}

		// Обновить время поста
		$update_data = array(
			'last_change' => time()
		);

		$this->db->where('post_id', $post_id);
		$this->db->update('posts', $update_data);

		$id = $this->get_post_id($post_id);

		$insert_data = array(
			'post_id' => $id
		);

		$this->db->delete('active_posts', array('post_id' => $id));
		$this->db->insert('draft_posts', $insert_data);

		return true;
	}
}