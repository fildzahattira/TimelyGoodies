<?php

class IndexController extends Base_Controller{
  function __construct(){
    parent::__construct();
  }

  function index(){
    if($this->UserModel->is_log_in()){
      redirect(base_url("jadwal"));
    }
    else if($this->KurirModel->is_log_in()){
      redirect(base_url("pengantaran"));
    }
    else{
      $this->render_header("Welcome");
      $this->render_landing();
      $this->load->view("v_index");
      $this->render_footer();
    }
  }

    
  function login(){
    if($this->UserModel->is_log_in()){
      $this->error(UserModel::user_error_already_logged_in);
      return;
    }

    $data_view = array(
      "for" => "user"
    );

    $this->load->view("v_login", $data_view);
  }


  function kurir_login(){
    if($this->KurirModel->is_log_in()){
      $this->error(UserModel::user_error_already_logged_in);
      return;
    }

    $data_view = array(
      "for" => "kurir"
    );

    $this->load->view("v_login", $data_view);
  }


  function signup(){
    if($this->UserModel->is_log_in()){
      $this->error(UserModel::user_error_already_logged_in);
      return;
    }

    $this->load->view("v_signup");
  }

  function signout(){
    $this->UserModel->delete_cookie_login();
    redirect(base_url(""));
  }

  function kurir_signout(){
    $this->KurirModel->delete_cookie_login();
    redirect(base_url(""));
  }


  function render_landing(){
    $data = Array(
      "user_data" => $this->UserModel
    );
    
    $this->load->view("v_landing_page", $data);
    // $this->load->view("v_landing_page");
  }
}