<?php

class UserModel extends Base_UserModel{
  protected $alamat = NULL;
  public function get_alamat(){return $this->alamat;}

  protected $total_saldo = NULL;
  public function get_saldo(){return $this->total_saldo;}


  function __construct(){
    $this->_set_database("user_data");

    parent::__construct();
  }


  public function change_alamat($new_alamat){
    if(!$this->is_log_in())
      return Base_UserModel::user_error_not_logged_in;

    $this->alamat = $new_alamat;
    $new_data = array(
      "alamat" => $new_alamat
    );
    
    $this->db->where("id", $this->get_id());
    $this->db->update($this->get_database_name(), $new_data);
    return Base_UserModel::user_error_ok;
  }


  public function add_saldo($saldo){
    if(!this->is_log_in())
      return Base_UserModel::user_error_not_logged_in;
  
    $this->saldo = (int)$saldo + (int)$this->saldo;
    $new_data = array(
      "saldo" => $this->saldo
    );
  
    $this->db->where("id", $this->get_id());
    $this->db->update($this->get_database_name(), $new_data);
    return Base_UserModel::user_error_ok;
  }

  public function reduce_saldo($saldo){
    return $this->add_saldo(-$saldo);
  }


  public function bypass_reduce_saldo($id_user, $saldo){
    $this->db->where("id", $id_user);
    $user_data = $this->db->get($this->get_database_name());
    if($user_data->num_rows() <= 0)
      return Base_UserModel::user_error_no_user;

    $user_data = $user_data->row_array();
    $new_saldo = (int)$user_data["total_saldo"] - (int)$saldo;
    if($new_saldo < 0)
      return Base_UserModel::user_error_saldo_not_sufficient;

    $new_data = array(
      "total_saldo" => $new_saldo
    );

    $this->db->where("id", $id_user);
    $this->db->update($this->get_database_name(), $new_data);
    return Base_Controller::generic_error_ok;
  }
}