<?php

class Api extends CI_Controller{
  function __construct(){
    return parent::__construct();
  }


  function login(){
    try{
      $post_data = json_decode(trim(file_get_contents('php://input')), true);
      $username = $post_data["username"];
      $password = $post_data["password"];
  
      $_error = $this->UserModel->login_user($username, $password);
      if($_error != $this->UserModel::user_error_ok)
        throw new Exception($_error);

      $response = [
        "ok" => "true"
      ];

      $this->output->set_status_header(200)->set_output(json_encode($response));
    }
    catch(Exception $e){
      $response = [
        "ok" => "false",
        "error" => (int)$e->getMessage()
      ];

      $this->output->set_status_header(400)->set_output(json_encode($response));
    }
  }
  
  function logoff(){
    $this->UserModel->delete_cookie_login();

    $response = [
      "ok" => "true"
    ];

    $this->output->set_status_header(200)->set_output(json_encode($response));
  }

  function signup(){
    try{
      $post_data = json_decode(trim(file_get_contents('php://input')), true);
      $username = $post_data["username"];
      $password = $post_data["password"];

      $_error = $this->UserModel->add_user($username, $password);
      if($_error != $this->UserModel::user_error_ok)
        throw new Exception($_error);

      $response = [
        "ok" => "true"
      ];

      $this->output->set_status_header(200)->set_output(json_encode($response));
    }
    catch(Exception $e){
      $response = [
        "ok" => "false",
        "error" => (int)$e->getMessage()
      ];

      $this->output->set_status_header(400)->set_output(json_encode($response));
    }
  }


  function user_exist(){
    $post_data = json_decode(trim(file_get_contents('php://input')), true);
  
    $_val = $this->UserModel->is_user_exist($post_data['username']);
    $response = Array(
      "is_exist" => $_val? "true": "false"
    );

    $this->output->set_status_header(200)->set_output(json_encode($response));
  }
}