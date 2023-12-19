<?php

class SementaraModel extends CI_Model{

  function __construct(){
    parent::__construct();
  }
  function getID($id_user)
        {
            $sql = "SELECT * FROM user_data WHERE  id_user = ?";
            $data = $this->db->query($sql, array($id_user));
            return $data->result();
        }
  function AddJadwalForm($data)
        {
            $data_insert = array(
                'id_user' => $data['id_user'],
                'nama_jadwal' => $data['nama_jadwal'],
                'tanggal_mulai' => $data['tanggal_mulai'],
                'interval_hari' =>isset($data['interval_hari']) ? $data['interval_hari'] : null,
                'list_hari' => isset($data['list_hari']) ? $data['list_hari'] : null,
                'tipe_interval' => $data['tipe_interval']
                
            );

            $this->db->insert('data_jadwal', $data_insert);
        }

}