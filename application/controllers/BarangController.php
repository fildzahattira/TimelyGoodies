<?php


class BarangController extends Base_Controller{

  function __contruct(){
    return parent::__contruct();
  }


  function barang(){
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