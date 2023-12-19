<?php


class BarangController extends Base_Controller{
<<<<<<< HEAD
  function __construct(){
    parent::__construct();

    $this->load->model("PageModel");
    $this->load->model("KategoriModel");
  }

  protected function list_barang(){
    $list_barang = $this->PageModel->get_list_barang();
    
    if($list_barang["error"] !=  PageModel::page_error_ok){
      $this->error($list_barang["error"]);
      return;
    }

    $data_view = array(
      "list_barang" => $list_barang["data"]
    );

    $this->render_header("List Barang");
    $this->render_navbar();
    $this->load->view("v_list_barang", $data_view);
    $this->render_footer();
  }

  protected function list_kategori(){
    $list_kategori = $this->KategoriModel->get_list_kategori();
    if($list_kategori["error"] != Base_Controller::generic_error_ok){
      $this->error($list_kategori["error"]);
      return;
    }

    $data_view = array(
      "list_kategori" => $list_kategori["data"]
    );

    $this->render_header("List Kategori");
    $this->render_navbar();
    $this->load->view("v_list_kategori", $data_view);
    $this->render_footer();
=======

  function __contruct(){
    return parent::__contruct();
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
  }


  function barang(){
<<<<<<< HEAD
    $id_page = $this->input->get("id");
    if($id_page == NULL){
      $this->list_barang();
      return;
    }

    if(!$this->UserModel->is_log_in()){
      redirect(base_url("index/login"));
      return;
    }
  
    $page_data = $this->PageModel->get_page_data($id_page);
    if($page_data["error"] != PageModel::page_error_ok){
      $this->error($page_data["error"]);
      return;
    }

    $this->load->model("DataJadwalModel");
    $list_jadwal = $this->DataJadwalModel->get_list_jadwal();
    if($list_jadwal["error"] != Base_Controller::generic_error_ok)
      $this->error($list_jadwal["error"]);

    $page_data = $page_data["data"];
    $data_array = array(
      "id_page" => $id_page,
      "data_page" => $page_data["page_data"],
      "list_barang" => $page_data["barang_data"],

      "DataJadwalModel" => $this->DataJadwalModel,
      "list_jadwal" => $list_jadwal["data"]
    );

    $this->render_header("Barang");
    $this->render_navbar();
    $this->load->view("v_barang_page", $data_array);
    $this->render_footer();
  }
  
  function kategori(){
    $id_kategori = $this->input->get("id");
    if($id_kategori == NULL){
      $this->list_kategori();
      return;
    }

    $data_kategori = $this->KategoriModel->get_list_page_in_kategori($id_kategori);
    if($data_kategori["error"] != Base_Controller::generic_error_ok){
      $this->error($data_kategori["error"]);
      return;
    }

    $list_page = array();
    foreach($data_kategori["list_id_page"] as $page_data){
      $id_page = $page_data["id_page"];
      $page_data = $this->PageModel->get_page_data_with_metadata($id_page);
      if($page_data["error"] != Base_Controller::generic_error_ok)
        continue;

      array_push($list_page, $page_data["data"]);
    }

    $data_view = array(
      "intro_title" => "List Barang Kategori '{$data_kategori['data_kategori']['nama_kategori']}'",
      "data_kategori" => $data_kategori["data_kategori"],
      "data_barang" => $list_page
    );

    $kategori_name = $data_kategori["data_kategori"]["nama_kategori"];
    $this->render_header("Kategori {$kategori_name}");
    $this->render_navbar();
    $this->load->view("v_list_barang", $data_view);
    $this->render_footer();
  }


  function search(){
    $search_term = $this->input->get("search");
    if($search_term == NULL){
      $this->error(Base_Controller::generic_error_parameter_error);
      return;
    }

    $list_barang_array = array();
    $list_barang = $this->PageModel->search_barang($search_term);
    if($list_barang["error"] != Base_Controller::generic_error_ok){
      switch($list_barang["error"]){
        case PageModel::page_error_not_found:
          $list_barang_array = array();
          break;

        default:
          $this->error($list_barang["error"]);
          return;
      }
    }
    else{
      $list_barang_array = $list_barang["data"];
    }

    $data_view = array(
      "intro_title" => "Hasil Pencarian Untuk '{$search_term}'",
      "data_barang" => $list_barang_array
    );

    $this->render_header();
    $this->render_navbar();
    $this->load->view("v_list_barang", $data_view);
    $this->render_footer();
  }


  function index(){
    $this->list_kategori();
  }
} 
=======
    $this->load->model("PageModel");

    $id_page = $this->input->get("id");
    if($id_page == NULL)
      $this->error();

    $page_data = $this->PageModel->get_page_data($id_page);
    switch($page_data){
      case PageModel::page_error_not_found:
        $this->error();
        break;

      case PageModel::page_error_no_item:
        $this->error();
        break;
    }

    $data_array = array(
      "id_page" => $id_page,
      "data_page" => $page_data["page_data"],
      "list_barang" => $page_data["barang_data"]
    );

    $this->render_header("Barang");

    $this->load->view("v_barang_page", $data_array);

    $this->render_footer();
  }
}
>>>>>>> 287d50661872511a97899037362e2b035ce9316b
