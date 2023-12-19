<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PengirimanController extends CI_Controller{

    public function __construct() {
        parent::__construct();
        $this->load->model('PengirimanModel');
    }

    public function index() {
        $data['status_pengantaran'] = $this->PengirimanModel->get_pengiriman();
        $this->load->view('shipments/index', $data);
    }

    public function add() {
        $id_pengantaran = $this->input->post('id_pengantaran');
        $id_pengantaran = $this->PengirimanModel->add_pengiriman($id_pengantaran);

        if ($id_pengantaran) {
            $this->update_status($id_pengantaran, 'Diantar');
            redirect('shipments');
        } else {
            echo 'Error menambahkan pengiriman';
        }
    }

    private function update_status($id_pengantaran, $status) {
        $this->PengirimanModel->update_status($id_pengantaran, $status);
    }
}