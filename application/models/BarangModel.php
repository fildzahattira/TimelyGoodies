<?php

class BarangModel extends CI_Model{
  const barang_error_ok = 0x0;

  const barang_error_not_found = 0x301;
  const barang_error_images_not_found = 0x302;
  const barang_error_page_not_found = 0x303;


  function __construct(){
    parent::__construct();
  }


  function get_barang_image($id_barang){
    $this->db->where("id_barang", $id_barang);
    $image_list = $this->db->get("image_barang");

    if($image_list->num_rows() <= 0)
      return array("error" => BarangModel::barang_error_images_not_found);

    return array(
      "error" => BarangModel::barang_error_ok,
      "data" => $image_list->result_array()
    );
  }

  function get_barang($barang_id){
    $this->db->where('id_barang', $barang_id);
    $barang = $this->db->get("list_barang");

    if($barang->num_rows() <= 0)
      return array("error" => BarangModel::barang_error_not_found);

    $barang_data = $barang->row_array();
    $image_links = array();

    $image_list = $this->get_barang_image($barang_id);
    if($image_list["error"] != BarangModel::barang_error_images_not_found){
      foreach($image_list["data"] as $image){
        array_push($image_links, $image["link_image"]);
      }
    }

    $barang_data["image_links"] = $image_links;
    return array(
      "error" => BarangModel::barang_error_ok,
      "data" => $barang_data
    );
  }


  function get_barang_in_page($id_page){
    $query = $this->db->query("SELECT id_barang FROM list_barang WHERE id_page_barang = {$id_page};");

    if($query->num_rows() <= 0)
      return array("error" => BarangModel::barang_error_not_found);

    $tmp_page_barang = array();
    foreach($query->result_array() as $id_array){
      $barang = $this->get_barang($id_array["id_barang"]);
      if($barang["error"] != BarangModel::barang_error_ok)
        continue;

      $barang = $barang["data"];
      $idx = $barang["type_idx"];

      $tmp_page_barang["{$idx}"] = $barang;
    }
    
    sort($tmp_page_barang);
    $page_barang = array();
    foreach($tmp_page_barang as $barang)
      array_push($page_barang, $barang);

    return array(
      "error" => BarangModel::barang_error_ok,
      "data" => $page_barang
    );
  }
  

  // not used
  function set_barang_to_page($id_barang, $id_page){
    $this->db->where("id_barang", $id_barang);
    $barang_data = $this->db->get("list_barang");
    if($barang_data->num_rows() <= 0)
      return BarangModel::barang_error_not_found;
  
    $this->db->where("id_barang", $id_barang);
    $this->db->set("id_page_barang", $id_page);
    $this->db->update("list_barang");

    return BarangModel::barang_error_ok;
  }


  function is_barang_exist($id_barang){
    $this->db->where("id_barang", $id_barang);
    $barang_data = $this->db->get("list_barang");

    return $barang_data->num_rows() > 0;
  }
}