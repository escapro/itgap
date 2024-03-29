<?php defined('BASEPATH') OR exit('No direct script access allowed');

// require 'application/libraries/composer/vendor/autoload.php';

// use Intervention\Image\ImageManager;

class Upload extends CI_Controller {

	private $uploadPath = 'static/uploads/posts/';
	private $response = array();
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('ion_auth');
		$this->load->model('user_model');
	}

	public function article_preview() {
		$type = 'article';
		$allowed_types = 'jpg|jpeg|png';
		$max_size = 2000;
		$image_quality = '95%';
		$this->upload_image('short', $type, $allowed_types, $max_size, $image_quality);
	}

	public function article_image() {
		$type = 'article';
		$allowed_types = 'jpg|jpeg|png|gif';
		$max_size = 3000;
		$image_quality = '90%';
		$this->upload_image('full', $type, $allowed_types, $max_size, $image_quality);
	}

	public function book_cover() {
		$type = 'book_cover';
		$allowed_types = 'jpg|jpeg|png';
		$max_size = 1500;
		$image_quality = '70%';
		$this->upload_image('short', $type, $allowed_types, $max_size, $image_quality);
	}

	public function update_avatar() {
		if(!isset($_FILES['avatar'])) {
			exit();
		}

		$config['upload_path']   = 'static/img/avatars';
		$config['allowed_types'] = 'jpg|jpeg|png';
		$config['max_size']      = 1500;
		$config['max_width']     = 3000;
		$config['max_height']    = 1500;
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('avatar'))
		{
			$this->response['error'] = $this->upload->display_errors();
			$this->response['success'] = 0;
		}
		else
		{	
			$data = $this->upload->data();

			$delete_file_path = $config['upload_path'].'/'.$this->user_model->get_user_avatar($this->ion_auth->user()->row()->id); 			
			if (is_file($delete_file_path))
			{
				unlink($delete_file_path);
			}

			$this->user_model->update_user_avatar($this->ion_auth->user()->row()->id, $data['file_name']);

			$image_url = $config['upload_path'].'/'.$data['file_name'];

			$resize_config['image_library']		= 'gd2';
			$resize_config['source_image'] 		= 'static/uploads/posts/'.$image_url;
			$resize_config['new_image']       	= 'static/uploads/posts/'.$image_url;
			$resize_config['width'] 			= 100;
			$resize_config['height'] 			= 100;
			$resize_config['maintain_ratio']	= TRUE;
			$resize_config['create_thumb'] 		= FALSE;
			$resize_config['quality'] 			= '95%';

			$this->load->library('image_lib', $resize_config);
			$this->image_lib->resize();	

			$this->response['success'] = 1;
			$this->response['file']['url'] = $image_url;
		}

		$this->response = json_encode($this->response);
		echo $this->response;
	}

	private function upload_image($urlType, $type, $allowed_types, $max_size, $image_quality) {

		if(!isset($_FILES['image'])) {
			exit();
		}

		$new_path = Date('Y').'/'.Date('m').'/'.Date('d');
		$file_folder = $this->uploadPath.$new_path;

		if (!file_exists($file_folder)) {
			mkdir($file_folder, 0777, true);
		}

		$config['upload_path']   = $file_folder;
		$config['allowed_types'] = $allowed_types;
		$config['max_size']      = $max_size;
		$config['max_width']     = 3000;
		$config['max_height']    = 1500;
		$config['encrypt_name']  = TRUE;

		$this->load->library('upload', $config);

		if (!$this->upload->do_upload('image'))
		{
			$this->response['error'] = $this->upload->display_errors();
			$this->response['success'] = 0;
		}
		else
		{
			$data = $this->upload->data();
			$image_url = $new_path.'/'.$data['file_name'];

			if($data['file_type'] !== 'image/gif') {
				// resize image
				$resize_config['image_library']		= 'gd2';
				$resize_config['source_image'] 		= 'static/uploads/posts/'.$image_url;
				$resize_config['new_image']       	= 'static/uploads/posts/'.$image_url;
				
				if($type == 'article') {
					// if($data['image_width'] > 1000) {
					// 	$resize_config['width'] = 1000;
					// }else {
					// 	$resize_config['width'] = $data['image_width'];
					// }
					
					// if($data['image_height'] > 500) {
					// 	$data['image_height'] = 500;
					// }else {
					// 	$resize_config['height'] = $data['image_height'];
					// }
				}else if($type == 'book_cover'){
					$resize_config['width'] = 200;
					$resize_config['height'] = 300;
				}
			

				$resize_config['maintain_ratio']	= TRUE;
				$resize_config['create_thumb'] 		= FALSE;
				$resize_config['quality'] 			= $image_quality;

				$this->load->library('image_lib', $resize_config);
				$this->image_lib->resize();	
			}
			
			if($urlType == 'short') {
				$this->response['file']['url'] = $image_url;
			}else if ($urlType == 'full') {
				$this->response['file']['url'] = base_url().$this->uploadPath.$image_url;
			}

			$this->response['success'] = 1;
		}

		$this->response = json_encode($this->response);
		echo $this->response;
	}
}
