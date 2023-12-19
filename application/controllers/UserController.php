<?php

class UserController extends Base_Controller{
  function __construct(){
    parent::__construct();
  }

  
  function profile(){
    if(!$this->UserModel->is_log_in()){
      $this->error(UserModel::user_error_not_logged_in);
      return;
    }

    $data_view = array(
      "user_data" => $this->UserModel
    );

    $this->render_header("User Profile");
    $this->render_navbar();
    $this->load->view("v_profile", $data_view);
    $this->render_footer();
  }

  function set_alamat(){
    if(!$this->UserModel->is_log_in()){
      $this->error(UserModel::user_error_not_logged_in);
      return;
    }

    $data_view = array(
      "user_data" => $this->UserModel
    );

    $this->render_header("Set Alamat");
    $this->render_navbar();
    $this->load->view("v_profile_set_alamat", $data_view);
    $this->render_footer();
  }

  function change_password(){
    if(!$this->UserModel->is_log_in()){
      $this->error(UserModel::user_error_not_logged_in);
      return;
    }
  
    $data_view = array(
      "user_data" => $this->UserModel
    );

    $this->render_header("Ganti Password");
    $this->render_navbar();
    $this->load->view("v_profile_change_password", $data_view);
    $this->render_footer();
  }


  function index(){
    $this->profile();
  }
}