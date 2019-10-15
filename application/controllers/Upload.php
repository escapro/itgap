<?php defined('BASEPATH') OR exit('No direct script access allowed');

// require 'application/libraries/composer/vendor/autoload.php';

// use Intervention\Image\ImageManager;

class Upload extends CI_Controller {

	private $uploadPath = 'static/uploads/posts/';
	private $response = array();
	
	public function __construct()
	{
		parent::__construct();
	}

	public function article_preview() {
		$this->upload_image('short');
	}

	public function article_image() {
		$this->upload_image('full');
	}

	private function upload_image($urlType) {

		if(!isset($_FILES['image'])) {
			exit();
		}

		$new_path = Date('Y').'/'.Date('m').'/'.Date('d');
		$file_folder = $this->uploadPath.$new_path;

		if (!file_exists($file_folder)) {
			mkdir($file_folder, 0777, true);
		}

		$config['upload_path']   = $file_folder;
		$config['allowed_types'] = 'jpg|jpeg|png|webp';
		$config['max_size']      = 2000;
		$config['max_width']     = 2000;
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
				
				if($data['image_width'] > 1000) {
					$resize_config['width'] = 1000;
				}else {
					$resize_config['width'] = $data['image_width'] - 1;
				}
				
				if($data['image_height'] > 500) {
					$data['image_height'] = 500;
				}else {
					$resize_config['height'] = $data['image_height'] - 1;
				}

				$resize_config['maintain_ratio']	= TRUE;
				$resize_config['create_thumb'] 		= FALSE;
				$resize_config['quality'] 			= '80%';

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
