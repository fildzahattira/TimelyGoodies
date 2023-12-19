<?php


class ApiUser extends Base_ApiUserController{
  function __construct(){
    parent::__construct();

    $this->set_user_model($this->UserModel);
  }


  protected $set_alamat_postparamlist = array("alamat");
  protected function set_alamat(){
    $alamat = $this->param_post("alamat");
    $return_value = $this->UserModel->change_alamat($alamat);
    if($return_value != Base_Controller::generic_error_ok)
      $this->throw_error_code($return_value);

    $response = array(
      "ok" => "true"
    );

    $this->send_response(200, $response);
  }
}