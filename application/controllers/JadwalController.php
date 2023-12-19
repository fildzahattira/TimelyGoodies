<?php

class JadwalController extends Base_Controller{
  // 30 hari / 1 bulan
  const default_day_peek = 30;

  
  function __construct(){
    parent::__construct();

    $this->load->model("BarangModel");
    $this->load->model("DataJadwalModel");
    $this->load->model("KeranjangJadwalModel");
  }


  private function list_jadwal(){
    $list_jadwal = $this->DataJadwalModel->get_list_jadwal();
    if($list_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok){
      $this->error($list_jadwal["error"]);
      return;
    }

    $data_view = array(
      "DataJadwalModel" => $this->DataJadwalModel,
      "BarangModel" => $this->BarangModel,

      "list_jadwal_array" => $list_jadwal["data"]
    );

    $this->render_header("List Jadwal");
    $this->render_navbar();
    $this->load->view("v_list_jadwal", $data_view);
    $this->render_footer();
  }


  function jadwal(){
    $id_jadwal = $this->input->get("id");
    if($id_jadwal == NULL){
      $this->list_jadwal();
      return;
    }

    $data_jadwal = $this->DataJadwalModel->get_data_jadwal($id_jadwal);
    if($data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok){
      $this->error($data_jadwal["error"]);
      return;
    }
    
    $data_jadwal = $data_jadwal["data"];
    
    $list_barang = $this->DataJadwalModel->get_list_barang($id_jadwal);
    $list_barang_array = array();
    if($list_barang["error"] == DataJadwalModel::data_jadwal_error_ok)
      $list_barang_array = $list_barang["data"];
    
    $data_view = array(
      "BarangModel" => $this->BarangModel,
      "DataJadwalModel" => $this->DataJadwalModel,

      "data_jadwal" => $data_jadwal,
      "list_barang" => $list_barang_array
    );

    $this->render_header("Lihat Jadwal");
    $this->render_navbar();
    $this->load->view("v_lihat_jadwal", $data_view);
    $this->render_footer();
  }

  function edit_jadwal(){
    $id_jadwal = $this->input->get("id");
    if($id_jadwal == NULL){
      $this->error(Base_Controller::generic_error_parameter_error);
      return;
    }

    $data_jadwal = $this->DataJadwalModel->get_data_jadwal($id_jadwal);
    if($data_jadwal["error"] != Base_Controller::generic_error_ok){
      $this->error($data_jadwal["error"]);
      return;
    }
    
    $data_view = array(
      "tipe_page" => "edit",
      "prev_page_data" => $data_jadwal["data"] 
    );

    $this->render_header("Set Jadwal {$data_jadwal['data']['nama_jadwal']}");
    $this->render_navbar();
    $this->load->view("v_edit_jadwal_page", $data_view);
    $this->render_footer();
  }


  function add_jadwal(){
    if($this->UserModel->get_id() == NULL){
      $this->error(UserModel::user_error_not_logged_in);
      return;
    }

    $data_view = array(
      "tipe_page" => "create"
    );

    $this->render_header("Bikin Jadwal Baru");
    $this->render_navbar();
    $this->load->view("v_edit_jadwal_page", $data_view);
    $this->render_footer();
  }

  
  function index(){
    $this->jadwal();
  }
} 