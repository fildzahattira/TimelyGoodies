<?php

class SaldoModel extends CI_Model{
  const max_saldo = 10000;

  function __construct(){
    parent::__construct();
  }


  function get_min_saldo_add(){
    return SaldoModel::max_saldo;
  }


  function add_saldo($jumlah_saldo){
    if(!$this->UserModel->is_log_in())
      return array("error" => Base_UserModel::user_error_not_logged_in);

    $new_data = array(
      "id_user" => $this->UserModel->get_id(),
      "saldo" => $jumlah_saldo
    );

    $this->db->insert("struk_saldo", $new_data);
    return array("error" => Base_Controller::generic_error_ok);
  }
}