<?php


class ApiKeranjang extends Base_ApiController{
  function __construct(){
    parent::__construct();

    $this->load->model("DataJadwalModel");
  }


  private function get_jadwal_data_from_post(){
    return array(
      "nama_jadwal" => $this->param_post("nama_jadwal"),
      "interval_hari" => $this->param_post("interval_hari"),
      "list_hari" => $this->param_post("list_hari"),
      "tipe_interval" => $this->param_post("tipe_interval"),

      "tanggal_mulai" => $this->param_post("tanggal_mulai")
    );
  }


  protected $add_barang_postparamlist = array("id_jadwal", "id_barang");
  protected function add_barang(){
    $id_jadwal = $this->param_post("id_jadwal");
    $id_barang = $this->param_post("id_barang");

    $jumlah = $this->param_post("jumlah");
    if($jumlah != NULL)
      $jumlah = (int)$jumlah;

    $result_data = $this->DataJadwalModel->add_barang($id_jadwal, $id_barang, $jumlah);
    if($result_data["error"] != DataJadwalModel::data_jadwal_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true",
      "new_quantity" => $result_data["data"]["new_quantity"]
    );

    $this->send_response(200, $response);
  }

  protected $remove_barang_postparamlist = array("id_jadwal", "id_barang");
  protected function remove_barang(){
    $id_jadwal = $this->param_post("id_jadwal");
    $id_barang = $this->param_post("id_barang");

    $jumlah = $this->param_post("jumlah");
    if($jumlah != NULL)
      $jumlah = (int)$jumlah;

    $result_data = $this->DataJadwalModel->remove_barang($id_jadwal, $id_barang, (int)$jumlah);
    if($result_data["error"] != DataJadwalModel::data_jadwal_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true",
      "new_quantity" => $result_data["data"]["new_quantity"]
    );

    $this->send_response(200, $response);
  }

  protected $set_barang_quantity_postparamlist = array("id_jadwal", "id_barang", "jumlah");
  protected function set_barang_quantity(){
    $id_jadwal = $this->param_post("id_jadwal");
    $id_barang = $this->param_post("id_barang");
    $quantity = $this->param_post("jumlah");

    $result_data = $this->DataJadwalModel->set_barang_quantity($id_jadwal, $id_barang, $quantity);
    if($result_data["error"] != DataJadwalModel::data_jadwal_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true",
      "new_quantity" => $result_data["data"]["new_quantity"]
    );

    $this->send_response(200, $response);
  }

  protected $get_barang_quantity_postparamlist = array("id_jadwal", "id_barang");
  protected function get_barang_quantity(){
    $id_jadwal = $this->param_post("id_jadwal");
    $id_barang = $this->param_post("id_barang");

    $result_data = $this->DataJadwalModel->get_barang_quantity($id_jadwal, $id_barang);
    if($result_data["error"] != DataJadwalModel::data_jadwal_error_ok)
      $this->throw_error_code($result_data["error"]);

    $response = array(
      "ok" => "true",
      "quantity" => $result_data["data"]["quantity"]
    );

    $this->send_response(200, $response);
  }


  protected $create_jadwal_postparamlist = array("nama_jadwal", "interval_hari", "list_hari", "tipe_interval");
  protected function create_jadwal(){
    $data = $this->get_jadwal_data_from_post();

    $_err = $this->DataJadwalModel->add_data_jadwal($data);
    if($_err != DataJadwalModel::data_jadwal_error_ok)
      $this->throw_error_code($_err);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }

  protected $update_jadwal_postparamlist = array("id_jadwal", "nama_jadwal", "interval_hari", "list_hari", "tipe_interval");
  protected function update_jadwal(){
    $id_jadwal = $this->param_post("id_jadwal");
    $data = $this->get_jadwal_data_from_post();
    
    $_err = $this->DataJadwalModel->update_data_jadwal($id_jadwal, $data);
    if($_err != DataJadwalModel::data_jadwal_error_ok)
      $this->throw_error_code($_err);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }

  protected $remove_jadwal_postparamlist = array("id_jadwal");
  protected function remove_jadwal(){
    $id_jadwal = $this->param_post("id_jadwal");
    
    $result_data = $this->DataJadwalModel->remove_data_jadwal($id_jadwal);
    if($result_data != Base_Controller::generic_error_ok)
      $this->throw_error_code($result_data);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }
}