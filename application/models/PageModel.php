<?php

class PageModel extends CI_Model{
  const page_error_ok = 0x0;

  const page_error_not_found = 0x201;
  const page_error_no_item = 0x202;



  function __construct(){
    parent::__construct();
    
    $this->load->model("BarangModel");
  }


  function get_page_image_list($id_page){
    $result = array();

    $this->db->where("id_page_barang", $id_page);
    $barang_list = $this->db->get("list_barang");
    foreach($barang_list->result_array() as $barang){
      $id_barang = $barang["id_barang"];
      $this->db->where("id_barang", $id_barang);
      $image_list = $this->db->get("image_barang");
      foreach($image_list->result_array() as $image){
        array_push($result, $image["link_image"]);
      }
    }

    return $result;
  }

  function get_page_harga_list($id_page){
    $result = array();

    $this->db->where("id_page_barang", $id_page);
    $barang_list = $this->db->get("list_barang");
    foreach($barang_list->result_array() as $barang){
      $harga_barang = $barang["harga_barang"];
      array_push($result, $harga_barang);
    }

    sort($result);
    return $result;
  }

  
  function get_page_data($id_page){
    $this->db->where("id_page", $id_page);
    $page_data = $this->db->get("page_barang");
    
    if($page_data->num_rows() <= 0)
      return Array("error" => PageModel::page_error_not_found);
  
    $list_barang = $this->BarangModel->get_barang_in_page($id_page);
    if($list_barang["error"] == BarangModel::barang_error_not_found)
      return Array("error" => PageModel::page_error_no_item);
  
    return Array(
      "error" => PageModel::page_error_ok,
      "data" => array(
        "page_data" => $page_data->row_array(),
        "barang_data" => $list_barang["data"]
      )
    );
  }

  function get_page_data_with_metadata($id_page){
    $page_data = $this->get_page_data($id_page);
    if($page_data["error"] != Base_Controller::generic_error_ok)
      return $page_data;
    
    $new_page_data = $page_data["data"]["page_data"];
    $new_page_data["image_links"] = $this->get_page_image_list($id_page);
    $new_page_data["harga_list"] = $this->get_page_harga_list($id_page);

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => array(
        "page_data" => $new_page_data,
        "barang_data" => $page_data["data"]["barang_data"]
      )
    );
  }


  function search_barang($search_term){
    $search_term = strtolower($search_term);
    $search_result = $this->db->query("SELECT id_page FROM page_barang WHERE tags LIKE '%{$search_term}%'");
    if($search_result->num_rows() <= 0)
      return array("error" => PageModel::page_error_not_found);

    $page_data_array = array();
    $search_result_array = $search_result->result_array();
    foreach($search_result_array as $page_data){
      $id_page = $page_data["id_page"];

      $new_page_data = $this->get_page_data_with_metadata($id_page);
      if($new_page_data["error"] != Base_Controller::generic_error_ok)
        continue;

      array_push($page_data_array, $new_page_data["data"]);
    }

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $page_data_array
    );
  }


  function get_list_barang(){
    $this->db->select("id_page");
    $list_id = $this->db->get("page_barang");
    if($list_id->num_rows() <= 0)
      return array("error" => PageModel::page_error_not_found);

    $page_data_array = array();
    $list_id_array = $list_id->result_array();
    foreach($list_id_array as $id_array){
      $id_page = $id_array["id_page"];
      
      $new_page_data = $this->get_page_data_with_metadata($id_page);
      if($new_page_data["error"] != Base_Controller::generic_error_ok)
        continue;

      array_push($page_data_array, $new_page_data);
    }

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $page_data_array
    );
  }


  // not used
  function add_barang_to_page($id_page, $id_barang){
    $this->BarangModel->set_barang_to_page($id_barang, $id_page);
  }
}