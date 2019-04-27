<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH . '/libraries/API_Controller.php';

class Login extends API_Controller {
    
    
	public function __construct() {
		@parent::__construct();
        $this->load->library('authorization_token');
        $this->load->library('bcrypt');
        header("Access-Control-Allow-Origin: *");  
        $this->load->model('User_model','user');
        $this->load->helper('post');         

    }
    

    public function store()
    {
        // API Configuration
         $this->_apiConfig([
             'methods' => ['POST'],
         ]);

         $data = post();

         $data['password'] = $hash = $this->bcrypt->hash_password($data['password']);
                 
         $payload = [
            'user' => $this->user->create($data)            
        ];
		
		// generte a token
        $token = $this->authorization_token->generateToken($payload);
    

        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'token' => $token,
                ],                
            ],
        200);
    }
	
	public function index()
	{
		
		//header("Access-Control-Allow-Origin: *");
        // API Configuration
        $this->_apiConfig([
            'methods' => ['POST'],
        ]);
        // you user authentication code will go here, you can compare the user with the database or whatever
        $payload = [
            'id' => 21,
            'other' => "Some other data"
        ];
		
		// generte a token
        $token = $this->authorization_token->generateToken($payload);
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'token' => $token,
                ],
                
            ],
        200);		
		//$this->load->model('User_model','user');

		//echo json_encode($this->user->all());
	}

	public function view()
    {
        
        // API Configuration [Return Array: User Token Data]
        $user_data = $this->_apiConfig([
            'methods' => ['POST'],
            'requireAuthorization' => true,
        ]);
        // return data
        $this->api_return(
            [
                'status' => true,
                "result" => [
                    'user_data' => $user_data['token_data']
                ],
            ],
        200);
    }
}
