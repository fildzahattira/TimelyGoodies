<?php 
    class Register extends CI_Controller
    {
        function __construct()
        {
            parent::__construct();
            // $this->load->model('RegisterModel');
        }
        function index()
        {
            $this->load->view('v_register');
        }
    }
?>