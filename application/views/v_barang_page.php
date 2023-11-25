<?php 
  echo "<label>id_page: {$id_page}</label><br>";
  echo "<label>Nama barang: {$data_page["nama_general_barang"]}</label><br><br>";

  foreach($list_barang as $type_idx => $barang){
    echo <<<HTMLCODE
      <label>Tipe Barang: {$barang["nama_barang"]}</label>
      <br>
      <label>Harga Barang: {$barang["harga_barang"]}</label>
      <br>
      <label>ID Barang: {$barang["id_barang"]}</label>
      <br>
      <br>
    HTMLCODE;
  }

  echo "<label>Gambar barang:</label><br>";
  foreach($list_barang as $type_idx => $barang){
    echo "<br><label>Barang: {$barang["nama_barang"]}</label><br>";
    foreach($barang["image_links"] as $images){
      echo <<<HTMLCODE
        <img src="{$images}"><br>
      HTMLCODE;
    }
  }
?>