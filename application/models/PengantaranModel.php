<?php


class PengantaranModel extends CI_Model{
  const pengantaran_error_no_active_pengantaran = 0x601;
  const pengantaran_error_invalid_owner = 0x602;
  const pengantaran_error_not_found = 0x603;
  const pengantaran_error_already_taken = 0x604;
  const pengantaran_error_invalid_kurir = 0x605;
  const pengantaran_error_already_done = 0x606;
  const pengantaran_error_cannot_change_status = 0x607;


  const status_idle = 0;
  const status_diproses = 1;
  const status_diantar = 2;
  const status_sampai = 3;
  const status_batal = 4;
  const status_telat = 5;
  const status_saldo_tidak_cukup = 6;
  const status_tidak_ada_barang = 7;

  const status_str_enum = array("idle", "diproses", "diantar", "sampai", "batal", "telat", "saldo_tidak_cukup", "tidak_ada_barang");

  const allowed_status_pengantaran_kurir = array(
    PengantaranModel::status_diproses,
    PengantaranModel::status_diantar,
    PengantaranModel::status_batal
  );


  function __construct(){
    parent::__construct();
  }


  function check_if_can_change_status($status_str){
    switch($status_str){
      case "diproses":
      case "diantar":
        return true;

      default:
        return false;
    }
  }


  function check_if_can_change_to_finish_status($status_str){
    switch($status_str){
      case "diantar":
        return true;

      default:
        return false;
    }
  }


  function get_status_enum($status_str){
    $search_result = array_search($status_str, PengantaranModel::status_str_enum);
    if($search_result === FALSE)
      return NULL;

    return $search_result;
  }

  function get_status_str($status_enum){
    if($status_enum < 0 || $status_enum >= sizeof(PengantaranModel::status_str_enum))
      return NULL;

    return PengantaranModel::status_str_enum[$status_enum];
  }


  function get_list_pengantaran(){
    if(!$this->UserModel->is_log_in())
      return array("error" => Base_UserModel::user_error_not_logged_in);

    $current_id_user = $this->UserModel->get_id();
    $today_time = date("o-n-j", strtotime("Today"));
    $tomorrow_time = date("o-n-j", strtotime("Tomorrow"));
    $query = "
      SELECT *
      FROM status_pengantaran
      WHERE
        id_user = {$current_id_user} AND
        tanggal_penjadwalan >= '{$today_time}' AND
        tanggal_penjadwalan <= '{$tomorrow_time}'; 
    ";

    $pengantaran_data = $this->db->query($query);

    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_no_active_pengantaran);

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $pengantaran_data->result_array()
    );
  }

  function get_history_pengantaran(){
    if(!$this->UserModel->is_log_in())
      return array("error" => Base_UserModel::user_error_not_logged_in);

    $current_id_user = $this->UserModel->get_id();
    $today_time = date("o-n-j", strtotime("Today"));
    $pengantaran_data = $this->db->query("
      SELECT *
      FROM status_pengantaran
        WHERE
          id_user = {$current_id_user} AND
          tanggal_penjadwalan <= {$today_time};
    ");

    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_no_active_pengantaran);

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $pengantaran_data->result_array()
    );
  }

  function get_pengantaran($id_pengantaran){
    if(!$this->UserModel->is_log_in())
      return array("error" => Base_UserModel::user_error_not_logged_in);

    $this->db->where("id_pengantaran", $id_pengantaran);
    $pengantaran_data = $this->db->get("status_pengantaran");
    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_not_found);

    $pengantaran_data = $pengantaran_data->row_array();
    if($pengantaran_data["id_user"] != $this->UserModel->get_id())
      return array("error" => PengantaranModel::pengantaran_error_invalid_owner);

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $pengantaran_data
    );
  }


  // only for Kurir
  function get_active_pengantaran(){
    if(!$this->KurirModel->is_log_in())
      return array("error" => KurirModel::kurir_error_not_logged_in);

    $this->db->where("id_kurir", $this->KurirModel->get_id());
    $pengantaran_data_kurir = $this->db->get("status_pengantaran");

    $this->db->where("status", "idle");
    $pengantaran_data_idle = $this->db->get("status_pengantaran");
    
    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => array(
        "idling" => $pengantaran_data_idle->result_array(),
        "pengantaran_kurir" => $pengantaran_data_kurir->result_array()
      )
    );
  }


  // only for kurir
  function set_pengantaran_status_str($id_pengantaran, $status_str){
    if(!$this->KurirModel->is_log_in())
      return array("error" => KurirModel::kurir_error_not_logged_in);

    $status_enum = $this->get_status_enum($status_str);
    if($status_enum === NULL)
      return array("error" => Base_Controller::generic_error_parameter_error);

    return $this->set_pengantaran_status($id_pengantaran, $status_enum);
  }


  // only for Kurir
  function set_pengantaran_status($id_pengantaran, $status_enum){
    if($status_enum < 0 || $status_enum >= sizeof(PengantaranModel::status_str_enum))
      return array("error" => Base_Controller::generic_error_parameter_error);

    if(!$this->KurirModel->is_log_in())
      return array("error" => KurirModel::kurir_error_not_logged_in);

    $is_allowed = array_search($status_enum, PengantaranModel::allowed_status_pengantaran_kurir);
    if($is_allowed === FALSE)
      return array("error" => Base_Controller::generic_error_parameter_error);

    $this->db->where("id_pengantaran", $id_pengantaran);
    $pengantaran_data = $this->db->get("status_pengantaran");
    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_not_found);
    
    $pengantaran_data = $pengantaran_data->row_array();
    if($pengantaran_data["id_kurir"] != $this->KurirModel->get_id())
      return array("error" => PengantaranModel::pengantaran_error_invalid_kurir);

    if(!$this->check_if_can_change_status($pengantaran_data["status"]))
      return array("error" => PengantaraModel::pengantaran_error_cannot_change_status);
    
    $new_data = array(
      "status" => PengantaranModel::status_str_enum[$status_enum]
    );

    $this->db->where("id_pengantaran", $id_pengantaran);
    $this->db->update("status_pengantaran", $new_data);
    return array(
      "error" => Base_Controller::generic_error_ok
    );
  }

  // only for kurir
  function selesaikan_pengiriman($id_pengantaran, $keterangan){
    if(!$this->KurirModel->is_log_in())
      return array("error" => KurirModel::kurir_error_not_logged_in);

    $this->db->where("id_pengantaran", $id_pengantaran);
    $pengantaran_data = $this->db->get("status_pengantaran");
    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_not_found);
    
    $pengantaran_data = $pengantaran_data->row_array();
    if($pengantaran_data["id_kurir"] != $this->KurirModel->get_id())
      return array("error" => PengantaranModel::pengantaran_error_invalid_kurir);

    if($pengantaran_data["status"] == $this->get_status_str(PengantaranModel::status_sampai))
      return array("error" => PengantaranModel::pengantaran_error_already_done);

    if(!$this->check_if_can_change_to_finish_status($pengantaran_data["status"]))
      return array("error" => PengantaranModel::pengantaran_error_cannot_change_status);

    $new_data = array(
      "status" => $this->get_status_str(PengantaranModel::status_sampai),
      "keterangan_penerima" => $keterangan
    );

    $this->db->where("id_pengantaran", $id_pengantaran);
    $this->db->update("status_pengantaran", $new_data);
    return array(
      "error" => Base_Controller::generic_error_ok
    );
  }


  // only for Kurir
  function set_pengantaran_kurir($id_pengantaran){
    if(!$this->KurirModel->is_log_in())
      return array("error" => KurirModel::kurir_error_not_logged_in);

    $this->db->where("id_pengantaran", $id_pengantaran);
    $pengantaran_data = $this->db->get("status_pengantaran");
    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_not_found);

    $pengantaran_data = $pengantaran_data->row_array();
    if($pengantaran_data["status"] != $this->get_status_str(PengantaranModel::status_idle))
      return array("error" => PengantaranModel::pengantaran_error_already_taken);

    $new_data = array(
      "status" => PengantaranModel::status_str_enum[PengantaranModel::status_diproses],
      "id_kurir" => $this->KurirModel->get_id()
    );

    $this->db->where("id_pengantaran", $id_pengantaran);
    $this->db->update("status_pengantaran", $new_data);
    return array(
      "error" => Base_Controller::generic_error_ok
    );
  }

  
  // only for kurir
  function get_pengantaran_kurir($id_pengantaran){
    if(!$this->KurirModel->is_log_in())
      return array("error" => KurirModel::kurir_error_not_logged_in);

    $this->db->where("id_pengantaran", $id_pengantaran);
    $pengantaran_data = $this->db->get("status_pengantaran");
    if($pengantaran_data->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_not_found);

    $pengantaran_data = $pengantaran_data->row_array();
    if($pengantaran_data["id_kurir"] != $this->KurirModel->get_id())
      return array("error" => PengantaranModel::pengantaran_error_invalid_kurir);

    return array(
      "error" => Base_Controller::generic_error_ok,
      "data" => $pengantaran_data
    );
  }


  // bypass
  function bypass_add_pengantaran($id_jadwal, $status = NULL){
    $this->load->model("DataJadwalModel");
    $this->load->model("KeranjangJadwalModel");

    $data_jadwal = $this->DataJadwalModel->bypass_get_data_jadwal($id_jadwal);
    if($data_jadwal["error"] != Base_Controller::generic_error_ok)
      return array("error" => $data_jadwal["error"]);

    $data_jadwal = $data_jadwal["data"];
    $new_data = array(
      "id_jadwal" => $id_jadwal,
      "tanggal_penjadwalan" => date("o-n-j", strtotime("Today")),
      "id_user" => $data_jadwal["id_user"]
    );

    if($status !== NULL){
      if($this->get_status_enum($status) === NULL)
        return array("error" => Base_Controller::generic_error_parameter_error);

      $new_data["status"] = $status;
    }

    $this->db->insert("status_pengantaran", $new_data);
    return array("error" => Base_Controller::generic_error_ok);
  }

  // bypass
  function bypass_set_status($id_pengantaran, $status_enum){
    $status_str = $this->get_status_str($status_enum);
    if($status_str === NULL)
      return array("error" => Base_Controller::generic_error_parameter_error);

    $this->db->where("id_pengantaran", $id_pengantaran);
    $data_pengantaran = $this->db->get("status_pengantaran");
    if($data_pengantaran->num_rows() <= 0)
      return array("error" => PengantaranModel::pengantaran_error_not_found);

    $new_data = array(
      "status" => $status_str
    );

    $this->db->where("id_pengantaran", $id_pengantaran);
    $this->db->update("status_pengantaran", $new_data);
    return array("error" => Base_Controller::generic_error_ok);
  }

  // bypass
  function bypass_get_list_pengantaran_yesterday($status_filter = array()){
    $date_today = date("o-n-j", strtotime("Today"));
    $date_m1day = date("o-n-j", strtotime("Yesterday"));

    $query = "
      SELECT *
      FROM status_pengantaran
      WHERE
        (tanggal_penjadwalan < '{$date_today}' AND
        tanggal_penjadwalan >= '{$date_m1day}')
    ";

    if(sizeof($status_filter) > 0){
      $query .= "AND (";

      $iter = 0;
      foreach($status_filter as $status){
        $status_str = $this->get_status_str($status);
        if($status_str === NULL)
          continue;
  
        if($iter > 0)
          $query .= "OR";
  
        $query .= "
          status = '{$status_str}'
        ";
  
        $iter++;
      }
  
      $query .= ")";
    }

    $query .= ";";
    return $this->db->query($query)->result_array();
  }
}