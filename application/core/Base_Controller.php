<?php

class Base_Controller extends CI_Controller{
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