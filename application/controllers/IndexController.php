<?php

class IndexController extends CI_Controller{
  function __construct(){
    return parent::__construct();
  }

  function index(){
    $this->render_header("Welcome");
    $this->render_navbar();
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

  
  function render_navbar(){
    $data = Array(
      "user_data" => $this->UserModel
    );

    $this->load->view("v_index_navbar", $data);
  }

  function render_header($page_title = ""){
    $data = array(
      "user_data" => $this->UserModel,
      "page_data" => array(
        "title" => $page_title
      )
    );

    $this->load->view("v_header", $data);
  }

  function render_footer(){
    $data = array(
      "user_data" => $this->UserModel
    );

    $this->load->view("v_footer", $data);
  }
}