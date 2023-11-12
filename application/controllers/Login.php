<?php 
    class Login extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();
            // $this->load->model('LoginModel');
        }
        function index()
        {
            $this->load->view('v_login');
        }
    }
?>