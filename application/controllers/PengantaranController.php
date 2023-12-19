<?php


class PengantaranController extends Base_Controller{
  function __construct(){
    parent::__construct();

    $this->load->model("PengantaranModel");
  }


  protected function list_pengantaran_var($tipe_page = "original"){
    $fungsi_get = "get_list_pengantaran";
    switch($tipe_page){
      case "original":
        break;

      case "original_kurir":
        $fungsi_get = "get_active_pengantaran";
        break;

      case "history":
        $fungsi_get = "get_history_pengantaran";
        break;

      default:
        $this->error(Base_Controller::generic_error_internal_error);
        return;
    }

    $list_pengantaran_idling_array = array();
    $list_pengantaran_array = array();
    $list_pengantaran = $this->PengantaranModel->$fungsi_get();
    switch($list_pengantaran["error"]){
      case Base_Controller::generic_error_ok:
        switch($tipe_page){
          case "original_kurir":
            $list_pengantaran_idling_array = $list_pengantaran["data"]["idling"];
            $list_pengantaran_array = $list_pengantaran["data"]["pengantaran_kurir"];
            break;
          
          default:
            $list_pengantaran_array = $list_pengantaran["data"];
            break;
        }
        break;

      case PengantaranModel::pengantaran_error_no_active_pengantaran:
        $list_pengantaran_array = array();
        break;

      default:
        $this->error($list_pengantaran["error"]);
        return;
    }

    $list_pengantaran_array = array_merge($list_pengantaran_array, $list_pengantaran_idling_array);

    $this->load->model("DataJadwalModel");
    $this->load->model("KeranjangJadwalModel");
    
    $data_view = array( 
      "tipe_page" => $tipe_page,
      "list_pengantaran" => $list_pengantaran_array,
      
      "DataJadwalModel" => $this->DataJadwalModel,
      "KeranjangJadwalModel" => $this->KeranjangJadwalModel,

      "UserModel" => $this->UserModel,
      "KurirModel"=> $this->KurirModel
    );

    $this->render_header("List Pengantaran");
    $this->render_navbar();
    $this->load->view("v_list_pengantaran", $data_view);
    $this->render_footer();
  }

  

  function list_pengantaran(){
    if($this->KurirModel->is_log_in())
      $this->list_pengantaran_var("original_kurir");
    else if($this->UserModel->is_log_in())
      $this->list_pengantaran_var("original");
    else
      $this->error(UserModel::user_error_not_logged_in);
  }


  function history_pengantaran(){
    return $this->list_pengantaran_var("history");
  }


  function mark_done(){
    if(!$this->KurirModel->is_log_in()){
      $this->error(KurirModel::kurir_error_not_logged_in);
      return;
    }

    $id_pengantaran = $this->input->get("id");
    if($id_pengantaran == NULL){
      $this->error(Base_Controller::generic_error_parameter_error);
      return;
    }

    $pengantaran_data = $this->PengantaranModel->get_pengantaran_kurir($id_pengantaran);
    if($pengantaran_data["error"] != Base_Controller::generic_error_ok){
      $this->error($pengantaran_data["error"]);
      return;
    }

    $pengantaran_data = $pengantaran_data["data"];
    if($pengantaran_data["status"] != "diantar"){
      $this->error(PengantaranModel::pengantaran_error_cannot_change_status);
      return;
    }

    $this->load->model("DataJadwalModel");
    $jadwal_data = $this->DataJadwalModel->get_data_jadwal($pengantaran_data["id_jadwal"]);
    if($jadwal_data["error"] != Base_Controller::generic_error_ok){
      $this->error($jadwal_data["error"]);
      return;
    }

    $jadwal_data = $jadwal_data["data"];

    $data_view = array(
      "pengantaran_data" => $pengantaran_data,
      "jadwal_data" => $jadwal_data
    );

    $this->render_header("Selesaikan Pesanan");
    $this->render_navbar();
    $this->load->view("v_pengantaran_selesai", $data_view);
    $this->render_footer();
  }


  function index(){
    $this->list_pengantaran();
  }
}