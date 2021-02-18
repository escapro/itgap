<?php
defined('BASEPATH') or exit('No direct script access allowed');

require '../vendor/autoload.php';

class Oauth extends CI_Controller
{

    public function __construct()
    {
        // ПОКАЗАТЬ 404 ТАК-КАК КОНТРОЛЛЕР НЕ ГОТОВ!!!
        show_404();

        parent::__construct();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->library('ion_auth');
    }

    public function google($action)
    {

        $google_client = '';

        $google_client = new Google_Client();
        $google_client->setClientId('65985033255-7g7b93nlqa21ljj81lk25o9tf0rrha13.apps.googleusercontent.com');
        $google_client->setClientSecret('nlxkh_DAM2jbuTc-f1HAQM7y');
        $google_client->setRedirectUri($this->config->item('base_url') . '/oauth/google/redirect');
        $google_client->addScope('email');
        $google_client->addScope('profile');

        if ($action === 'connect') {
            redirect($google_client->createAuthUrl(), 'refresh');
        } else if ($action === 'redirect') {
            if (isset($_GET['code'])) {

                $token = $google_client->fetchAccessTokenWithAuthCode($_GET['code']);

                if (!isset($token['error'])) {
                    $google_client->setAccessToken($token);

                    $this->session->set_userdata('access_token', $token['access_token']);

                    $google_service = new Google_Service_Oauth2($google_client);

                    $data = $google_service->userinfo->get();

                    $this->ion_auth->register(
                        uniqid(),
                        'sdf',
                        $data['email'],
                        [
                            'first_name' => $data['givenName'],
                            'last_name' => $data['familyName']
                        ],
                        [3]);

                    // var_dump($data);
                }
            }
        }
    }
}
