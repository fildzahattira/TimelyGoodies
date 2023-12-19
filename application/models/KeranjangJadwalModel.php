<?php

class KeranjangJadwalModel extends CI_Model{
  const keranjang_jadwal_error_ok = 0x0;

  const keranjang_jadwal_error_barang_not_found = 0x501;
  

  function __construct(){
    parent::__construct();
  }

  
  
  private function get_id_keranjang($id_jadwal, $id_barang){
    return "{$id_jadwal}.{$id_barang}";
  }
  
  private function split_id_keranjang($id_keranjang){
    $id_jadwal = 0;
    $id_barang = 0;

    $splitted = explode(".", $id_keranjang);

    $id_jadwal = $splitted[0];
    if(sizeof($splitted) >= 2)
      $id_barang = $splitted[1];

    return array(
      "id_jadwal" => $id_jadwal,
      "id_barang" => $id_barang
    );
  }


  // default $jumlah, 1
  function add_barang($id_jadwal, $id_barang, $quantity = NULL){
    if($quantity == NULL) 
      $quantity = 1;

    $id_keranjang = $this->get_id_keranjang($id_jadwal, $id_barang);
    $new_data = Array(
      "id_keranjang" => $id_keranjang,
      "id_jadwal" => $id_jadwal,
      "id_barang" => $id_barang
    );

    $new_quantity = 0;
    

    $this->db->where("id_keranjang", $id_keranjang);
    $data_barang = $this->db->get("keranjang_jadwal");
    if($data_barang->num_rows() > 0){
      $current_data = $data_barang->row_array();
      
      $new_quantity = ((int)$current_data["jumlah"] + (int)$quantity);
      $new_data["jumlah"] = $new_quantity;

      $this->db->where("id_keranjang", $id_keranjang);
      $this->db->update("keranjang_jadwal", $new_data);
    }
    else{
      $new_quantity = (int)$quantity;

      $new_data["jumlah"] = $new_quantity;
      $this->db->insert("keranjang_jadwal", $new_data);
    }

    return array(
      "error" => KeranjangJadwalModel::keranjang_jadwal_error_ok,
      "data" => array(
        "new_quantity" => $new_quantity
      )
    );
  }

  // default $jumlah, semua
  function remove_barang($id_jadwal, $id_barang, $quantity = NULL){
    $id_keranjang = $this->get_id_keranjang($id_jadwal, $id_barang);

    $this->db->where("id_keranjang", $id_keranjang);
    $data_barang = $this->db->get("keranjang_jadwal");
    if($data_barang->num_rows() <= 0)
      return array("error" => KeranjangJadwalModel::keranjang_jadwal_error_barang_not_found);

    $current_data = $data_barang->row_array();
    if($quantity == NULL)
      $quantity = $current_data["jumlah"];

    $new_quantity = 0;
    if($quantity < $current_data["jumlah"]){
      $new_quantity = ((int)$current_data["jumlah"] - (int)$quantity);

      $new_data = array(
        "jumlah" => $new_quantity
      );

      $this->db->where("id_keranjang", $id_keranjang);
      $this->db->update("keranjang_jadwal", $new_data);
    }
    else{
      $new_quantity = 0;

      $this->db->delete("keranjang_jadwal", array("id_keranjang" => $id_keranjang));
    }

    return array(
      "error" => KeranjangJadwalModel::keranjang_jadwal_error_ok,
      "data" => array(
        "new_quantity" => $new_quantity
      )
    );
  }

  function set_barang_quantity($id_jadwal, $id_barang, $quantity){
    $id_keranjang = $this->get_id_keranjang($id_jadwal, $id_barang);

    $this->db->where("id_keranjang", $id_keranjang);
    $data_barang = $this->db->get("keranjang_jadwal");
    if($data_barang->num_rows() <= 0)
      return array("error" => KeranjangJadwalModel::keranjang_jadwal_error_barang_not_found);

    if($quantity <= 0)
      $quantity = 1;

    $new_data = array(
      "jumlah" => $quantity
    );

    $this->db->where("id_keranjang", $id_keranjang);
    $this->db->update("keranjang_jadwal", $new_data);
    return array(
      "error" => KeranjangJadwalModel::keranjang_jadwal_error_ok,
      "data" => array(
        "new_quantity" => $quantity
      )
    ); 
  }


  function get_barang_quantity($id_jadwal, $id_barang){
    $id_keranjang = $this->get_id_keranjang($id_jadwal, $id_barang);

    $this->db->where("id_keranjang", $id_keranjang);
    $data_barang = $this->db->get("keranjang_jadwal");
    if($data_barang->num_rows() <= 0)
      return array("error" => KeranjangJadwalModel::keranjang_jadwal_error_barang_not_found);

    $data_barang = $data_barang->row_array();
    return array(
      "error" => KeranjangJadwalModel::keranjang_jadwal_error_ok,
      "data" => array(
        "quantity" => $data_barang["jumlah"]
      )
    );
  }


  function get_barang_in_jadwal($id_jadwal){
    $this->db->where("id_jadwal", $id_jadwal);
    return $this->db->get("keranjang_jadwal")->result_array();
  }

  
  function get_total_harga($id_jadwal){
    $this->db->where("id_jadwal", $id_jadwal);
    $list_barang = $this->db->get("keranjang_jadwal");
    if($list_barang->num_rows() <= 0)
      return array("error" => KeranjangJadwalModel::keranjang_jadwal_error_barang_not_found);

    $total_harga = 0;
    $list_barang = $list_barang->result_array();
    foreach($list_barang as $barang){
      $this->db->where("id_barang", $barang["id_barang"]);
      $barang_data = $this->db->get("list_barang");
      if($barang_data->num_rows() <= 0)
        continue;

      $barang_data = $barang_data->row_array();
      $total_harga += (int)$barang_data["harga_barang"];
    }

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => array(
        "harga" => $total_harga
      )
    );
  }
}