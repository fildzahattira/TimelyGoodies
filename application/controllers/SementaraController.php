<?php


class SementaraController extends Base_Controller{

  function __construct(){
    parent::__construct();

    $this->load->model("SementaraModel");
      
  }
    function addJadwal_form(){
        $this->load->view("v_addJadwal_form");
    }
    
    function pilihan_page_product(){
        $this->load->view("v_barang_page");
    }
    
    function user_biodata(){
        $this->load->view("v_user");
    }
    
    function AddJadwalForm()
        {
            if ($this->input->post()) 
            {
                $data_input = $this->input->post();
                $selectedDays = $this->getSelectedDays($data_input);
                //  $data_input['id_user'] = $this->session->userdata('id_user');
                $data_input['list_hari'] = $selectedDays;
                $data_input['id_user'] = $this->UserModel->get_id();
                $result = $this->SementaraModel->AddJadwalForm($data_input);
                // if ($result > 0){
                //     //success
                //     $this->session->set_flashdata('msg', '<div class="alert alert-success" role="alert">
                //   SUCCESS! data saved
                //   </div>');
                // }
                // else{
                //     //err
                //     $this->session->set_flashdata('msg', '<div class="alert alert-danger" role="alert">
                //     ERROR! fail
                //   </div>');
                // }
                // var_dump($this->UserModel->get_id());
                redirect('JadwalController/jadwal');
            }
            else
            {
                
                $this->load->view('v_addJadwal_form');
            }
        }
        
    private function getSelectedDays($data_input) {
    $selectedDays = [];

    // Check if the checkbox is set for each day
    $days = ['senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu'];
    foreach ($days as $day) {
        if (isset($data_input[$day])) {
            $selectedDays[] = $day;
        }
    }

    // Convert the array to a comma-separated string
    return implode(', ', $selectedDays);
}
  
}
?>