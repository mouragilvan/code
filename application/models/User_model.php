<?php 
class User_model extends CI_Model {

    
    private $username;
    private $email;
    private $password;

    public function all()
    {
           $query = $this->db->get('user');
           return $query->result();
    }

    public function findByEmail($email)
    {
        $this->db->where('email',$email);
        return $this->db->get('user')->result();
    }

    public function create($data)
    {   
                
        $this->db->insert('user', $data);
        $id = $this->db->insert_id();
        $this->db->select("id, username, email");
        $this->db->where("id",$id);
        return $this->db->get("user")->result();
    }
    
    public function get_last_ten_entries()
    {
            //$query = $this->db->get('entries', 10);
            //return $query->result();
    }
    
   
}