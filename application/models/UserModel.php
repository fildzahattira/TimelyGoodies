<?php

class UserModel extends CI_Model{
  const user_error_ok = 0x0;

  const user_error_already_exist = 0x101;
  const user_error_no_user = 0x102;
  const user_error_password_wrong = 0x103;
  const user_error_already_logged_in = 0x104;
  const user_error_not_logged_in = 0x105;
  const expire_time = 60*60*1;

  private $is_logged_in = false;

  public $id = NULL;
  public $username = NULL;
  public $date_created = NULL;


  function _create_cookie_login($user_data){
    $cookie_login = "";
    $hash_value = $user_data->hashed_password;
    foreach(str_split($hash_value) as $char){
      $random_char = "";
      $random_number = rand(10, 1000) + ord($char);
      if(($random_number % 2) == 1)
        $random_char = chr(($random_number % 26) + ord("a"));
      else
        $random_char = chr(($random_number % 26) + ord("A"));

      $cookie_login = $random_char . $cookie_login;
    }

    return $cookie_login;
  }

  function _bind_user($user_data){
    $cookie_login = $this->_create_cookie_login($user_data);

    $this->input->set_cookie('cookie_login', $cookie_login, self::expire_time);

    $this->db->set('cookie_login', $cookie_login);
    $this->db->where('id', $user_data->id);
    $this->db->update('user_data');
  }

  function _get_user(){
    $cookie_login = $this->input->cookie('cookie_login');
    if($cookie_login == NULL)
      return false;

    $user_data = $this->db->get_where("user_data", array('cookie_login' => $cookie_login), 1);
    if($user_data->num_rows() <= 0)
      return false;

    foreach(get_object_vars($user_data->row()) as $name=>$value)
      if(property_exists($this, $name))
        $this->$name = $value;

    $this->is_logged_in = true;
  }

  function __construct(){
    $this->load->helper('cookie');
    $this->_get_user();

    return parent::__construct();
  }


  function delete_cookie_login(){
    delete_cookie("cookie_login");
  }

  function login_user($username, $password){
    if($this->is_log_in())
      return self::user_error_already_logged_in;
    
    $data_user = $this->db->get_where('user_data', array('username' => $username), 1);

    if($data_user->num_rows() <= 0)
      return self::user_error_no_user;
    
    $user = $data_user->row();
    if(!password_verify($password, $user->hashed_password))
      return self::user_error_password_wrong;

    $this->_bind_user($user);
    return self::user_error_ok;
  }

  function is_user_exist($username){
    $this->db->where('username', $username);
    $check_user = $this->db->get("user_data");

    return $check_user->num_rows() > 0;
  }

  function is_log_in(){
    return $this->is_logged_in;
  }
  
  function add_user($username, $password, $additional_data = NULL){
    if($this->is_user_exist($username))
      return self::user_error_already_exist;
    
    $data = Array(
      'username' => $username,
      'hashed_password' => password_hash($password, PASSWORD_DEFAULT)
    );

    $this->db->insert('user_data', $data);
    return self::user_error_ok;
  }
}