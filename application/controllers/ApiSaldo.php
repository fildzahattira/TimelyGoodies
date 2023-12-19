<?php

class ApiSaldo extends Base_ApiController{
  function __construct(){
    parent::__construct();

    $this->load->model("SaldoModel");
  }


  protected $add_saldo_postparamlist = array("saldo");
  protected function add_saldo(){
    $saldo = $this->param_post("saldo");
    $result_data = $this->SaldoModel->add_saldo($saldo);
    if($result_data["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }
}