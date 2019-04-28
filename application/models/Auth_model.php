<?php 
class Auth_model extends CI_Model {

     public function auth($email)
     {
        
        $this->db->where("email",$email);

        return $this->db->get("user")->result();
     }
}