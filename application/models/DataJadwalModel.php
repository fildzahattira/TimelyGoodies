<?php


class DataJadwalModel extends CI_Model{
  const data_jadwal_error_ok = 0x0;
  const data_jadwal_error_internal_error = 0x2; 

  const data_jadwal_error_not_found = 0x401;
  const data_jadwal_error_invalid_owner = 0x402;
  const data_jadwal_error_parameter_wrong = 0x403;
  const data_jadwal_error_invalid_interval = 0x404;


  const hari_senin = 0x0;
  const hari_selasa = 0x1;
  const hari_rabu = 0x2;
  const hari_kamis = 0x3;
  const hari_jumat = 0x4;
  const hari_sabtu = 0x5;
  const hari_minggu = 0x6;

  const interval_hari_enumstr = array("interval_hari", "harian");
  const hari_str = array("senin", "selasa", "rabu", "kamis", "jumat", "sabtu", "minggu");
  const hari_str_en = array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");


  const tipe_interval_harian = 0x0;
  const tipe_interval_interval_hari = 0x1;

  const tipe_interval_str = array("harian", "interval_hari");


  function __construct(){
    parent::__construct();

    $this->load->model("BarangModel");
    $this->load->model("KeranjangJadwalModel");
  }


  function hari_enum($str){
    return array_search($str, DataJadwalModel::hari_str);
  }

  function tipe_interval_enum($str){
    return array_search($str, DataJadwalModel::tipe_interval_str);
  }


  function list_hari_str_to_enum_arr($str){
    $result = array();

    $current_str = $str;
    $splitted_str = explode(",", $current_str);
    foreach($splitted_str as $hari){
      $index = $this->hari_enum($hari);
      if(!is_int($index))
        continue;

      $check_index = array_search($index, $result);
      if(is_int($check_index))
        continue;

      array_push($result, $index);
    }

    sort($result);
    return $result;
  }

  function list_hari_enum_arr_to_str($array){
    sort($array);
    
    $result = "";
    foreach($array as $hari_enum){
      if($hari_enum < 0 || $hari_enum >= sizeof(DataJadwalModel::hari_str))
        continue;

      $str_hari = DataJadwalModel::hari_str[$hari_enum];
      if(strlen($result) > 0)
        $str_hari = ',' . $str_hari;

      $result .= $str_hari;
    }

    return $result;
  }

  
  function check_interval_hari($data_str){
    $str_interval = array_search($data_str, DataJadwalModel::interval_hari_enumstr);
    return $str_interval !== FALSE;
  }

  function check_list_hari($data_str){
    return $this->list_hari_enum_arr_to_str(
      $this->list_hari_str_to_enum_arr($data_str)
    );
  }

  function check_data_validation($data){
    // check parameter "nama_jadwal"
    if(!isset($data["nama_jadwal"]) || !is_string($data["nama_jadwal"]))
      return Base_Controller::generic_error_parameter_error;
    

    // check parameter "interval_hari"
    if(isset($data["interval_hari"])){
      if(!is_int($data["interval_hari"])){
        if(is_string($data["interval_hari"]))
          $data["interval_hari"] = (int)$data["interval_hari"];
        else
          return Base_Controller::generic_error_parameter_error;
      }

      if($data["interval_hari"] <= 0)
        return Base_Controller::generic_error_parameter_error;
    }
    else
      return Base_Controller::generic_error_parameter_error;


    // check parameter "list_hari"
    if(!isset($data["list_hari"]) || !is_string($data["list_hari"]))
      return Base_Controller::generic_error_parameter_error;
    
    $new_list_hari = $this->check_list_hari($data["list_hari"]);
    if(strlen($new_list_hari) <= 0)
      return Base_Controller::generic_error_parameter_error;

    $data["list_hari"] = $new_list_hari;


    // check parameter "tipe_interval"
    if(!isset($data["tipe_interval"]) || !is_string($data["tipe_interval"]))
      return Base_Controller::generic_error_parameter_error;

    if(!$this->check_interval_hari($data["tipe_interval"]))
      return Base_Controller::generic_error_parameter_error;
    
    return $data;
  }


  public function check_owner($id_jadwal){
    if($this->KurirModel->get_id() != NULL)
      return true;

    $current_id = $this->UserModel->get_id();
    if($current_id == NULL)
      return false;

    $this->db->where("id_jadwal", $id_jadwal);
    $data_jadwal = $this->db->get("data_jadwal");
    if($data_jadwal->num_rows() <= 0)
      return false;
    
    $data_jadwal = $data_jadwal->row_array();
    return $data_jadwal["id_user"] == $current_id;
  }

  function bypass_get_data_jadwal($id_jadwal){
    $this->db->where("id_jadwal", $id_jadwal);
    $jadwal = $this->db->get("data_jadwal");
    if($jadwal->num_rows() <= 0)
      return Array("error" => DataJadwalModel::data_jadwal_error_not_found);

    return Array(
      "error" => DataJadwalModel::data_jadwal_error_ok,
      "data" => $jadwal->row_array()
    );
  }

  function get_data_jadwal($id_jadwal){
    if(!$this->check_owner($id_jadwal))
      return Array("error" => DataJadwalModel::data_jadwal_error_invalid_owner);

    return $this->bypass_get_data_jadwal($id_jadwal);
  }


  function get_list_jadwal(){
    $current_id = $this->UserModel->get_id();
    if($current_id == NULL)
      return array("error" => Base_UserModel::user_error_not_logged_in);

    $this->db->where("id_user", $current_id);
    $list_jadwal = $this->db->get("data_jadwal")->result_array();
    for($i = 0; $i < sizeof($list_jadwal); $i++){
      $jadwal_data = $list_jadwal[$i];

      $id_jadwal = $jadwal_data["id_jadwal"];

      $harga = NAN;
      $func_result = $this->KeranjangJadwalModel->get_total_harga($id_jadwal);
      if($func_result["error"] == Base_Controller::generic_error_ok)
        $harga = $func_result["data"]["harga"];

      $jadwal_data["total_harga"] = $harga;
      $list_jadwal[$i] = $jadwal_data;
    }
    
    return array(
      "error" => DataJadwalModel::data_jadwal_error_ok,
      "data" => $list_jadwal
    );
  }


  function add_data_jadwal($data_jadwal){
    if($this->UserModel->get_id() == NULL)
      return Base_UserModel::user_error_not_logged_in; 

    $checked_data = $this->check_data_validation($data_jadwal);
    if(!is_array($checked_data))
      return $checked_data;

    $data_jadwal = $checked_data;

    if($data_jadwal["tanggal_mulai"] == NULL)
      unset($data_jadwal["tanggal_mulai"]);

    $data_jadwal["id_user"] = $this->UserModel->get_id();

    $this->db->insert("data_jadwal", $data_jadwal);
    return DataJadwalModel::data_jadwal_error_ok;
  }

  function update_data_jadwal($id_jadwal, $data_jadwal){
    if($this->UserModel->get_id() == NULL)
      return Base_UserModel::user_error_not_logged_in;

    $this->db->where("id_jadwal", $id_jadwal);
    $_check = $this->db->get("data_jadwal");
    if($_check->num_rows() <= 0)
      return DataJadwalModel::data_jadwal_error_not_found;

    if(!$this->check_owner($id_jadwal))
      return DataJadwalModel::data_jadwal_error_invalid_owner;

    $checked_data = $this->check_data_validation($data_jadwal);
    if(!is_array($checked_data))
      return $checked_data;

    $data_jadwal = $checked_data;
    if($data_jadwal["tanggal_mulai"] == NULL) 
      unset($data_jadwal["tanggal_mulai"]);

    $this->db->where("id_jadwal", $id_jadwal);
    $this->db->update("data_jadwal", $data_jadwal);

    return DataJadwalModel::data_jadwal_error_ok;
  }

  function remove_data_jadwal($id_jadwal){
    // delete pada keranjang_jadwal sudah diatur di database

    if($this->UserModel->get_id() == NULL)
      return Base_UserModel::user_error_not_logged_in;
    
    $this->db->where("id_jadwal", $id_jadwal);
    $_check = $this->db->get("data_jadwal");
    if($_check->num_rows() <= 0)
      return DataJadwalModel::data_jadwal_error_not_found;
  
    if(!$this->check_owner($id_jadwal))
      return DataJadwalModel::data_jadwal_error_invalid_owner;

    $this->db->where("id_jadwal", $id_jadwal);
    $this->db->delete("data_jadwal");
    return DataJadwalModel::data_jadwal_error_ok;
  }


  function change_tipe_interval($id_jadwal, $tipe_interval, $data_interval){
    $_data_jadwal = $this->get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return $_data_jadwal["error"];

    switch($tipe_interval){
      case tipe_interval_enum::harian:{
        if(!isset($data_interval["hari"]))
          return DataJadwalModel::data_jadwal_error_parameter_wrong;
        
        $data_harian = "";
        foreach($data_interval["hari"] as $hari)
          $data_harian .= DataJadwalModel::hari_str[$hari] . ",";

        $this->db->set("tipe_interval", "harian");
        $this->db->set("list_hari", $data_harian);
      }break;

      case tipe_interval_enum::interval_hari:{
        if(!isset($data_interval["tanggal_mulai"]))
          return DataJadwalModel::data_jadwal_error_parameter_wrong;

        if(!isset($data_interval["interval_hari"]))
          return DataJadwalModel::data_jadwal_error_parameter_wrong;

        $this->db->set("tipe_interval", "interval_hari");
        $this->db->set("tanggal_mulai", $data_interval["tanggal_mulai"]);
        $this->db->set("interval_hari", $data_interval["interval_hari"]);
      }break;
    }

    $this->db->where("id_jadwal", $id_jadwal);
    $this->db->update("data_jadwal");
  }

  function get_interval($id_jadwal, $day_length, $max_get = PHP_INT_MAX, $date_from = NULL, $get_today = FALSE){
    if($date_from == NULL)
      $date_from = date("o-n-j");

    $_data_jadwal = $this->bypass_get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return Array("error" => $_data_jadwal["error"]);

    $jadwal_array = $_data_jadwal["data"];

    $date_array = array();
    $tipe_interval = $this->tipe_interval_enum($jadwal_array["tipe_interval"]);

    $last_date = strtotime("Today");
    switch($tipe_interval){
      case DataJadwalModel::tipe_interval_harian:{
        $hari_hari = $this->list_hari_str_to_enum_arr($jadwal_array["list_hari"]);

        if(sizeof($hari_hari) <= 0)
          return array("error" => DataJadwalModel::data_jadwal_error_invalid_interval);

        $current_date = strtotime($date_from);
        
        // getting last_date value
        $last_date_arr = array();
        foreach($hari_hari as $hari_enum){
          $hari_en_str = DataJadwalModel::hari_str_en[$hari_enum];
          $next_hari = strtotime("last {$hari_en_str}", $current_date);
          array_push($last_date_arr, $next_hari);
        }

        $today_date = strtotime("Today");
        $max_date = strtotime("+{$day_length} day", $current_date);
        $keep_loop = TRUE;
        while($keep_loop){
          // get day in a week
          foreach($hari_hari as $hari_enum){
            $hari_en_str = DataJadwalModel::hari_str_en[$hari_enum];
            $next_hari = strtotime("next {$hari_en_str}", $current_date);
            if($next_hari == $today_date && !$get_today)
              continue;

            if($next_hari > $max_date){
              $keep_loop = FALSE;
              continue;
            }

            array_push($date_array, $next_hari);
          }

          // splicing when there's too many values
          if(sizeof($date_array) >= $max_get)
            $keep_loop = FALSE;

          $current_date = strtotime("next Week", $current_date);
        }

        foreach($hari_hari as $hari_enum){
          $hari_en_str = DataJadwalModel::hari_str_en[$hari_enum];
          $next_hari = strtotime("{$hari_en_str}");

          if($next_hari >= $today_date){
            if($next_hari == $today_date && !$get_today)
              continue;

            if(!array_search($next_hari, $date_array))
              array_push($date_array, $next_hari);
          }
          else if($hari_hari < $today_date){
            if(!array_search($next_hari, $last_date_arr))
              array_push($last_date_arr, $next_hari);
          }
        }

        sort($last_date_arr);
        array_splice($last_date_arr, 1);
        $last_date = $last_date_arr[0];

        rsort($date_array);
        if(sizeof($date_array) >= $max_get)
          $date_array = array_splice($date_array, sizeof($date_array)-$max_get);

      }break;

      case DataJadwalModel::tipe_interval_interval_hari:{
        if($jadwal_array["interval_hari"] <= 0)
          return array("error" => DataJadwalModel::data_jadwal_error_invalid_interval);

        $current_date = strtotime("Today", strtotime($date_from));
        $max_date = strtotime("+{$day_length} day", $current_date);
        
        $iter_date = strtotime($jadwal_array["tanggal_mulai"]);
        $sum_day = $jadwal_array["interval_hari"];
        for(; $iter_date < $current_date; $iter_date = strtotime("+{$sum_day} day", $iter_date))
          ;

        $last_date = strtotime("-{$sum_day} day", $iter_date);
        $i_get = 0;
        while($iter_date <= $max_date && $i_get < $max_get){
          if($iter_date != $current_date || ($iter_date == $current_date && $get_today)){
            array_push($date_array, $iter_date);
            $i_get++;
          }

          $iter_date = strtotime("+{$sum_day} day", $iter_date);
        }

      }break;

      case NULL;
        return Array("error" => DataJadwalModel::data_jadwal_error_internal_error);
    }

    $date_array_str = array();
    foreach($date_array as $date_unix)
      array_push($date_array_str, date("o-n-j", $date_unix));

    return Array(
      "error" => DataJadwalModel::data_jadwal_error_ok, 
      "data" => array(
        "last_date" => $last_date,
        "next_array" => $date_array_str
      )
    );
  }

  function get_first_next_day($id_jadwal, $get_today = FALSE){
    return $this->get_interval($id_jadwal, PHP_INT_MAX, 1, NULL, $get_today);
  }


  function get_list_barang($id_jadwal){
    $_data_jadwal = $this->get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return $_data_jadwal["error"];
    
    $list_barang = $this->KeranjangJadwalModel->get_barang_in_jadwal($id_jadwal);

    $result = Array();
    foreach($list_barang as $barang){
      $result[$barang["date_created"]] = Array(
        "id_barang" => $barang["id_barang"],
        "jumlah" => $barang["jumlah"]
      );
    }

    sort($result);
    return array(
      "error" => DataJadwalModel::data_jadwal_error_ok,
      "data" => $result
    );
  }


  // default $jumlah, liat KeranjangJadwalModel
  function add_barang($id_jadwal, $id_barang, $jumlah = NULL){
    if(!$this->BarangModel->is_barang_exist($id_barang))
      return array("error" => BarangModel::barang_error_not_found);

    $_data_jadwal = $this->get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return array("error" => $_data_jadwal["error"]);

    $_set_result = $this->KeranjangJadwalModel->add_barang($id_jadwal, $id_barang, $jumlah);
    return $_set_result;
  }

  // default $jumlah, liat KeranjangJadwalModel
  function remove_barang($id_jadwal, $id_barang, $jumlah = NULL){
    $_data_jadwal = $this->get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return array("error" => $_data_jadwal["error"]);

    $_set_result = $this->KeranjangJadwalModel->remove_barang($id_jadwal, $id_barang, $jumlah);
    return $_set_result;
  }

  function set_barang_quantity($id_jadwal, $id_barang, $jumlah){
    $_data_jadwal = $this->get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return array("error" => $_data_jadwal["error"]);

    $_set_result = $this->KeranjangJadwalModel->set_barang_quantity($id_jadwal, $id_barang, $jumlah);
    return $_set_result;
  }

  function get_barang_quantity($id_jadwal, $id_barang){
    $_data_jadwal = $this->get_data_jadwal($id_jadwal);
    if($_data_jadwal["error"] != DataJadwalModel::data_jadwal_error_ok)
      return $_data_jadwal["error"];

    $_get_result = $this->KeranjangJadwalModel->get_barang_quantity($id_jadwal, $id_barang);
    return $_get_result;
  }


  
  function bypass_get_list_jadwal_today(){
    $today_date = strtotime("Today");
    $tomorrow_date = strtotime("Tomorrow");

    $list_jadwal_array = array();
    $list_jadwal = $this->db->get("data_jadwal")->result_array();
    foreach($list_jadwal as $jadwal){
      $next_date = $this->get_first_next_day($jadwal["id_jadwal"], TRUE);
      if($next_date["error"] != Base_Controller::generic_error_ok)
        continue;

      $next_date = $next_date["data"]["next_array"][0];
      $next_date_unix = strtotime($next_date);
      if($next_date_unix >= $today_date && $next_date_unix <= $tomorrow_date)
        array_push($list_jadwal_array, $jadwal);
    }

    return $list_jadwal_array;
  }
}
