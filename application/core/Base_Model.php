<?php



class Base_Model extends CI_Model{
  // dummy model
}


class Base_UserModel extends CI_Model{
  const user_error_ok = 0x0;

  const user_error_already_exist = 0x101;
  const user_error_no_user = 0x102;
  const user_error_password_wrong = 0x103;
  const user_error_already_logged_in = 0x104;
  const user_error_not_logged_in = 0x105;
  const user_error_saldo_not_sufficient = 0x106;
  const expire_time = 60*60*1;

  private $_is_log_in = false;
  private $database_name = "";
  protected function get_database_name(){return $this->database_name;}

  private $id = NULL;
  public function get_id(){return $this->id;}

  private $username = NULL;
  public function get_username(){return $this->username;}

  private $date_created = NULL;
  public function get_date_created(){return $this->date_created;}


  private function _create_cookie_login($user_data){
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

  private function _bind_user($user_data){
    $cookie_login = $this->_create_cookie_login($user_data);

    $this->input->set_cookie('cookie_login', $cookie_login, self::expire_time);

    $this->db->set('cookie_login', $cookie_login);
    $this->db->where('id', $user_data->id);
    $this->db->update($this->database_name);
  }

  private function _get_user(){
    $cookie_login = $this->input->cookie('cookie_login');
    if($cookie_login == NULL)
      return false;

    $user_data = $this->db->get_where($this->database_name, array('cookie_login' => $cookie_login), 1);
    if($user_data->num_rows() <= 0)
      return false;

    foreach(get_object_vars($user_data->row()) as $name=>$value)
      if(property_exists($this, $name))
        $this->$name = $value;

    $this->_is_log_in = true;
  }


  protected function _set_database($db_name){
    if($this->database_name == "")
      $this->database_name = $db_name;
  }


  function __construct(){
    parent::__construct();

    $this->load->helper('cookie');
    $this->_get_user();
  }


  public function delete_cookie_login(){
    delete_cookie("cookie_login");
  }

  
  public function add_user($username, $password, $additional_data = NULL){
    if($this->is_user_exist($username))
      return self::user_error_already_exist;
    
    $data = Array(
      'username' => $username,
      'hashed_password' => password_hash($password, PASSWORD_DEFAULT)
    );

    $this->db->insert($this->database_name, $data);
    return self::user_error_ok;
  }

  public function login_user($username, $password){
    if($this->is_log_in())
      return self::user_error_already_logged_in;
    
    $data_user = $this->db->get_where($this->database_name, array('username' => $username), 1);

    if($data_user->num_rows() <= 0)
      return self::user_error_no_user;
    
    $user = $data_user->row();
    if(!password_verify($password, $user->hashed_password))
      return self::user_error_password_wrong;

    $this->_bind_user($user);
    return self::user_error_ok;
  }


  public function change_password($last_password, $new_password){
    if(!$this->is_log_in())
      return self::user_error_not_logged_in;
    
    $this->db->where("id", $this->get_id());
    $data_user = $this->db->get($this->database_name);

    if($data_user->num_rows() <= 0)
      return self::user_error_no_user;

    $data_user = $data_user->row_array();
    if(!password_verify($last_password, $data_user["hashed_password"]))
      return self::user_error_password_wrong;

    $new_data = array(
      "hashed_password" => password_hash($new_password, PASSWORD_DEFAULT)
    );

    $this->db->where("id", $this->get_id());
    $this->db->update($this->database_name, $new_data);
    return self::user_error_ok;
  }


  public function is_user_exist($username){
    $this->db->where('username', $username);
    $check_user = $this->db->get($this->database_name);

    return $check_user->num_rows() > 0;
  }

  public function is_log_in(){
    return $this->_is_log_in;
  }

  public function get_user_data($id_user){
    $this->db->where("id", $id_user);
    $data_user = $this->db->get($this->database_name);
    if($data_user->num_rows() <= 0)
      return array("error" => self::user_error_no_user);

    return array(
      "error" => self::user_error_ok,
      "data" => $data_user->row_array()
    );
  }
}