<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class Auth extends API_Controller {
    
    
	public function __construct() {
		@parent::__construct();
        $this->load->library('authorization_token');
        $this->load->library('bcrypt');
        header("Access-Control-Allow-Origin: *");  
        $this->load->model('Auth_model','auth');
        $this->load->helper('post');         
    }

    public function login()
    {
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);

                       
        $user = $this->auth->auth(post('email'));

        if(empty($user)){
            return $this->api_return(
                [
                    'status' => false,
                    "result" => [
                        "message"=>"E-mail incorreto ou inválido"
                    ],                
                ],
              200);      
        }
                      
        
        if ($this->bcrypt->check_password(post('password'), $user[0]->password))
        {
            unset($user[0]->password);

            $payload = [
                'user' => $user            
            ];
            
            // generte a token
            $token = $this->authorization_token->generateToken($payload);
    
              return $this->api_return(
                [
                    'status' => true,
                    "result" => [
                        'token' => $token,
                    ],                
                ],
              200);
            
        }
        else
        {
            return $this->api_return(
                [
                    'status' => false,
                    "result" => [
                        "message"=>"Senha incorreta"
                    ],                
                ],
              200);
        }
        
        
    }
    
}