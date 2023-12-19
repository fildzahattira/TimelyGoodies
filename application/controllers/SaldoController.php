<?php

class SaldoController extends Base_Controller{
  function __construct(){
    parent::__construct();

    $this->load->model("SaldoModel");
  }


  function add_saldo(){
    if(!$this->UserModel->is_log_in()){
      $this->error(Base_UserModel::user_error_not_logged_in);
      return;
    }

    $data_view = array(
      "max_saldo" => $this->SaldoModel->get_min_saldo_add()
    );

    $this->render_header("Tambah Saldo");
    $this->render_navbar();
    $this->load->view("v_add_saldo", $data_view);
    $this->render_footer();
  }

  function saldo(){
    if(!$this->UserModel->is_log_in()){
      $this->error(Base_UserModel::user_error_not_logged_in);
      return;
    }

    $data_view = array(
      "user_data" => $this->UserModel
    );

    $this->render_header("Saldo");
    $this->render_navbar();
    $this->load->view("v_lihat_saldo", $data_view);
    $this->render_footer();
  }


  function index(){
    $this->saldo();
  }
}