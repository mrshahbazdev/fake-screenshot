<?php
class User_model extends CI_Model {
    
    public function __construct() {
        $this->load->database();
    }
    
    public function get_users($limit, $start) {
        $this->db->select('username, email, subscription_end');
        $this->db->from('users');
        $this->db->limit($limit, $start);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_user_count() {
        return $this->db->count_all('users');
    }
    
    public function register_user($username, $password, $email) {
        $data = [
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'email' => $email,
            'subscription_status' => 'inactive'
        ];
        // Check if username or email already exists
        $this->db->where('username', $data['username']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return false; // Username already exists
        }

        $this->db->where('email', $data['email']);
        $query = $this->db->get('users');
        if ($query->num_rows() > 0) {
            return false; // Email already exists
        }
        
        $this->db->insert('users', $data);
        return $this->db->insert_id(); // Get the last inserted ID
    }
    
    public function activate_subscription($user_id, $days) {
        $end_date = date('Y-m-d', strtotime("+$days days"));

        // Update user subscription status
        $this->db->where('id', $user_id);
        $this->db->update('users', [
            'subscription_status' => 'active',
            'subscription_end' => $end_date
        ]);

        // Insert subscription record
        $this->db->insert('subscriptions', [
            'user_id' => $user_id,
            'start_date' => date('Y-m-d'),
            'end_date' => $end_date
        ]);
    }
    
    public function get_user_by_username($username) {
        $query = $this->db->get_where('users', ['username' => $username]);
        return $query->row_array();
    }
    
    public function get_user_by_id($user_id) {
        $query = $this->db->get_where('users', ['id' => $user_id]);
        return $query->row_array();
    }
}
