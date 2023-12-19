<?php

class KurirModel extends Base_UserModel{
  const kurir_error_not_logged_in = 0x801;

  function __construct(){
    $this->_set_database("kurir_data");
    
    parent::__construct();
  }
}