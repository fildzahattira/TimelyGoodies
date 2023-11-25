<?php

class PageModel extends CI_Model{
  const page_error_ok = 0x0;

  const page_error_not_found = 0x201;
  const page_error_no_item = 0x202;



  function __construct(){
    $this->load->model("BarangModel");

    return parent::__construct();
  }
  
  function get_page_data($id_page){
    $this->db->where("id_page", $id_page);
    $page_data = $this->db->get("page_barang");
    
    if($page_data->num_rows() <= 0)
      return PageModel::page_error_not_found;
  
    $list_barang = $this->BarangModel->get_barang_in_page($id_page);
    if($list_barang == BarangModel::barang_error_not_found)
      return PageModel::page_error_no_item;
  
    return array(
      "page_data" => $page_data->row_array(),
      "barang_data" => $list_barang
    );
  }


  function add_page($data_page, $list_id_barang){

  }

  function remove_page($id_page){

  }


  function add_barang_to_page($id_page, $id_barang){
    $this->BarangModel->set_barang_to_page($id_barang, $id_page);
  }
}