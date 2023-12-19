<?php

class SecretApi extends Base_ApiController{
  private $secret_token = "EBZSIMBsrkVPQulbygiDlCAGZ";

  function __construct(){
    parent::__construct();

    $this->load->model("DataJadwalModel");
    $this->load->model("PengantaranModel");
    $this->load->model("KeranjangJadwalModel");
    //$this->load->model("KeranjangPengantaranModel");
  }


  private function check_secret_token(){
    $secret_token = $this->param_get("s");
    if($secret_token != $this->secret_token){
      $this->send_response(404);
      return false;
    }

    return true;
  }

  
  // daily_check_jadwaldaily_check_jadwal
  protected $dcj_getparamlist = array("s");
  protected function dcj(){
    if(!$this->check_secret_token())
      return;
    

    // check late
    $list_pengantaran = $this->PengantaranModel->bypass_get_list_pengantaran_yesterday(array(
      PengantaranModel::status_idle,
      PengantaranModel::status_diproses,
      PengantaranModel::status_diantar
    ));

    foreach($list_pengantaran as $pengantaran){
      $id_pengantaran = $pengantaran["id_pengantaran"];
      $this->PengantaranModel->bypass_set_status(
        $id_pengantaran,
        PengantaranModel::status_telat
      );
    }

    
    // add pengiriman
    $list_jadwal = $this->DataJadwalModel->bypass_get_list_jadwal_today();
    foreach($list_jadwal as $jadwal){
      $new_status = NULL;
      $id_jadwal = $jadwal["id_jadwal"];
      $id_user = $jadwal["id_user"];
      
      $list_barang = $this->KeranjangJadwalModel->get_barang_in_jadwal($id_jadwal);
      if(sizeof($list_barang) > 0){

      }
      else{
        $new_status = PengantaranModel::status_str_enum[PengantaranModel::status_tidak_ada_barang];
      }

      $total_harga = $this->KeranjangJadwalModel->get_total_harga($id_jadwal);
      if($total_harga["error"] != Base_Controller::generic_error_ok)
        continue;

      $user_data = $this->UserModel->get_user_data($id_user);
      if($user_data["error"] != Base_Controller::generic_error_ok)
        continue;

      $total_harga = $total_harga["data"]["harga"];
      $user_saldo = $user_data["data"]["total_saldo"];
      if($total_harga <= $user_saldo){
        $this->UserModel->bypass_reduce_saldo($id_user, $total_harga);
      }
      else{
        $new_status = PengantaranModel::status_str_enum[PengantaranModel::status_saldo_tidak_cukup];
      }

      $this->PengantaranModel->bypass_add_pengantaran($id_jadwal, $new_status);
    }
  }
}