<?php

class Base_Controller extends CI_Controller{
<<<<<<< HEAD
  const generic_error_ok = 0x0;
  const generic_error_server_error = 0x1;
  const generic_error_internal_error = 0x2;
  const generic_error_parameter_error = 0x3;
  

  function __construct(){
    parent::__construct();
  }


  protected function error($error_code){
    echo "error code: {$error_code}";
  }
  

  public function render_navbar(){
    $data = Array(
      "user_data" => $this->UserModel,
      "kurir_data" => $this->KurirModel
    );

    $this->load->view("v_navbar", $data);
  }

  public function render_header($page_title = ""){
=======
  function __construct(){
    return parent::__construct();
  }
  

  function render_navbar(){
    $data = Array(
      "user_data" => $this->UserModel
    );

    $this->load->view("v_index_navbar", $data);
  }

  function render_header($page_title = ""){
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
    $data = array(
      "user_data" => $this->UserModel,
      "page_data" => array(
        "title" => $page_title
      )
    );

    $this->load->view("v_header", $data);
  }

<<<<<<< HEAD
  public function render_footer(){
=======
  function render_footer(){
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
    $data = array(
      "user_data" => $this->UserModel
    );

    $this->load->view("v_footer", $data);
  }
<<<<<<< HEAD

  public function on_error(){

  }
}





class api_error extends Exception{
  public $error_data = array();

  function __construct($data){
    $this->error_data = $data;
  }
}


class Base_ApiController extends CI_Controller{
  private const error_type_code = 0x0;


  private $post_data = array();

  function __construct(){
    parent::__construct();

    $this->post_data = json_decode(trim(file_get_contents('php://input')), true);
  }


  protected function param_get($param_name){
    return $this->input->get($param_name);
  }

  protected function param_post($param_name){
    if(!isset($this->post_data[$param_name]))
      return NULL;

    return $this->post_data[$param_name];
  }

  protected function postparamlist_check($function_name){
    $paramlist_varname = $function_name . "_postparamlist";
    if(isset($this->$paramlist_varname)){
      foreach($this->$paramlist_varname as $paramname){
        if($this->param_post($paramname) == NULL)
          $this->throw_error_code(Base_Controller::generic_error_parameter_error);
      }
    }

    return;
  }

  protected function getparamlist_check($function_name){
    $paramlist_varname = $function_name . "_getparamlist";
    if(isset($this->$paramlist_varname)){
      foreach($this->$paramlist_varname as $paramname){
        if($this->param_get($paramname) == NULL)
          $this->throw_error_code(Base_Controller::generic_error_parameter_error);
      }
    }

    return;
  }


  protected function throw_error_code($error_code){
    throw new api_error(array(
      "err_type" => Base_ApiController::error_type_code,
      "err_code" => $error_code
    ));
  }


  protected function send_response($status_header, $output = array()){
    $this->output->set_status_header($status_header)->set_output(json_encode($output));
  }


  public function start_api(){
    $function_name = $this->param_get("function");
    if($function_name == NULL){
      $this->send_response(400);
      return;
    }

    if(!method_exists($this, $function_name)){
      $this->send_response(404);
      return;
    }
    

    try{
      $this->getparamlist_check($function_name);
      $this->postparamlist_check($function_name);

      $this->$function_name();
    }
    catch(api_error $e){
      $err_data = $e->error_data;
      
      $response = array();
      switch($err_data["err_type"]){
        case Base_ApiController::error_type_code:
          $response = [
            "ok" => "false",
            "error" => (int)$err_data["err_code"]
          ];

          break;
      }

      $this->send_response(400, $response);
    }
    catch(Exception $e){
      $this->send_response(500);
    }
  }
}


class Base_ApiUserController extends Base_ApiController{
  private $base_user_model = NULL;


  function __construct(){
    parent::__construct();
  }

  protected function set_user_model($user_model){
    if($this->base_user_model == NULL)
      $this->base_user_model = $user_model;
  }

  

  protected $login_postparamlist = array("username", "password");
  protected function login(){
    $username = $this->param_post("username");
    $password = $this->param_post("password");

    $_error = $this->base_user_model->login_user($username, $password);
    if($_error != Base_UserModel::user_error_ok)
      $this->throw_error_code($_error);

    $response = [
      "ok" => "true"
    ];

    $this->send_response(200, $response);
  }

  protected function logoff(){
    $this->base_user_model->delete_cookie_login();
    $response = [
      "ok" => "true"
    ];

    $this->send_response(200, $response);
  }


  protected $signup_postparamlist = array("username", "password");
  protected function signup(){
    $username = $this->param_post("username");
    $password = $this->param_post("password");

    $_error = $this->base_user_model->add_user($username, $password);
    if($_error != Base_UserModel::user_error_ok)
      $this->throw_error_code($_error);

    $response = [
      "ok" => "true"
    ];

    $this->send_response(200, $response);
  }


  protected $user_exist_postparamlist = array("username");
  protected function user_exist(){
    $_val = $this->base_user_model->is_user_exist($this->param_post('username'));
    $response = array(
      "is_exist" => $_val? "true": "false"
    );

    $this->send_response(200, $response);
  }


  protected $change_password_postparamlist = array("last_password", "new_password");
  protected function change_password(){
    $new_password = $this->param_post("new_password");
    $last_password = $this->param_post("last_password");
    
    $_val = $this->base_user_model->change_password($last_password, $new_password);
    if($_val != Base_UserModel::user_error_ok)
      $this->throw_error_code($_val);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }
=======
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
}