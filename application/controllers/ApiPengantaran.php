<?php

class ApiPengantaran extends Base_ApiController{
  function __construct(){
    parent::__construct();

    $this->load->model("PengantaranModel");
  }


  protected $set_status_postparamlist = array("id_pengantaran", "status");
  protected function set_status(){
    $id_pengantaran = $this->param_post("id_pengantaran");
    $status = $this->param_post("status");

    $result_data = $this->PengantaranModel->set_pengantaran_status_str($id_pengantaran, $status);
    if($result_data["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_data["error"]);
  
    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }

  protected $ambil_pengantaran_postparamlist = array("id_pengantaran");
  protected function ambil_pengantaran(){
    $id_pengantaran = $this->param_post("id_pengantaran");
    
    $result_data = $this->PengantaranModel->set_pengantaran_kurir($id_pengantaran);
    if($result_data["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }

  protected $selesaikan_pengantaran_postparamlist = array("id_pengantaran", "keterangan");
  protected function selesaikan_pengantaran(){
    $id_pengantaran = $this->param_post("id_pengantaran");
    $keterangan = $this->param_post("keterangan");

    $result_data = $this->PengantaranModel->selesaikan_pengiriman($id_pengantaran, $keterangan);
    if($result_data["error"] != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }
}