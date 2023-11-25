<?php

class IndexController extends Base_Controller{
  function __construct(){
    return parent::__construct();
  }

  function index(){
    $this->render_header("Welcome");
    $this->render_landing();
    // $this->render_navbar();
    $this->load->view("v_index");
    $this->render_footer();
  }

    
  function login(){
    $this->render_header("Login");
    $this->load->view("v_login");
    $this->render_footer();
  }

  function signup(){
    $this->render_header("Signup");
    $this->load->view("v_signup");
    $this->render_footer();
  }

  function signout(){
    $this->UserModel->delete_cookie_login();
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