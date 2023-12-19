<?php

class ApiKurir extends Base_ApiUserController{
  private $secret_token = "DdJNvmkwgUQkKAuWIssySEsKW";

  private function check_secret_token(){
    $secret_token = $this->param_get("s");
    if($secret_token != $this->secret_token){
      $this->send_response(404);
      return false;
    }

    return true;
  }


  protected function signup(){
    if(!$this->check_secret_token()){
      $this->send_response(404);
      return;
    }

    parent::signup();
  }


  function __construct(){
    parent::__construct();

    $this->set_user_model($this->KurirModel);
    $this->load->model("PengantaranModel");
  }


  protected $ambil_pengiriman_postparamlist = array("id_pengiriman");
  protected function ambil_pengiriman(){
    $id_pengiriman = $this->param_post("id_pengiriman");

    $result_val = $this->PengantaranModel->set_pengantaran_kurir($id_pengiriman);
    if($result_val["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_val["error"]);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }

  protected $set_status_pengiriman_postparamlist = array("id_pengiriman", "status_pengriman");
  protected function set_status_pengiriman(){
    $id_pengiriman = $this->param_post("id_pengiriman");
    $status_pengiriman = $this->param_post("status_pengiriman");

    $result_val = $this->PengantaranModel->set_pengantaran_status_str($id_pengiriman, $status_pengiriman);
    if($result_val["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_val["error"]);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }


  protected $selesaikan_pengiriman_postparamlist = array("id_pengiriman", "keterangan");
  protected function selesaikan_pengiriman(){
    $id_pengiriman = $this->param_post("id_pengiriman");
    $keterangan = $this->param_post("keterangan");
    
    $result_val = $this->PengantaranModel->selesaikan_pengiriman($id_pengiriman, $keterangan);
    if($result_val["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_val["error"]);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }
}