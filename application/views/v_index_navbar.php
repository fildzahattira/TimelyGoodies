<?php
  if($user_data->is_log_in()){
    $username = $user_data->username;
    
    $url_signout = base_url("index/signout");
    
    echo <<<HTMLCODE
      <label>Selamat Datang, </label><label><b>{$username}</ b></label>
      <br>
      <button name="signout-button" onclick="location.href = '{$url_signout}';">Signout?</button>
    HTMLCODE;
  }
  else{
    $url_signup = base_url("index/signup");
    $url_login = base_url("index/login");

    echo <<<HTMLCODE
    <label>Anda belum Login.</label>
    <br>
    <button name="signup-button" onclick="location.href = '{$url_signup}';">Signup?</button>
    <br>
    <button name="login-button" onclick="location.href = '{$url_login}'">Login?</button>
    HTMLCODE;
  }
?>