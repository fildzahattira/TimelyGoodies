<?php

class KategoriModel extends CI_Model{
  const kategori_error_not_found = 0x701;
  
  function __construct(){
    parent::__construct();
  }


  function get_list_kategori(){
    $list_kategori = $this->db->get("kategori_barang");
    if($list_kategori->num_rows() <= 0)
      return array("error" => KategoriModel::kategori_error_not_found);

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $list_kategori->result_array()
    );
  }


  function get_list_page_in_kategori($id_kategori){
    $this->db->where("id_kategori", $id_kategori);
    $kategori = $this->db->get("kategori_barang");
    if($kategori->num_rows() <= 0)
      return array("error" => KategoriModel::kategori_error_not_found);

    $this->db->select("id_page");
    $this->db->where("id_kategori", $id_kategori);
    $list_page = $this->db->get("page_barang");

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data_kategori" => $kategori->row_array(),
      "list_id_page" => $list_page->result_array()
    );
  }
}